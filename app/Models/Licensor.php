<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
            ->where('id',$id)->get()->toArray()[0]['name'];
    }
}
