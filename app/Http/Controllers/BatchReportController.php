<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ingestion\Reports\BatchReport;

class BatchReportController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->batch_id)) {
            if (!is_numeric($request->batch_id)) {
                $message = 'This [batch_id] = ['.$request->batch_id.'] must contain only digits';
                return back()->with('message', $message);
            }
            try {
                $batchReport = new BatchReport($request->batch_id);
                $message = $batchReport->generate();
                return back()->with('message', $message);
            } catch (\Exception $exception) {
                return back()->with('message', $exception);
            }
        }

        return back()->with('message','Pls input batch_id');
    }
}
