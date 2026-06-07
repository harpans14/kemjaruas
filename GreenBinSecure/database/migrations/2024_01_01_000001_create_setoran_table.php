<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('setoran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('jenis_sampah', 100);
            $table->decimal('berat', 10, 2);
            $table->date('tanggal_setoran');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('bukti_foto', 255)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setoran');
    }
};
