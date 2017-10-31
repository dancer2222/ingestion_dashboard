<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        return $this->where('id',$id)->get()->toArray()[0];
    }
}
