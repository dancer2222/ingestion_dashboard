<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Support\Facades\Storage;

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
        $commands = [];
        $errors = [];
        $configName = config('api.ingestion.tools.config_file_name');
        $config = @unserialize(Storage::get("tmp/$configName"));

        if (!$config || !is_array($config)) {
            $errors[] = "Config can't be read.";
            $config = [];
        }

        if ($request->has('type') && $request->has('action')) {

            $commands = array_where($config['params'], function($value, $key) use ($request) {

                preg_match("/^$request->type:$request->action:.*/", $key, $matches);

                return $matches;
            });
        }

        return view('tools.selectMediaTypeTools', ['data' => $config, 'commands' => $commands])->withErrors($errors);
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
            'type'   => $command[0],
            'action' => $command[1],
            'name'   => $command[2]
        ];

        $options = $request->has('options') ? $request->options : [];

        foreach ($options as $param => $value) {
            $message['extra']['options'][$param] = $value;
        }

        $arguments = $request->has('arguments') ? $request->arguments : [];

        foreach ($arguments as $param => $value) {
            $message['extra']['arguments'][] = $param;
        }

        try {
            $message = \GuzzleHttp\json_encode($message);

            Amqp::publish('ingestion-tools', (string)$message, ['queue' => 'ingestion-tools']);
        } catch (\Exception $exception) {

            return back()->with(['message' => $exception->getMessage(), 'status' => 'error']);
        }

        return back()->with('message', $message . ' - message published');
    }
}
