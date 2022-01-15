<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHasDeviceGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_device_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id" )->nullable();
          //  $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger("device_group_id" )->nullable();
          //  $table->foreign('device_group_id')->references('id')->on('device_groups');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_has_device_groups');
    }
}
