<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoundariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('boundaries', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->bigInteger('boundary_group_id')->nullable();
            $table->bigInteger('region_id')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('speed_mode')->nullable();
            $table->float('lat')->nullable();
            $table->float('lon')->nullable();
            $table->boolean('mobile');
            $table->boolean('movable');
            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('boundaries');
    }
}
