<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

class BreadcrumbServiceProvider extends ServiceProvider
{
    // Traducciones para los nombres de acciones comunes
    protected $actionTranslations = [
        'index' => 'Listado',
        'create' => 'Crear',
        'edit' => 'Editar',
        'show' => 'Detalle',
        'properties' => 'Propiedades',
        'profile' => 'Perfil',
    ];

    // Traducciones para las secciones principales
    protected $sectionTranslations = [
        'dashboard' => 'Escritorio',
        'admin' => 'Administración',
    ];

    public function boot()
    {
        View::composer('*', function ($view) {
            // Si la vista ya tiene breadcrumbs definidos, respetamos eso
            if (array_key_exists('breadcrumbs', $view->getData())) {
                return;
            }

            // Obtener la ruta actual
            $routeName = Route::currentRouteName();
            $currentUrl = url()->current();
            $breadcrumbs = [];

            // Si estamos en el dashboard, solo mostramos "Escritorio" o "Administración"
            if (!$routeName || $routeName === 'admin.dashboard') {
                $breadcrumbs = [
                    ['title' => $this->sectionTranslations['admin'] ?? 'Administración', 'url' => null]
                ];
            } elseif ($routeName === 'dashboard') {
                $breadcrumbs = [
                    ['title' => $this->sectionTranslations['dashboard'] ?? 'Escritorio', 'url' => null]
                ];
            } else {
                // Verificamos si es una ruta administrativa
                $isAdminRoute = str_starts_with($routeName, 'admin.');

                if ($isAdminRoute) {
                    $breadcrumbs[] = [
                        'title' => $this->sectionTranslations['admin'] ?? 'Administración',
                        'url' => route('admin.dashboard')
                    ];
                } else {
                    $breadcrumbs[] = [
                        'title' => $this->sectionTranslations['dashboard'] ?? 'Escritorio',
                        'url' => route('admin.dashboard')
                    ];
                }

                // Dividir el nombre de la ruta
                $parts = explode('.', $routeName);
                $currentParts = [];

                // Procesar cada parte del nombre de la ruta
                foreach ($parts as $index => $part) {
                    $currentParts[] = $part;
                    $currentRoute = implode('.', $currentParts);

                    // Para el último elemento (generalmente la acción)
                    if ($index === count($parts) - 1) {
                        $title = $this->actionTranslations[$part] ?? ucfirst(str_replace('-', ' ', $part));

                        $breadcrumbs[] = [
                            'title' => $title,
                            'url' => null // El último elemento no tiene URL
                        ];
                    } else {
                        // Traducir si tenemos una traducción, o formatear
                        $title = $this->actionTranslations[$part] ?? ucfirst(str_replace('-', ' ', $part));

                        // Intentar generar la URL
                        try {
                            $url = route($currentRoute);
                        } catch (\Exception $e) {
                            try {
                                $url = route($currentRoute . '.index');
                            } catch (\Exception $e2) {
                                $url = '#';
                            }
                        }

                        $breadcrumbs[] = [
                            'title' => $title,
                            'url' => $url
                        ];
                    }
                }
            }

            // Pasar los breadcrumbs a la vista
            $view->with('breadcrumbs', $breadcrumbs);
        });
    }
}
