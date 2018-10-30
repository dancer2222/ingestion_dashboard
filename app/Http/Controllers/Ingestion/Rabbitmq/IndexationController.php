<?php

namespace App\Http\Controllers\Ingestion\Rabbitmq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ingestion\Rabbitmq\IndexationRequest;
use Ingestion\Rabbitmq\Indexation;

class IndexationController extends Controller
{
    /**
     * The message pattern for sprintf
     */
    const MESSAGE = '{"message":{"action":"%1$s","version":4,"id":"%2$s","objectType":"%3$s","extra":[]}}';

    /**
     * @var string|array
     */
    private $errors = [];

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('template_v2.ingestion.Rabbitmq.indexation',
            ['single' => Indexation::ALLOWED_TYPES_SINGLE, 'batch' => Indexation::ALLOWED_TYPES_BATCH]
        );
    }

    /**
     * @param IndexationRequest $request
     * @param Indexation $indexation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(IndexationRequest $request, Indexation $indexation)
    {
        $messagesCount = 0;

        try {
            $messagesCount = $indexation->push($request->action, $request->type, $request->id);
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }

        $host = config('queue.connections.indexation.host');
        $vhost = config('queue.connections.indexation.vhost');
        $queue = config('queue.connections.indexation.queue');

        return redirect()->back()
            ->with('message', "$messagesCount messages were sent to the queue: '$queue' (vhost: $vhost, host: $host)")
            ->with($this->errors);
    }
}
