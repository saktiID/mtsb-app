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
            $table->uuid('id')->primary()->index();
            $table->uuid('periode_id')->index();
            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('cascade');
            $table->string('jenjang_kelas', 2);
            $table->string('bagian_kelas', 12);
            $table->uuid('walas_id')->nullable()->index();
            $table->foreign('walas_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('kelas');
    }
};
