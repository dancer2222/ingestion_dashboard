<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Licensor extends Model
{
    protected $table = 'licensors';

    public function getNameLicensorById($id)
    {
        return $name = DB::table('licensors')
            ->select('name')
            ->where('id', '=',$id)->get();
    }

}
