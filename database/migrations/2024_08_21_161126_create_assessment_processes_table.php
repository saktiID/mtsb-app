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
        Schema::create('assessment_processes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('status', ['processing', 'failed', 'complete']);
            $table->uuid('kelas_id')->index();
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->uuid('periode_id')->index();
            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('cascade');
            $table->uuid('siswa_user_id')->index();
            $table->foreign('siswa_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('bulan');
            $table->string('minggu_ke');
            $table->string('evaluator');
            $table->longText('exception')->nullable();
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
        Schema::dropIfExists('assessment_processes');
    }
};
