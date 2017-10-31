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
    public function getById($id)
    {
        return $this->where('id',$id)->first()->toArray();
    }
}
