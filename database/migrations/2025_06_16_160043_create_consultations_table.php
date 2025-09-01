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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email');
            $table->string('telefono')->nullable();
            $table->string('asunto')->nullable(); // Para formulario de contacto
            $table->enum('tipo_consulta', [
                'compra',
                'venta',
                'alquiler',
                'inversion',
                'tasacion',
                'legal',
                'otro'
            ])->nullable();
            $table->enum('interested_in', [
                'buying_property',
                'selling_property',
                'renting_property',
                'investment',
                'other'
            ])->nullable(); // Para formulario de contacto
            $table->text('mensaje');
            $table->enum('origen', ['modal_flotante', 'pagina_contacto', 'home_contacto'])
                ->default('modal_flotante'); // Para distinguir origen
            $table->string('locale', 2)->default('es');
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->enum('estado', ['pendiente', 'en_proceso', 'resuelto', 'cerrado'])
                ->default('pendiente');
            $table->timestamp('fecha_respuesta')->nullable();
            $table->text('respuesta_admin')->nullable();
            $table->timestamps();

            // Índices
            $table->index(['estado', 'created_at']);
            $table->index(['tipo_consulta', 'created_at']);
            $table->index(['origen', 'created_at']);
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
