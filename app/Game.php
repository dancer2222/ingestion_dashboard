<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Game extends Model
{
    protected $table = 'game';

    public function getGameById($id)
    {
        return DB::table('game')
            ->where('id', '=',$id)->get();
    }
}
