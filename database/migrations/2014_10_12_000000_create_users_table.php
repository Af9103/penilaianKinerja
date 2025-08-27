<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 30)->nullable();
            $table->string('nama', 50)->nullable();
            $table->string('gelar_depan', 7)->nullable();
            $table->string('gelar_belakang', 10)->nullable();
            $table->string('tempat_lahir', 20)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('agama', 10)->nullable();
            $table->string('status_pernikahan', 15)->nullable();
            $table->string('nik', 17)->unique()->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->string('status_pns', 3)->nullable();
            $table->string('no_sk_cpns', 20)->nullable();
            $table->date('tgl_sk_cpns')->nullable();
            $table->date('tmt_cpns')->nullable();
            $table->date('tmt_pns')->nullable();
            $table->string('gol', 10)->nullable();
            $table->string('jenis_jabatan', 20)->nullable();
            $table->string('jabatan_nama', 50)->nullable();
            $table->string('tingkat_pendidikan', 7)->nullable();
            $table->string('pend', 50)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->string('role', 10)->nullable();
            $table->string('foto');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
