<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Member;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password as FacadesPassword;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthApiController extends Controller
{
    public function login(Request $request, $guard)
    {
        if (in_array($guard, ['admin', 'member'])) {

            $validator = validator($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string'
            ]);

            if (!$validator->fails()) {
                if (! $token = auth('api-' . $guard)->attempt($request->all())) {
                    return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
                }

                $user = $guard === 'admin'
                    ? Admin::with('roles')->where('email', '=', $request['email'])->first()
                    : Member::with('roles')->where('email', '=', $request['email'])->first();

                $user->setAttribute('token', $this->respondWithToken($token, $guard));

                return response()->json([
                    'status' => true,
                    'message' => 'login successfully',
                    'user' => $user
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => $validator->getMessageBag()->first(),
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Undefined route!'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function logout($guard)
    {
        if (in_array($guard, ['admin', 'member'])) {
            auth('api-' . $guard)->logout();
            return response()->json(['message' => 'Successfully logged out']);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Undefined route!'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    protected function respondWithToken($token, $guard)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api-' . $guard)->factory()->getTTL() * 60
        ]);
    }

    function updateProfile(Request $request, $guard)
    {
        if (in_array($guard, ['admin', 'member'])) {
            $table = Str::plural($guard);
            $validator = validator($request->all(), [
                'name' => 'required|string',
                'image' => 'nullable|image|mimes:png,jpg',
                'phone' => 'nullable|string',
                'address' => 'nullable|string',
                'email' => "required|email|unique:$table,email," . $request->user()->id,
            ]);

            if (!$validator->fails()) {
                $user = $request->user();

                if ($user->email !== $request->input('email')) {
                    $user->email_verified_at = null;
                }

                if ($request->hasFile('image')) {
                    if ($user->image) {
                        Storage::delete($user->image);
                    }
                    $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                    $request->file('image')->storeAs(path: $table, name: $imageName);
                    $request['image'] = $table . '/' . $imageName;
                }

                $updated = $user->update($request->all());
                return response()->json([
                    'status' => $updated ? true : false,
                    'message' => $updated ? 'Profile Updated Successfully' : 'Profile Updated Failed'
                ], $updated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => $validator->getMessageBag()->first(),
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Undefined route!'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    function changePassword(Request $request, $guard)
    {
        if (in_array($guard, ['admin', 'member'])) {
            $guard = 'api-' . $guard;
            $validator = validator($request->all(), [
                'password' => "required|string|current_password:$guard",
                'new_password' => [
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

            if (!$validator->fails()) {
                $request->user()->forcefill([
                    'password' => Hash::make($request->input('new_password'))
                ]);
                $isSaved = $request->user()->save();
                return response()->json([
                    'status' => $isSaved,
                    'message' => $isSaved ? "Changed Password Successfully" : "Changed Password Failed!"
                ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => $validator->getMessageBag()->first(),
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Undefined route!'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    function sendVerifyEmail(Request $request, $guard)
    {
        if (in_array($guard, ['admin', 'member'])) {

            if ($request->user()->hasVerifiedEmail()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email already verified.'
                ]);
            } else {
                $request->user('api-' . $guard)->sendEmailVerificationNotification();
                return response()->json([
                    'status' => true,
                    'message' => 'Verification email sent.',
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Undefined route!'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    function verify(EmailVerificationRequest $emailVerificationRequest)
    {
        $emailVerificationRequest->fulfill();
        return response()->json([
            'status' => true,
            'message' => 'Email successfully verified.'
        ]);
    }

    function sendResetEmail(Request $request, $guard)
    {
        if (in_array($guard, ['admin', 'member'])) {
            $borker = Str::plural($guard);

            $validator = validator($request->all(), [
                'email' => 'required|email|exists:' . $borker
            ]);

            if (!$validator->fails()) {
                $status = FacadesPassword::broker($borker)->sendResetLink($request->only('email'));
                return response()->json([
                    'status' => $status === FacadesPassword::RESET_LINK_SENT ? true : false,
                    'message' => __($status)
                ], $status === FacadesPassword::RESET_LINK_SENT ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => $validator->getMessageBag()->first(),
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Undefined route!'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function passwordReset(Request $request, $token)
    {
        return response()->json([
            'email' => $request->input('email'),
            'token' => $token
        ]);
    }

    function recoverPassword(Request $request, $guard)
    {
        if (in_array($guard,  ['admin', 'member'])) {
            $validator = validator($request->all(), [
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

            if (!$validator->fails()) {
                $broker = Str::plural($guard);

                $status = FacadesPassword::broker($broker)->reset(
                    $request->only('email', 'password', 'password_confirmation', 'token'),
                    function ($user, $password) {
                        $user->forceFill([
                            'password' => Hash::make($password),
                        ])->save();
                        event(new ResetPassword($user));
                    }
                );

                return response()->json([
                    'status' => $status === FacadesPassword::PASSWORD_RESET ? true : false,
                    'message' => __($status)
                ], $status === FacadesPassword::PASSWORD_RESET ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => $validator->getMessageBag()->first(),
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Undefined route!'
            ], Response::HTTP_NOT_FOUND);
        }
    }
}