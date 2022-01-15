<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('period', 255);
            $table->timestamp('start_period_date')->nullable();
            $table->timestamp('end_period_date')->nullable();
            $table->string('regularity', 255)->nullable();
            $table->string('parameter', 255);
            $table->string('report_of', 255)->comment('Отчёт по');
            $table->json('recipients')->nullable();
            $table->json('object')->nullable();
            $table->boolean('automatic')->default(false)->comment('Автоматический отчёт');
            $table->boolean('important')->default(false);
            $table->boolean('mailing')->default(false)->comment('Рассылка');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_hidden')->default(false);
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
        Schema::dropIfExists('reports');
    }
}
