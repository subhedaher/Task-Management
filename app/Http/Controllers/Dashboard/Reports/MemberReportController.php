<?php

namespace App\Http\Controllers\Dashboard\Reports;

use App\Http\Resources\MemberResource;
use App\Http\Resources\ProductivityResource;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Member;
use App\Models\Productivity;
use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

class MemberReportController extends BaseController
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('Report-Members', user());
        $members = Member::with(['designation'])->get();
        $departments = Department::select(['id', 'name'])->get();
        $designations = Designation::select(['id', 'name'])->get();
        return view('dashboard.reports.members.index', ['members' => $members, 'departments' => $departments, 'designations' => $designations]);
    }

    public function downloadPdf(Request $request)
    {
        $this->authorize('Report-Members', user());
        $department = $request->query('department', 'all');
        $designation = $request->query('designation', 'all');

        $query = Member::query();

        if ($department !== 'all') {
            $query->whereHas('designation.department', function ($q) use ($department) {
                $q->where('name', $department);
            });
        }

        if ($designation !== 'all') {
            $query->whereHas('designation', function ($q) use ($designation) {
                $q->where('name', $designation);
            });
        }

        $members = $query->get();

        $pdf = PDF::loadView('dashboard.reports.members.pdf.member', ['members' => $members]);

        return $pdf->stream('members_report.pdf');
    }

    public function member(Member $member)
    {
        $this->authorize('Report-Members', user());
        $productivities = $member->productivities;
        return view('dashboard.reports.members.show', ['member' => $member, 'productivities' => $productivities]);
    }

    public function memberpdf($memberId)
    {
        $this->authorize('Report-Members', user());
        $member = Member::with(['productivities'])->findOrFail($memberId);
        $productivities = $member->productivities;
        $pdf = PDF::loadView('dashboard.reports.members.pdf.show', ['member' => $member, 'productivities' => $productivities]);
        return $pdf->stream('member_report_' . $member->name . '.pdf');
    }
}
