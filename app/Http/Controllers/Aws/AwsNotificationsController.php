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
        try {
            $notifications = new AwsNotifications();
            $notifications->store($notifications->parse($notifications->read()));
        } catch (\Exception $exception) {

            return view('aws.notifications')->withErrors($exception->getMessage());
        }

        return view('aws.notifications', ['products' => AwsNotication::orderBy('eventTime', 'desc')->paginate(10)]);
    }

    /**
     * @param Request $request
     * @return $this|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getInfo(Request $request)
    {
        if (isset($request->date) && isset($request->bucket)) {
            if (!AwsNotication::where('eventTime', Carbon::parse($request->date))->where('bucket',
                $request->bucket)->get()->isEmpty()) {
                return view('aws.notifications', [
                    'products' => AwsNotication::where('eventTime', Carbon::parse($request->date))->where('bucket',
                        $request->bucket)->get()
                ]);
            } else {
                return view('aws.notifications')->withErrors('Not Found notification for this date ' . $request->date);
            }
        }

        return view('aws.notifications')->withErrors('Not enough incoming data');
    }
}
