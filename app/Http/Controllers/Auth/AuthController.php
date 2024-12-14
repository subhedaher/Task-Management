<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password as FacadesPassword;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    function showLogin($guard)
    {
        $validaor = Validator(['guard' => $guard], [
            'guard' => 'required|string|in:admin,member'
        ]);
        if (!$validaor->fails()) {
            session()->put('guard', $guard);
            return view('dashboard.auth.login');
        }
        abort(Response::HTTP_NOT_FOUND);
    }

    function login(LoginRequest $loginRequest)
    {

        $loginRequest->validated();

        if (Auth::guard(session('guard'))->attempt($loginRequest->only(['email', 'password']), $loginRequest->input('remember'))) {
            return redirect()->route('dashboard.home')->with('message', 'Login Successfully');
        } else {
            return redirect()->back()->with('message', 'Login Failed');
        }
    }

    function logout(Request $request)
    {
        $guard = session('guard');
        auth($guard)->logout();
        $request->session()->invalidate();
        session()->remove('guard');
        return redirect()->route('auth.showlogin', $guard);
    }

    function updatePassword(Request $request)
    {
        $guard = session('guard');
        $request->validate([
            'oldpassword' => 'required|string|current_password:' . $guard,
            'newpassword' => [
                'required',
                'string',
                Password::min(8)
                    ->letters()
                    ->uncompromised()
                    ->symbols()
                    ->mixedCase(),
                'confirmed'
            ]
        ], [
            'oldpassword.required' => 'the old password feild is required',
            'newpassword.required' => 'the new password feild is required',
        ]);

        $request->user()->forceFill([
            'password' => Hash::make($request->input('newpassword'))
        ])->save();
        return redirect()->back()->with('message', 'Change Password Successfully');
    }

    function forgotPassword()
    {
        return view('dashboard.auth.forgot-password');
    }

    function sendResetEmail(Request $request)
    {
        $borker = Str::plural(session('guard'));
        $request->validate([
            'email' => 'required|email|exists:' . $borker
        ]);

        $status = FacadesPassword::broker($borker)->sendResetLink($request->only('email'));
        return redirect()->back()->with($status === FacadesPassword::RESET_LINK_SENT ? 'success' : 'error', __($status));
    }

    function recoverPassword(Request $request, $token)
    {
        return view('dashboard.auth.recover-password', ['email' => $request->input('email'), 'token' => $token]);
    }

    function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:password_reset_tokens,email',
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->letters()
                    ->uncompromised()
                    ->symbols()
                    ->mixedCase(),
                'confirmed'
            ]
        ]);

        $guard = null;
        $admin = Admin::where('email', '=', $request->input('email'))->first();
        if ($admin) {
            $guard = 'admin';
        } else {
            $guard = 'member';
        }

        $broker = Str::plural(session('guard'));

        $status = FacadesPassword::broker($broker)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
                event(new ResetPassword($user));
            }
        );

        return redirect()->route('auth.showlogin', $guard)->with($status === FacadesPassword::PASSWORD_RESET ? 'success' : 'error', __($status));
    }

    function showEmailVerification()
    {
        return view('dashboard.auth.email-verification');
    }

    function sendVerifyEmail(Request $request)
    {
        $request->user(session('guard'))->sendEmailVerificationNotification();
        return redirect()->back()->with('success', 'Send Email Verifcation Successfully');
    }

    function verify(EmailVerificationRequest $emailVerificationRequest)
    {
        $emailVerificationRequest->fulfill();
        return redirect()->route('dashboard.home');
    }

    function editUser(Request $request)
    {
        return view('dashboard.auth.edit-profile', ['user' => $request->user()]);
    }

    function updateUser(Request $request)
    {
        $table = Str::plural(session('guard'));
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'email' => "required|email|unique:$table,email," . $request->user()->id,
        ]);

        $user = $request->user();

        if ($user->email !== $request->input('email')) {
            $user->email_verified_at = null;
        }

        $user->forcefill([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ])->save();

        return redirect()->back()->with('message', 'Update Profile Successfully');
    }

    public function saveImage(Request $request)
    {
        $request->validate([
            'imageUser' => 'nullable|image|mimes:png,jpg'
        ]);

        if ($request->hasFile('imageUser')) {
            if (auth(session('guard'))->user()->image) {
                Storage::delete(auth(session('guard'))->user()->image);
            }

            $imageFile = $request->file('imageUser');
            $name = $imageFile->store(Str::plural(session('guard')), ['disk' => 'public']);
            auth(session('guard'))->user()->image = $name;
            auth(session('guard'))->user()->save();
        }
        return redirect()->back()->with('message', 'Change Successfully');
    }

    public function readNotification()
    {
        auth(session('guard'))->user()->unreadNotifications->markAsRead();
        return response()->json([
            'message' => 'seccess'
        ]);
    }

    public function notifications()
    {
        user()->unreadNotifications->markAsRead();
        return view('dashboard.auth.notifications');
    }
}
