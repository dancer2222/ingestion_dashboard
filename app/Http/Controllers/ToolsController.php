<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ingestion\Tools\RabbitMQ;

class ToolsController extends Controller
{
    public function index()
    {
        return view('tools.selectMediaTypeTools');
    }

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
