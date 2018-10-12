<?php

namespace Ingestion\Logs;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Class UserActivityStatus
 * @package Ingestion\Logs
 */
class UserActivityLogs
{
    /**
     * @param $id
     * @param $mediaType
     * @param $message
     */
    private function writeLog($id, $mediaType, $message)
    {
        Log::channel('userActivity')->info('User - ' .
            Auth::user()->name .
            ' ' .
            Auth::user()->email .
            $message .
            $id . ' - ' . $mediaType);
    }

    /**
     * @param $id
     * @param $mediaType
     */
    public function updateMediaStatus($id, $mediaType)
    {
        $this->writeLog($id, $mediaType, ' status updated id(s): ');
    }

    /**
     * @param $id
     * @param $mediaType
     */
    public function updateBlacklistStatus($id, $mediaType)
    {
        $this->writeLog($id, $mediaType, ' Blacklist updated id(s): ');
    }
}
