<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QaBatch
 * @package App\Models
 */
class QaBatch extends Model
{
    /**
     * @var string
     */
    protected $table = 'qa_batches';
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mediaType()
    {
        return $this->belongsTo(MediaType::class, 'media_type_id', 'media_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {
        return $this->belongsTo(DataSourceProvider::class, 'data_source_provider_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productAudiobooks()
    {
        return $this->hasMany(ProductAudioBook::class, 'batch_id', 'id');
    }

    /**
     * @param $id
     * @return null
     */
    public function getAllByBatchId($id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function books()
    {
        return $this->hasMany(Book::class, 'batch_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function audiobooks()
    {
        return $this->hasMany(Audiobook::class, 'batch_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movies()
    {
        return $this->hasMany(Movie::class, 'batch_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function albums()
    {
        return $this->hasMany(Album::class, 'batch_id', 'id');
    }
}
