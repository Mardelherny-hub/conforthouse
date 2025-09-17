<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use App\Models\Operation;
use App\Models\PropertyType;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot(): void
    {
        // Compartir datos globalmente con todas las vistas
        View::composer('layouts.properties', function ($view) {
            $locale = app()->getLocale();
            
            $propertyTypes = PropertyType::with(['translations' => function($query) use ($locale) {
                $query->where('locale', $locale);
            }])->orderBy('name')->get();
            
            $operations = Operation::with(['translations' => function($query) use ($locale) {
                $query->where('locale', $locale);
            }])->orderBy('name')->get();
            
            // Aplicar traducciones
            foreach ($operations as $operation) {
                if ($locale !== 'es' && $operation->translations->isNotEmpty()) {
                    $operation->name = $operation->translations->first()->name ?? $operation->name;
                }
            }
            
            foreach ($propertyTypes as $type) {
                if ($locale !== 'es' && $type->translations->isNotEmpty()) {
                    $type->name = $type->translations->first()->name ?? $type->name;
                }
            }

            $view->with([
                'propertyTypes' => $propertyTypes,
                'operations' => $operations,
                'typeId' => request('type_id', null),
                'operationId' => request('operation_id', null),
                'min_price' => request('min_price', null),
                'max_price' => request('max_price', null),
                'search' => request('search', null),
            ]);
        });
    }
}