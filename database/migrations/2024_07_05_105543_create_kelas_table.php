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
        Schema::create('kelas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('periode_id');
            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('cascade');
            $table->string('jenjang_kelas', 2);
            $table->string('bagian_kelas', 2);
            $table->string('walas_id')->nullable(); // reference to user id from guru
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
        Schema::dropIfExists('kelas');
    }
};
