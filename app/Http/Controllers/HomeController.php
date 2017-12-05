<?php

namespace App\Http\Controllers;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $connection = new AMQPStreamConnection('10.0.10.63', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('ingestion-tools', false, true, false, false);

        $msg = new AMQPMessage('{ "message": { "type":"core", "action":"fix", "name": "something"} }');
        $channel->basic_publish($msg, '', 'ingestion-tools');

        $channel->close();
        $connection->close();
//
//        die;
        return view('home');
    }
}
