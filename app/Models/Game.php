<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Game extends Model
{
    protected $table = 'game';

    public function getById($id)
    {
        return DB::table('game')
            ->where('id', '=',$id)->get();
    }
}
