<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AwsNotication extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql_local_ingestion';

    /**
     * @var string
     */
    protected $table = 'aws_notifications';

    /**
     * @var array
     */
    protected $fillable =
        [
            'date',
            'event_time',
            'event_name',
            'bucket',
            'key',
            'size'
        ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
