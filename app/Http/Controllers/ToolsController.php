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

                $items = explode(':', $key);
                $type = strpos($items[0], $request->type);
                $action = strpos($items[1], $request->action);

                return $type !== false && $action !== false && $action === 0;
            });
        }

        return view('tools.selectMediaTypeTools', ['data' => $data , 'commands' => $commands]);
    }

    /**
     * @param Request $request
     *
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function doIt(Request $request)
    {
        $message = [];
        $command = explode(":", $request->command);

        $message['message'] = [
            'type' => $command[0],
            'action' => $command[1],
            'name' => $command[2]
            ];

        $options = $request->has('params') ? $request->params : [];

        foreach ($options as $param => $value) {
            $message['extra']['options'][$param] = $value;
        }

        $arguments = $request->has('arguments') ? $request->arguments : [];

        foreach ($arguments as $param => $value) {
            $message['extra']['arguments'][] = $param;
        }

        $message = \GuzzleHttp\json_encode($message);

        try {
            $rabbit = new RabbitMQ(config('main.rabbitMq'));
            $rabbit->putMessage((string)$message, config('main.rabbitMq'))->closeConnection();
        } catch (\Exception $exception) {

            return back()->with(['message' => $exception->getMessage(), 'status' => 'error']);
        }

        return back()->with('message', $message);
    }
}
