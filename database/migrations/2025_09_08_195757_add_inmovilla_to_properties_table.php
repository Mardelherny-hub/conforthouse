<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // === AGREGAR CAMPOS INMOVILLA A LA TABLA PROPERTIES EXISTENTE ===
        Schema::table('properties', function (Blueprint $table) {
            
            // === IDENTIFICACIÓN INMOVILLA ===
            $table->integer('cod_ofer')->unique()->nullable(); // Código único Inmovilla
            $table->string('inmovilla_ref')->nullable(); // Referencia Inmovilla (diferente de Laravel reference)
            $table->string('numagencia')->nullable(); // Número agencia
            $table->timestamp('fechaact')->nullable(); // Fecha actualización Inmovilla
            
            // === OPERACIÓN Y TIPO INMOVILLA ===
            $table->integer('keyacci')->nullable(); // 1=Venta, 2=Alquiler, 3=Traspaso
            $table->integer('key_tipo')->nullable(); // Código tipo propiedad Inmovilla
            $table->string('nbtipo')->nullable(); // Nombre tipo propiedad Inmovilla
            
            // === PRECIOS INMOVILLA ===
            $table->decimal('precioinmo', 12, 2)->nullable(); // Precio venta Inmovilla
            $table->decimal('precioalq', 12, 2)->nullable(); // Precio alquiler Inmovilla
            $table->decimal('outlet', 12, 2)->nullable(); // Precio anterior
            $table->string('tipomensual')->nullable(); // Periodo: MES, QUI, SEM, DIA, FIN
            
            // === MEDIDAS INMOVILLA (complementarias a built_area Laravel) ===
            $table->integer('m_parcela')->nullable(); // Metros parcela
            $table->integer('m_uties')->nullable(); // Metros útiles
            $table->integer('m_terraza')->nullable(); // Metros terraza
            // NOTA: m_cons se mapea a built_area existente
            
            // === HABITACIONES INMOVILLA (complementarias a rooms Laravel) ===
            $table->integer('habdobles')->nullable(); // Habitaciones dobles
            $table->integer('habitaciones_simples')->nullable(); // Habitaciones simples
            $table->integer('total_hab')->nullable(); // Total habitaciones Inmovilla
            $table->integer('aseos')->nullable(); // Aseos (diferente de bathrooms)
            // NOTA: banyos se mapea a bathrooms existente
            
            // === CARACTERÍSTICAS BÁSICAS ===
            $table->boolean('ascensor')->default(false); // Ascensor
            $table->boolean('aire_con')->default(false); // Aire acondicionado
            $table->boolean('calefaccion')->default(false); // Calefacción
            $table->integer('parking')->nullable(); // 0=No, 1=Opcional, 2=Incluido
            $table->boolean('piscina_com')->default(false); // Piscina comunitaria
            $table->boolean('piscina_prop')->default(false); // Piscina privada
            $table->boolean('diafano')->default(false); // Diáfano
            $table->boolean('todoext')->default(false); // Todo exterior
            // NOTA: distmar se mapea a distance_to_sea existente
            
            // === CONSTRUCCIÓN ===
            $table->integer('anoconstr')->nullable(); // Año construcción Inmovilla
            $table->integer('garajes')->nullable(); // Plazas garaje
            // NOTA: plantas se mapea a floors existente
            // NOTA: planta se mapea a floor existente
            
            // === CERTIFICACIÓN ENERGÉTICA ===
            $table->string('energialetra', 10)->nullable(); // A,B,C,D,E,F,G
            $table->float('energiavalor')->nullable(); // Consumo kWh/m² año
            $table->string('emisionesletra', 10)->nullable(); // A,B,C,D,E,F,G
            $table->float('emisionesvalor')->nullable(); // Kg CO2/m² año
            
            // === CAMPOS ENUM INMOVILLA ===
            $table->integer('conservacion')->nullable(); // Estado conservación
            $table->integer('cocina_inde')->nullable(); // Tipo cocina
            $table->integer('keyori')->nullable(); // Orientación
            $table->integer('keyvista')->nullable(); // Vistas
            $table->integer('keyagua')->nullable(); // Agua caliente
            $table->integer('keycalefa')->nullable(); // Calefacción tipo
            $table->integer('keycarpin')->nullable(); // Carpintería interior
            $table->integer('keycarpinext')->nullable(); // Carpintería exterior
            $table->integer('keysuelo')->nullable(); // Suelos
            $table->integer('keytecho')->nullable(); // Techos
            $table->integer('keyfachada')->nullable(); // Fachada
            $table->integer('keyelectricidad')->nullable(); // Electricidad
            $table->bigInteger('x_entorno')->nullable(); // Campo binario entorno
            
            // === OTROS INMOVILLA ===
            $table->integer('tipovpo')->nullable(); // Tipo VPO
            $table->integer('electro')->nullable(); // Electrodomésticos
            $table->integer('destacado')->nullable(); // Destacado Inmovilla
            $table->integer('estadoficha')->nullable(); // Estado ficha
            $table->integer('eninternet')->nullable(); // Publicación web
            $table->integer('tgascom')->nullable(); // Tipo gastos comunidad
            // NOTA: gastos_com se mapea a community_expenses existente
            
            // === MULTIMEDIA ===
            $table->integer('numfotos')->nullable(); // Número fotos
            $table->string('foto')->nullable(); // URL foto principal
            $table->boolean('tourvirtual')->default(false); // Tour virtual
            $table->boolean('fotos360')->default(false); // Fotos 360
            $table->boolean('video_inmovilla')->default(false); // Vídeos Inmovilla
            $table->boolean('antesydespues')->default(false); // Fotos antes/después
            $table->string('fotoletra')->nullable(); // ID fotos
            
            // === AGENCIA ===
            $table->string('agencia')->nullable(); // Nombre agencia
            $table->string('web')->nullable(); // Web agencia
            $table->string('emailagencia')->nullable(); // Email agencia
            $table->string('telefono')->nullable(); // Teléfono agencia
            
            // === UBICACIÓN INMOVILLA ===
            $table->string('ciudad_inmovilla')->nullable(); // Ciudad Inmovilla
            $table->string('zona_inmovilla')->nullable(); // Zona Inmovilla
            $table->integer('key_loca')->nullable(); // Código localización
            $table->integer('key_zona')->nullable(); // Código zona
            $table->integer('keypromo')->nullable(); // Código promoción
            
            
            
            // === ÍNDICES PARA OPTIMIZACIÓN ===
            $table->index('cod_ofer');
            $table->index('keyacci');
            $table->index('key_tipo');
            $table->index('fechaact');
            $table->index('estadoficha');
            $table->index(['ciudad_inmovilla', 'zona_inmovilla']);
            $table->index('precioinmo');
            $table->index('precioalq');
            $table->index(['destacado', 'is_featured']); // Índice combinado
        });

        // === AGREGAR CAMPOS INMOVILLA A ADDRESSES ===
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('inmovilla_direccion')->nullable(); // Dirección completa Inmovilla
            $table->string('inmovilla_cp')->nullable(); // Código postal Inmovilla
            $table->string('inmovilla_provincia')->nullable(); // Provincia Inmovilla
        });

        // === AGREGAR CAMPOS INMOVILLA A PROPERTY_IMAGES ===
        Schema::table('property_images', function (Blueprint $table) {
            $table->string('inmovilla_photo_id')->nullable(); // ID foto de Inmovilla
            $table->boolean('is_before_after')->default(false); // Foto antes/después
            $table->string('inmovilla_url')->nullable(); // URL original Inmovilla
        });

        // === CREAR TABLA PROPERTY_VIDEOS PARA INMOVILLA ===
        Schema::create('property_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('video_url')->nullable(); // URL del video
            $table->string('youtube_code')->nullable(); // Código YouTube
            $table->string('title')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_inmovilla')->default(false); // Origen Inmovilla
            $table->timestamps();
        });

        // === CREAR TABLA PROPERTY_DESCRIPTIONS PARA MÚLTIPLES IDIOMAS INMOVILLA ===
        Schema::create('property_descriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->integer('inmovilla_language_id'); // ID idioma Inmovilla
            $table->string('locale', 5); // es, en, fr, de
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->unique(['property_id', 'inmovilla_language_id']);
        });
    }

    public function down(): void
    {
        // === ELIMINAR TABLAS NUEVAS ===
        Schema::dropIfExists('property_descriptions');
        Schema::dropIfExists('property_videos');
        
        // === ELIMINAR CAMPOS AGREGADOS A PROPERTY_IMAGES ===
        Schema::table('property_images', function (Blueprint $table) {
            $table->dropColumn([
                'inmovilla_photo_id',
                'is_before_after',
                'inmovilla_url'
            ]);
        });
        
        // === ELIMINAR CAMPOS AGREGADOS A ADDRESSES ===
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn([
                'inmovilla_direccion',
                'inmovilla_cp',
                'inmovilla_provincia'
            ]);
        });
        
        // === ELIMINAR CAMPOS AGREGADOS A PROPERTIES ===
        Schema::table('properties', function (Blueprint $table) {
            $table->dropIndex(['cod_ofer']);
            $table->dropIndex(['keyacci']);
            $table->dropIndex(['key_tipo']);
            $table->dropIndex(['fechaact']);
            $table->dropIndex(['estadoficha']);
            $table->dropIndex(['ciudad_inmovilla', 'zona_inmovilla']);
            $table->dropIndex(['precioinmo']);
            $table->dropIndex(['precioalq']);
            $table->dropIndex(['destacado', 'is_featured']);
            
            $table->dropColumn([
                'cod_ofer',
                'inmovilla_ref',
                'numagencia',
                'fechaact',
                'keyacci',
                'key_tipo',
                'nbtipo',
                'precioinmo',
                'precioalq',
                'outlet',
                'tipomensual',
                'm_parcela',
                'm_uties',
                'm_terraza',
                'habdobles',
                'habitaciones_simples',
                'total_hab',
                'aseos',
                'ascensor',
                'aire_con',
                'calefaccion',
                'parking',
                'piscina_com',
                'piscina_prop',
                'diafano',
                'todoext',
                'anoconstr',
                'garajes',
                'energialetra',
                'energiavalor',
                'emisionesletra',
                'emisionesvalor',
                'conservacion',
                'cocina_inde',
                'keyori',
                'keyvista',
                'keyagua',
                'keycalefa',
                'keycarpin',
                'keycarpinext',
                'keysuelo',
                'keytecho',
                'keyfachada',
                'keyelectricidad',
                'x_entorno',
                'tipovpo',
                'electro',
                'destacado',
                'estadoficha',
                'eninternet',
                'tgascom',
                'numfotos',
                'foto',
                'tourvirtual',
                'fotos360',
                'video_inmovilla',
                'antesydespues',
                'fotoletra',
                'agencia',
                'web',
                'emailagencia',
                'telefono',
                'ciudad_inmovilla',
                'zona_inmovilla',
                'key_loca',
                'key_zona',
                'keypromo',
            ]);
        });
    }
};