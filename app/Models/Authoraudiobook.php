<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Authoraudiobook
 * @package App\Models
 */
class Authoraudiobook extends Model
{
    protected $table = 'author_audio_book';

    /**
     * @param $id
     * @return mixed
     */
    public function setStatus($id, $status)
    {
        $this->timestamps = false;

        return $this->where('id', $id)->update(['status' => $status]);
    }
}
