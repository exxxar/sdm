<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoundarySchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boundary_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer("type")->default(0);
            $table->timestamp("start_at")->nullable();
            $table->timestamp("end_at")->nullable();
            $table->unsignedInteger("boundary_id")->nullable();
            $table->boolean("is_installed")->default(false)->comment("Устанавливался: да \ нет");
            $table->string("address")->default("");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boundaries_schedules');
    }
}
