<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MediaLanguage
 * @package App\Models
 */
class MediaLanguage extends Model
{
    /**
     * @var string
     */
    protected $table = 'media_language';

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getBookLanguageId($id)
    {
        $a = $this->where('media_id',$id)->first();

        return $a ==null ? $a : $a->toArray();
    }
}
