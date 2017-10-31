<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class MediaType
 * @package App\Models
 */
class MediaType extends Model
{
    /**
     * @var string
     */
    protected $table = 'media_types';

    /**
     * @param $media_type_id
     * @return mixed
     */
    public function getTitleById($media_type_id)
    {
        return $this->select('title')
            ->where('media_type_id',$media_type_id)->get()->toArray()[0]['title'];
    }

    /**
     * @param $title
     * @return mixed
     */
    public function getIdByTitle($title)
    {
        return DB::table('media_types')
            ->select('media_type_id')
            ->where('title', $title)->get();
    }
}
