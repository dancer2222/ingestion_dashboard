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
    public static function getInfoById($id)
    {
        return DB::table('game')->where('id',$id)->get();
    }
}
