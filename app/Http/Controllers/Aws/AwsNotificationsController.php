<?php

namespace App\Http\Controllers\Aws;

use App\Http\Controllers\Controller;
use Ingestion\Parse\AwsNotifications;


/**
 * Class AwsNotificationsController
 * @package App\Http\Controllers\Aws
 */
class AwsNotificationsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        $notifications = new AwsNotifications();

        try {
            $products = $notifications->parse($notifications->read());
        } catch (\Exception $exception) {
            return back()->with('message', $exception->getMessage());
        }

        return view('aws.notifications', ['products' => $products]);
    }
}
