<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFailedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (app()->environment('local')) {
            Schema::create('ingestion_failed_items', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('batch_id')->unsigned();
                $table->string('item_id', 25);
                $table->string('reason', 250);
                $table->dateTime('time')->default(now());
                $table->string('level', 25);
                $table->string('error_code', 100)->default(null);
                $table->string('status', 64)->default('active');
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
            Schema::dropIfExists('ingestion_failed_items');
        }
    }
}
