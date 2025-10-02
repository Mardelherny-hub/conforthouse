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
        // Compartir datos con layouts.properties y search-modal
        View::composer(['layouts.properties', 'components.search-modal'], function ($view) {
            $locale = app()->getLocale();
            
            $propertyTypes = PropertyType::with(['translations' => function($query) use ($locale) {
                $query->where('locale', $locale);
            }])->orderBy('name')->get();
            
            $operations = Operation::with(['translations' => function($query) use ($locale) {
                $query->where('locale', $locale);
            }])->orderBy('name')->get();
            
            // Aplicar traducciones en TODOS los idiomas (incluyendo español)
            foreach ($operations as $operation) {
                $translation = $operation->translations->where('locale', $locale)->first();
                if ($translation) {
                    $operation->name = $translation->name;
                }
            }
            
            foreach ($propertyTypes as $type) {
                $translation = $type->translations->where('locale', $locale)->first();
                if ($translation) {
                    $type->name = $translation->name;
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