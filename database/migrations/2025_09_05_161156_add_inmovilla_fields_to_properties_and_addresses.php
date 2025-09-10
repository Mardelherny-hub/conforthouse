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
        // Agregar campos de Inmovilla a la tabla properties
        Schema::table('properties', function (Blueprint $table) {
            // Campos de identificación Inmovilla
            $table->integer('inmovilla_code')->nullable()->after('reference')->comment('Código cod_ofer de Inmovilla');
            $table->string('agency_code')->nullable()->after('inmovilla_code')->comment('Código numagencia de Inmovilla');
            
            // Precios adicionales
            $table->decimal('rental_price', 10, 2)->nullable()->after('price')->comment('Precio de alquiler precioalq');
            
            // Áreas adicionales (usable_area después de built_area que ya existe)
            $table->decimal('usable_area', 8, 2)->nullable()->after('built_area')->comment('Metros útiles m_uties');
            $table->decimal('plot_area', 10, 2)->nullable()->after('usable_area')->comment('Metros parcela m_parcela');
            $table->decimal('terrace_area', 8, 2)->nullable()->after('plot_area')->comment('Metros terraza m_terraza');
            
            // Características de Inmovilla (después de distance_to_sea que ya existe)
            $table->integer('photos_count')->default(0)->after('distance_to_sea')->comment('Número de fotos numfotos');
            $table->boolean('elevator')->default(false)->after('photos_count')->comment('Tiene ascensor');
            $table->boolean('air_conditioning')->default(false)->after('elevator')->comment('Tiene aire acondicionado');
            $table->boolean('parking_included')->default(false)->after('air_conditioning')->comment('Parking incluido');
            $table->boolean('community_pool')->default(false)->after('parking_included')->comment('Piscina comunitaria');
            $table->boolean('private_pool')->default(false)->after('community_pool')->comment('Piscina privada');
            
            // Timestamps de Inmovilla
            $table->timestamp('inmovilla_updated_at')->nullable()->after('private_pool')->comment('Fecha actualización fechaact de Inmovilla');
            
            // Índices para optimización
            $table->index('inmovilla_code', 'idx_inmovilla_code');
            $table->index('agency_code', 'idx_agency_code');
            $table->index('inmovilla_updated_at', 'idx_inmovilla_updated_at');
            $table->index(['inmovilla_code', 'agency_code'], 'idx_inmovilla_code_agency');
        });

        // Agregar campo zona a la tabla addresses
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('zone')->nullable()->after('district')->comment('Zona de Inmovilla');
            
            // Índice para zona
            $table->index('zone', 'idx_zone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar campos de la tabla properties
        Schema::table('properties', function (Blueprint $table) {
            // Eliminar índices primero
            $table->dropIndex('idx_inmovilla_code');
            $table->dropIndex('idx_agency_code');
            $table->dropIndex('idx_inmovilla_updated_at');
            $table->dropIndex('idx_inmovilla_code_agency');
            
            // Eliminar campos
            $table->dropColumn([
                'inmovilla_code',
                'agency_code',
                'rental_price',
                'usable_area',
                'plot_area',
                'terrace_area',
                'photos_count',
                'elevator',
                'air_conditioning',
                'parking_included',
                'community_pool',
                'private_pool',
                'inmovilla_updated_at'
            ]);
        });

        // Eliminar campo zona de la tabla addresses
        Schema::table('addresses', function (Blueprint $table) {
            // Eliminar índice primero
            $table->dropIndex('idx_zone');
            
            // Eliminar campo
            $table->dropColumn('zone');
        });
    }
};