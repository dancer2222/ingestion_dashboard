<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Licensor
 * @package App\Models
 */
class Licensor extends Model
{
    /**
     * @var string
     */
    protected $table = 'licensors';

    /**
     * @param $id
     * @return mixed
     */
    public function getNameLicensorById($id)
    {
        return $this->select('name')
            ->where('id', $id)
            ->first();
    }
}
