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
        Schema::create('notificaciones', function (Blueprint $table) { // 🔹 Nombre corregido
            $table->id();
            $table->string('mensaje');
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->boolean('enviado_por_sms')->default(false);
            $table->boolean('enviado_por_email')->default(false);
            $table->timestamp('enviado_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};