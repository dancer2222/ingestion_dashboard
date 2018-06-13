<?php

namespace App\Http\Controllers\Ingestion\Rabbitmq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ingestion\Rabbitmq\IndexationRequest;
use Illuminate\Queue\QueueManager;

class IndexationController extends Controller
{
    /**
     * The message pattern for sprintf
     */
    const MESSAGE = '{"message":{"action":"%1$s","version":4,"id":"%2$s","objectType":"%3$s","extra":[]}}';

    /**
     * Display a form to send messages to queue.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('template_v2.ingestion.Rabbitmq.indexation');
    }

    /**
     * Send a message in queue.
     *
     * @param $request IndexationRequest
     * @param $queueManager QueueManager
     * @return \Illuminate\Http\Response
     */
    public function store(IndexationRequest $request, QueueManager $queueManager)
    {
        $action = $request->action;
        $type = $request->type;
        $ids = explode(',', str_replace(' ', '', $request->id));

        foreach ($ids as $id) {
            if ($id) {
                $message = sprintf(self::MESSAGE, $action, $id, $type);

                try {
                    $queueManager->connection('indexation')->pushRaw($message,'batch-to-index');
                } catch (\Exception $e) {
                    return back()->withErrors($e->getMessage())->withInput();
                }
            }
        }

        $vhost = config('queue.connections.indexation.vhost');
        $queue = config('queue.connections.indexation.queue');

        return view('template_v2.ingestion.Rabbitmq.indexation')
            ->with('status', "Messages were successfully sent to the queue: '$queue' (vhost: $vhost)");
    }
}
