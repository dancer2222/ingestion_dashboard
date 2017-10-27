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
        return DB::table('licensors')
            ->select('name')
            ->where('id', '=',$id)->get();
    }
}
