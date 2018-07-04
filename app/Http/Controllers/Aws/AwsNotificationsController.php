<?php

namespace App\Http\Controllers\Aws;

use App\Http\Controllers\Controller;
use App\Models\AwsNotication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ingestion\Parse\AwsNotifications;

/**
 * Class AwsNotificationsController
 * @package App\Http\Controllers\Aws
 */
class AwsNotificationsController extends Controller
{
    /**
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $nowDate = now()->format('Y-m-d');
        $fromDate = request('from_date', $nowDate);
        $toDate = request('to_date', $nowDate);
        $bucket = request('bucket', false);

        $notifications = AwsNotication::where('eventTime', '>=', $fromDate)
            ->where('eventTime', '<=', $toDate)
            ->where('bucket', $bucket)
            ->orderBy('eventTime', 'desc')
            ->paginate(15);

        return view('aws.notifications', ['notifications' => $notifications]);
    }
}
