<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MediaType extends Model
{
    protected $table = 'media_types';

    public function getTitleById($media_type_id)
    {
        return DB::table('media_types')
            ->select('title')
            ->where('media_type_id', '=',$media_type_id)->get();
    }

    public function getIdByTitle($title)
    {
        return DB::table('media_types')
            ->select('media_type_id')
            ->where('title', '=', $title)->get();
    }
}
