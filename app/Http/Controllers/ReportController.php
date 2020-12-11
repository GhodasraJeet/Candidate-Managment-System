<?php

namespace App\Http\Controllers;

use App\DataTables\UsersReportDataTable;
use App\DataTables\InterviewReportDataTable;

class ReportController extends Controller
{
    // Report of Candidates Controller

    public function viewCandidate(InterviewReportDataTable $datatable)
    {
        return $datatable->render('admin.report.candidate_report');
    }

    // Report of HR Controller

    public function viewHr(UsersReportDataTable $datatable)
    {
        return $datatable->render('admin.report.hr_report');
    }
}
