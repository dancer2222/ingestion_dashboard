<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MaLanguage
 * @package App\Models
 */
class MaLanguage extends Model
{
    /**
     * @var string
     */
    protected $table = 'ma_language';

    /**
     * @param $id
     *
     * @return mixed
     *
     */
    public function getLanguageNameByLanguageId($id)
    {
        $a = $this->where('id', $id)->first();

        return $a == null ? $a : $a->toArray();
    }
}
