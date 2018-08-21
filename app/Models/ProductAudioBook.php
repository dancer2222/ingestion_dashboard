<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAudioBook extends Model
{
    /**
     * @var string
     */
    protected $table = 'product_audio_book';
    protected $primaryKey = 'seq_id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function audiobook()
    {
        $this->primaryKey = 'id';
        $this->incrementing = false;

        $relation = $this->belongsToMany(
            Audiobook::class,
            'audio_book_products',
            'product_id',
            'audio_book_id',
            'id',
            'id'
        );

        $this->primaryKey = 'seq_id';
        $this->incrementing = true;

        return $relation;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getInfoByProductId($id)
    {
        return $this->where('id', $id)->get();
    }
}
