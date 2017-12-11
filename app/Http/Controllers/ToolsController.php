<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ingestion\Tools\RabbitMQ;

/**
 * Class ToolsController
 * @package App\Http\Controllers
 */
class ToolsController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = include public_path().'/someconfig.php';
        $commands = [];
        if ($request->has('type') && $request->has('action')) {
            $commands = array_where($data['commands'], function($value, $key) use ($request) {
                return strpos($key, $request->type) !== false && strpos($key, $request->action) !== false;
            });
        }

        return view('tools.selectMediaTypeTools', ['data' => $data , 'commands' => $commands]);
    }

    /**
     * @param Request $request
     *
     * @return bool|\Exception
     */
    public function doIt(Request $request)
    {
        try {
            $rabbit = new RabbitMQ(config('main.rabbitMq'));
            $rabbit->putMessage($request->message)->closeConnection();
        } catch (\Exception $exception) {
            return $exception;
        }

        return true;
    }
}
