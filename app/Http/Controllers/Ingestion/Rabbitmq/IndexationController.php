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
     * @var string|array
     */
    private $errors;

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
        $messagesCount = 0;
        $action = $request->action;
        $type = $request->type;
        $ids = explode(',', str_replace(' ', '', $request->id));

        foreach ($ids as $id) {
            if ($id) {
                $message = sprintf(self::MESSAGE, $action, $id, $type);

                try {
                    $result = $queueManager->connection('indexation')->pushRaw(
                        $message,
                        config('queue.connections.indexation.queue')
                    );

                    if ($result) {
                        $messagesCount++;
                    }
                } catch (\Exception $e) {
                    $this->errors[] = $e->getMessage();
                }
            }
        }

        $host = config('queue.connections.indexation.host');
        $vhost = config('queue.connections.indexation.vhost');
        $queue = config('queue.connections.indexation.queue');

        return view('template_v2.ingestion.Rabbitmq.indexation', [
            'status' => "$messagesCount messages were successfully sent to the queue: '$queue' (vhost: $vhost, host: $host)",
        ])->withErrors($this->errors);
    }
}
