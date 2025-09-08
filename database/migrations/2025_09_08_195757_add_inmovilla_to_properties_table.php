<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ELIMINAR TABLA PROPERTIES EXISTENTE Y RECREAR DESDE CERO
        Schema::dropIfExists('property_translations');
        Schema::dropIfExists('property_images');
        Schema::dropIfExists('properties');
        Schema::dropIfExists('addresses');

        // CREAR TABLA PROPERTIES CON CAMPOS DE INMOVILLA
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            
            // === IDENTIFICACIÓN INMOVILLA ===
            $table->integer('cod_ofer')->unique(); // Código único Inmovilla
            $table->string('ref'); // Referencia
            $table->string('numagencia')->nullable(); // Número agencia como string
            $table->timestamp('fechaact')->nullable(); // Fecha actualización
            
            // === OPERACIÓN Y TIPO ===
            $table->integer('keyacci'); // 1=Venta, 2=Alquiler, 3=Traspaso
            $table->integer('key_tipo')->nullable(); // Código tipo propiedad
            $table->string('nbtipo')->nullable(); // Nombre tipo propiedad
            
            // === PRECIOS ===
            $table->decimal('precioinmo', 12, 2)->nullable(); // Precio venta
            $table->decimal('precioalq', 12, 2)->nullable(); // Precio alquiler
            $table->decimal('outlet', 12, 2)->nullable(); // Precio anterior
            $table->string('tipomensual')->nullable(); // Periodo: MES, QUI, SEM, DIA, FIN
            
            // === MEDIDAS ===
            $table->integer('m_parcela')->nullable(); // Metros parcela
            $table->integer('m_uties')->nullable(); // Metros útiles
            $table->integer('m_cons')->nullable(); // Metros construidos
            $table->integer('m_terraza')->nullable(); // Metros terraza
            
            // === HABITACIONES Y BAÑOS ===
            $table->integer('habdobles')->nullable(); // Habitaciones dobles
            $table->integer('habitaciones')->nullable(); // Habitaciones simples
            $table->integer('total_hab')->nullable(); // Total habitaciones
            $table->integer('banyos')->nullable(); // Baños
            $table->integer('aseos')->nullable(); // Aseos
            
            // === CARACTERÍSTICAS BÁSICAS ===
            $table->boolean('ascensor')->default(false); // Ascensor
            $table->boolean('aire_con')->default(false); // Aire acondicionado
            $table->boolean('calefaccion')->default(false); // Calefacción
            $table->integer('parking')->nullable(); // 0=No, 1=Opcional, 2=Incluido
            $table->boolean('piscina_com')->default(false); // Piscina comunitaria
            $table->boolean('piscina_prop')->default(false); // Piscina privada
            $table->boolean('diafano')->default(false); // Diáfano
            $table->boolean('todoext')->default(false); // Todo exterior
            $table->integer('distmar')->nullable(); // Distancia mar en metros
            
            // === CONSTRUCCIÓN ===
            $table->integer('anoconstr')->nullable(); // Año construcción
            $table->integer('plantas')->nullable(); // Número plantas
            $table->integer('planta')->nullable(); // Planta donde está
            $table->integer('garajes')->nullable(); // Plazas garaje
            
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
            $table->integer('destacado')->nullable(); // Destacado
            $table->integer('estadoficha')->nullable(); // Estado ficha
            $table->integer('eninternet')->nullable(); // Publicación web
            $table->integer('tgascom')->nullable(); // Tipo gastos comunidad
            $table->decimal('gastos_com', 10, 2)->nullable(); // Gastos comunidad
            
            // === MULTIMEDIA ===
            $table->integer('numfotos')->nullable(); // Número fotos
            $table->string('foto')->nullable(); // URL foto principal
            $table->boolean('tourvirtual')->default(false); // Tour virtual
            $table->boolean('fotos360')->default(false); // Fotos 360
            $table->boolean('video')->default(false); // Vídeos
            $table->boolean('antesydespues')->default(false); // Fotos antes/después
            $table->string('fotoletra')->nullable(); // ID fotos
            
            // === AGENCIA ===
            $table->string('agencia')->nullable(); // Nombre agencia
            $table->string('web')->nullable(); // Web agencia
            $table->string('emailagencia')->nullable(); // Email agencia
            $table->string('telefono')->nullable(); // Teléfono agencia
            
            // === UBICACIÓN ===
            $table->string('ciudad')->nullable(); // Ciudad
            $table->string('zona')->nullable(); // Zona
            $table->integer('key_loca')->nullable(); // Código localización
            $table->integer('key_zona')->nullable(); // Código zona
            $table->integer('keypromo')->nullable(); // Código promoción
            
            // === CAMPOS LARAVEL OBLIGATORIOS ===
            $table->string('reference')->unique(); // Referencia única Laravel
            $table->foreignId('operation_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('status_id')->constrained()->onDelete('cascade');
            $table->boolean('is_featured')->default(false);
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('meta_description');
            $table->decimal('price', 12, 2); // Precio principal para Laravel
            
            // === ÍNDICES OPTIMIZACIÓN ===
            $table->index('cod_ofer');
            $table->index('keyacci');
            $table->index('key_tipo');
            $table->index('fechaact');
            $table->index('estadoficha');
            $table->index(['ciudad', 'zona']);
            $table->index('precioinmo');
            $table->index('precioalq');
            
            $table->timestamps();
        });

        // TABLA ADDRESSES SIMPLIFICADA
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('floor')->nullable();
            $table->string('door')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('district')->nullable(); // Zona/distrito
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('autonomous_community')->nullable();
            $table->timestamps();
        });

        // TABLA PROPERTY_IMAGES
        Schema::create('property_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->string('thumbnail_path')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->string('alt_text')->nullable();
            $table->string('inmovilla_photo_id')->nullable(); // ID foto de Inmovilla
            $table->boolean('is_before_after')->default(false); // Foto antes/después
            $table->timestamps();
        });

        // TABLA PROPERTY_VIDEOS
        Schema::create('property_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('youtube_code'); // Código YouTube
            $table->string('title')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // TABLA PROPERTY_DESCRIPTIONS (para múltiples idiomas desde Inmovilla)
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

        // TABLA PROPERTY_TRANSLATIONS (traducciones Laravel)
        Schema::create('property_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('condition')->nullable();
            $table->string('orientation')->nullable();
            $table->string('exterior_type')->nullable();
            $table->string('kitchen_type')->nullable();
            $table->string('heating_type')->nullable();
            $table->string('interior_carpentry')->nullable();
            $table->string('exterior_carpentry')->nullable();
            $table->string('flooring_type')->nullable();
            $table->string('views')->nullable();
            $table->string('regime')->nullable();
            $table->timestamps();
            
            $table->unique(['property_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_translations');
        Schema::dropIfExists('property_descriptions');
        Schema::dropIfExists('property_videos');
        Schema::dropIfExists('property_images');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('properties');
    }
};