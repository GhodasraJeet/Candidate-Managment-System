<?php

namespace App\Http\Controllers;


use Mail;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Jobs\SendWelcomeEmail;
use App\Exports\CategorysExport;
use Illuminate\Support\Facades\Log;

class FaltuController extends Controller
{
    private $excel;

    public function export(Request $request){
        $user=$request->session()->get('email');
        $token = "Authorization: Bearer ".$user->token->token;
        $page=$request->page;
        $fileName = Carbon::now()->format('YmdHs');
        if ($request->input('exportcsv') != null ){
         return (new CategorysExport($page,$token))->download($fileName.'.csv',Excel::CSV);
        }
        if($request->input('exportpdf')!=null){
            return (new CategorysExport($page,$token))->download($fileName.'.pdf',Excel::DOMPDF);
        }
        if($request->input('exportexcel')!=null){
            return (new CategorysExport($page,$token))->download($fileName.'.xlsx');
        }
    }

}
