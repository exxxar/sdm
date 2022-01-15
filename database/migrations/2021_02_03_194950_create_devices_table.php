<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('serial', 255);
            $table->string('ip', 255);
            $table->bigInteger('device_group_id')->nullable();
            $table->bigInteger('device_boundary_id')->nullable();
            $table->float('lat')->nullable();
            $table->float('lon')->nullable();
            $table->bigInteger('device_type_id');
            $table->bigInteger('region_id')->nullable();
            $table->string('connection', 255)->nullable();
            $table->string('port', 255)->nullable();
            $table->string('login', 255);
            $table->string('password', 255);
            $table->string('secret', 255);
            $table->date('installation_date')->nullable();
            $table->date('withdrawal_date')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->json('properties')->nullable();
            $table->boolean('mobile');
            $table->boolean('movable');
            $table->boolean('is_active')->default(false);
            $table->unsignedInteger('location_id')->nullable();
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
        Schema::dropIfExists('devices');
    }
}
