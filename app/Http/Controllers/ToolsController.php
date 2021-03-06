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
        $configPath = "tmp/$configName";

        if (Storage::exists($configPath)) {
            $config = @unserialize(Storage::get($configPath));
        }

        if (!isset($config) || !is_array($config)) {
            $errors[] = "Config can't be read.";
            $config = [];
        }

        if ($request->has('type') && $request->has('action') && isset($config['params'])) {

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

    /**
     * Gets uploaded file, process it and return data separated by a comma
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function optionValueFromFile(Request $request)
    {
        if ($request->hasFile('optionData') && $request->file('optionData')->isValid()) {
            $file = $request->file('optionData');

            $data = file_get_contents($file->getRealPath());
            $patterns = [
                '/(\s+)/',
                '/(\R+)/',
                '/(\r|\n)/',
                '/(,+)/',
            ];
            $data = preg_replace($patterns, ',', $data);
            $data = trim($data, ' ,\r\n');

            return response()->json(['data' => $data], 200);
        }
    }
}
