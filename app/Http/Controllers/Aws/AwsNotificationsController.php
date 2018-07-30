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
        $builder = AwsNotication::orderBy('event_time', 'desc');

        if ($fromDate = request('from_date')) {
            $builder->where('event_time', '>=', $fromDate);
        }

        if ($toDate = request('to_date')) {
            $builder->where('event_time', '<=', $toDate);
        }

        if ($bucket = request('bucket')) {
            $builder->where('bucket', $bucket);
        }

        $notifications = $builder->paginate(15);

        return view('aws.notifications', ['notifications' => $notifications]);
    }
}
