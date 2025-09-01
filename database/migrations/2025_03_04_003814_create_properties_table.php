<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Crear la tabla de operaciones
        Schema::create('operations', function (Blueprint $table) {
            $table->id(); // ID único para la operación
            $table->string('name')->unique(); // Nombre de la operación, debe ser único
            $table->integer('population')->nullable(); // Población de la provincia (opcional)
            $table->timestamps(); // Timestamps para seguimiento de creación y actualización
        });

        // Crear la tabla de traducciones de operaciones
        Schema::create('operation_translations', function (Blueprint $table) {
            $table->id(); // ID único para la traducción
            $table->foreignId('operation_id')->constrained()->onDelete('cascade'); // ID de la operación relacionada
            $table->string('locale'); // Idioma de la traducción
            $table->string('name'); // Nombre traducido de la operación
            $table->timestamps(); // Timestamps para seguimiento de creación y actualización
        });

        // Crear la tabla de tipos de propiedad
        Schema::create('property_types', function (Blueprint $table) {
            $table->id(); // ID único para el tipo de propiedad
            $table->string('name')->unique(); // Nombre del tipo de propiedad, debe ser único
            $table->timestamps(); // Timestamps para seguimiento de creación y actualización
        });

        // Crear la tabla de traducciones de tipos de propiedad
        Schema::create('property_type_translations', function (Blueprint $table) {
            $table->id(); // ID único para la traducción
            $table->foreignId('property_type_id')->constrained()->onDelete('cascade'); // ID del tipo de propiedad relacionado
            $table->string('locale'); // Idioma de la traducción
            $table->string('name'); // Nombre traducido del tipo de propiedad
            $table->timestamps(); // Timestamps para seguimiento de creación y actualización
        });

        // Crear la tabla de estados
        Schema::create('statuses', function (Blueprint $table) {
            $table->id(); // ID único para el estado
            $table->string('name')->unique(); // Nombre del estado, debe ser único
            $table->timestamps(); // Timestamps para seguimiento de creación y actualización
        });

        // Crear la tabla de traducciones de estados
        Schema::create('status_translations', function (Blueprint $table) {
            $table->id(); // ID único para la traducción
            $table->foreignId('status_id')->constrained()->onDelete('cascade'); // ID del estado relacionado
            $table->string('locale'); // Idioma de la traducción
            $table->string('name'); // Nombre traducido del estado
            $table->timestamps(); // Timestamps para seguimiento de creación y actualización
        });



        // Crear la tabla de propiedades
        Schema::create('properties', function (Blueprint $table) {
            $table->id(); // ID único para la propiedad
            $table->string('reference')->unique(); // Referencia única de la propiedad
            $table->foreignId('operation_id')->constrained('operations')->onDelete('cascade'); // ID de la operación relacionada
            $table->foreignId('property_type_id')->constrained('property_types')->onDelete('cascade'); // ID del tipo de propiedad relacionado
            $table->foreignId('status_id')->constrained('statuses')->onDelete('cascade'); // ID del estado relacionado
            $table->boolean('is_featured')->default(false); // Indica si la propiedad es destacada
            $table->string('title'); // Título de la propiedad
            $table->text('meta_description'); // Descripción meta para SEO
            $table->decimal('price', 10, 2); // Precio de la propiedad
            $table->decimal('community_expenses', 10, 2)->nullable(); // Gastos comunitarios (opcional)
            $table->integer('built_area'); // Área construida de la propiedad
            $table->string('condition'); // Condición de la propiedad
            $table->integer('rooms'); // Número de habitaciones
            $table->integer('bathrooms'); // Número de baños
            $table->integer('year_built'); // Año de construcción
            $table->integer('parking_spaces')->nullable(); // Espacios de estacionamiento (opcional)
            $table->integer('floors'); // Número de pisos
            $table->integer('floor'); // Piso de la propiedad
            $table->string('orientation'); // Orientación de la propiedad
            $table->string('exterior_type'); // Tipo de exterior
            $table->string('kitchen_type'); // Tipo de cocina
            $table->string('heating_type'); // Tipo de calefacción
            $table->string('interior_carpentry'); // Tipo de carpintería interior
            $table->string('exterior_carpentry'); // Tipo de carpintería exterior
            $table->string('flooring_type'); // Tipo de suelo
            $table->string('views')->nullable(); // Vistas de la propiedad
            $table->integer('distance_to_sea')->nullable(); // Distancia al mar
            $table->string('regime')->nullable(); // Régimen de la propiedad
            $table->string('google_map')->nullable(); // Enlace a Google Maps (opcional)
            $table->text('description')->nullable(); // Descripción de la propiedad (opcional)
            $table->text('video')->nullable(); // Enlace a video de youtube.com (opcional)
            $table->timestamps(); // Timestamps para seguimiento de creación y actualización
        });

        // Crear la tabla de direcciones
        Schema::create('addresses', function (Blueprint $table) {
            $table->id(); // ID único para la dirección
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade'); // ID de la propiedad relacionada
            $table->string('street'); // Calle de la dirección
            $table->integer('number')->nullable(); // Número de la dirección (opcional)
            $table->string('floor')->nullable(); // Piso de la dirección (opcional)
            $table->string('door')->nullable(); // Puerta de la dirección (opcional)
            $table->string('postal_code')->nullable(); // Código postal (opcional)
            $table->string('district')->nullable(); // Campo manual para el distrito
            $table->string('city')->nullable(); // Ciudad de la dirección (opcional)
            $table->string('province')->nullable(); // Provincia de la dirección (opcional)
            $table->string('autonomous_community')->nullable(); // Comunidad autónoma de la dirección (opcional)
            $table->timestamps(); // Timestamps para seguimiento de creación y actualización
        });

        // Crear la tabla de imágenes de propiedades
        Schema::create('property_images', function (Blueprint $table) {
            $table->id(); // ID único para la imagen
            $table->foreignId('property_id')->constrained()->onDelete('cascade'); // ID de la propiedad relacionada
            $table->string('image_path'); // Ruta de la imagen
            $table->string('thumbnail_path')->nullable(); // Ruta de la miniatura (opcional)
            $table->integer('order')->default(0); // Orden de la imagen
            $table->boolean('is_featured')->default(false); // Imagen destacada
            $table->string('alt_text')->nullable(); // Texto alternativo para accesibilidad
            $table->timestamps(); // Timestamps para seguimiento de creación y actualización
        });

        // Crear la tabla de traducciones de propiedades
        Schema::create('property_translations', function (Blueprint $table) {
            $table->id(); // ID único para la traducción
            $table->foreignId('property_id')->constrained()->onDelete('cascade'); // ID de la propiedad relacionada
            $table->string('locale')->index(); // Idioma de la traducción
            $table->string('title')->nullable(); // Título traducido (opcional)
            $table->text('description')->nullable(); // Descripción traducida (opcional)
            $table->text('meta_description')->nullable(); // Descripción meta traducida (opcional)
            $table->string('condition')->nullable(); // Condición traducida (opcional)
            $table->string('orientation')->nullable(); // Orientación traducida (opcional)
            $table->string('exterior_type')->nullable(); // Tipo de exterior traducido (opcional)
            $table->string('kitchen_type')->nullable(); // Tipo de cocina traducido (opcional)
            $table->string('heating_type')->nullable(); // Tipo de calefacción traducido (opcional)
            $table->string('interior_carpentry')->nullable(); // Tipo de carpintería interior traducido (opcional)
            $table->string('exterior_carpentry')->nullable(); // Tipo de carpintería exterior traducido (opcional)
            $table->string('flooring_type')->nullable(); // Tipo de suelo traducido (opcional)
            $table->string('views')->nullable(); // Vistas traducidas (opcional)
            $table->string('regime')->nullable(); // Régimen traducido (opcional)
            $table->timestamps(); // Timestamps para seguimiento de creación y actualización
        });
    }

    public function down(): void
    {
        // Eliminar las tablas en orden inverso a su creación
        Schema::dropIfExists('property_translations');
        Schema::dropIfExists('property_images');
        Schema::dropIfExists('properties');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('autonomous_communities');
        Schema::dropIfExists('status_translations');
        Schema::dropIfExists('statuses');
        Schema::dropIfExists('property_type_translations');
        Schema::dropIfExists('property_types');
        Schema::dropIfExists('operation_translations');
        Schema::dropIfExists('operations');
    }
};
