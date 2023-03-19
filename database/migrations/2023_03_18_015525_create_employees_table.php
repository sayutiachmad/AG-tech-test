<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip', 20);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->tinyInteger('umur');
            $table->text('alamat')->nullable();
            $table->string('agama', 50)->nullable();
            $table->char('jenis_kelamin', 1);
            $table->string('no_handphone', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
