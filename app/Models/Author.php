<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Author
 * @package App\Models
 */
class Author extends Model
{
    protected $table = 'author';

    /**
     * @param $id
     * @return mixed
     */
    public function setStatus($id, $status)
    {
        $this->timestamps = false;

        return $this->where('id', $id)->update(['status' => $status]);
    }
}
