<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('boundary_id')->nullable();
            $table->integer('device_id')->nullable();
            $table->integer('malfunction_id')->nullable();
            $table->integer('user_id');
            $table->integer('report_id')->nullable();
            $table->integer('responsible_id')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('executed_at')->nullable();
            $table->text('note')->nullable();
            $table->json('notes')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->enum('status', ['Актуальные', 'В работе', 'Готово']);
            $table->string('custom_reason', 255)->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
