<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Game
 * @package App\Models
 */
class Game extends Model
{
    /**
     * @var string
     */
    protected $table = 'game';

    /**
     * @param $id
     * @return mixed
     */
    public function getInfoById($id)
    {
        return $this->where('id', $id)->get();
    }

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
