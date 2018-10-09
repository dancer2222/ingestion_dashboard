<?php
/**
 * Created by PhpStorm.
 * User: dancer
 * Date: 09.10.18
 * Time: 15:03
 */

namespace Ingestion\Logs;


class UsersActivity extends Logs
{
    /**
     * @var
     */
    private $id, $userName, $message;

    public function getInfo($id, $userName, $message) {
        $this->id = $id;
        $this->userName = $userName;
        $this->message = $message;
    }

    public function message() {
        
    }
}