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
            $propertyTypes = Cache::remember('property_types_all', now()->addHours(24), function () {
                return PropertyType::orderBy('name')->get();
            });
            $operations = Cache::remember('operations_all', now()->addHours(24), function () {
                return Operation::orderBy('name')->get();
            });

            // Obtenemos los valores de los filtros de la petición actual,
            // con valores por defecto si no existen.
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