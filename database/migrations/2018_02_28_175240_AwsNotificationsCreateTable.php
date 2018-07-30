<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AwsNotificationsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (app()->environment('local')) {
            Schema::create('aws_notifications', function (Blueprint $table) {
                $table->increments('id');
                $table->date('event_time');
                $table->string('event_name', 255);
                $table->string('bucket', 50);
                $table->text('key');
                $table->string('size', 30);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (app()->environment('local')) {
            Schema::dropIfExists('aws_notifications');
        }
    }
}
