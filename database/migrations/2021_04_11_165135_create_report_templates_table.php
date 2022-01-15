<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('parameter', 255);
            $table->string('report_of', 255)->comment('Отчёт по');
            $table->json('recipients')->nullable();
            $table->json('object')->nullable();
            $table->boolean('important')->default(false);
            $table->boolean('mailing')->default(false)->comment('Рассылка');
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
        Schema::dropIfExists('report_templates');
    }
}
