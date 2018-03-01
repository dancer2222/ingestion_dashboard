<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AwsNotication extends Model
{
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
            'eventTime',
            'eventName',
            'bucket',
            'key',
            'size'
        ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
