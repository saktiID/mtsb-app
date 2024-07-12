<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_records', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('periode_id');
            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('cascade');
            $table->uuid('siswa_user_id');
            $table->foreign('siswa_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->uuid('aspect_id');
            $table->foreign('aspect_id')->references('id')->on('assessment_aspects')->onDelete('cascade');
            $table->string('answer');
            $table->string('bulan');
            $table->string('minggu_ke');
            $table->string('evaluator');
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
        Schema::dropIfExists('assessment_records');
    }
};
