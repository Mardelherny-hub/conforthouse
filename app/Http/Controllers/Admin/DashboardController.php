<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\Client;
use App\Models\Status;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        // Datos base para estadísticas
        $properties = Property::with('status', 'propertyType', 'operation')->get();
        $clients = Client::all();
        $users = User::all();

        $availableStatusId = Status::where('name', 'Disponible')->value('id');
        $reservedStatusId = Status::where('name', 'Reservado')->value('id');

        // Actividad reciente combinada
        $recentActivity = collect();

        // Propiedades recientes
        $recentProperties = Property::latest()->take(5)->get()->map(function ($property) {
            return [
                'type' => 'property',
                'message' => 'Nueva propiedad añadida: ' . $property->title,
                'icon' => 'plus',
                'color' => 'blue',
                'created_at' => $property->created_at,
            ];
        });

        // Clientes recientes
        $recentClients = Client::latest()->take(5)->get()->map(function ($client) {
            return [
                'type' => 'client',
                'message' => 'Nuevo cliente registrado: ' . $client->name,
                'icon' => 'user',
                'color' => 'green',
                'created_at' => $client->created_at,
            ];
        });

        // Usuarios recientes
        $recentUsers = User::latest()->take(5)->get()->map(function ($user) {
            return [
                'type' => 'user',
                'message' => 'Nuevo usuario creado: ' . $user->name,
                'icon' => 'shield',
                'color' => 'yellow',
                'created_at' => $user->created_at,
            ];
        });

        // Mezcla y ordena por fecha
        $recentActivity = $recentProperties
            ->merge($recentClients)
            ->merge($recentUsers)
            ->sortByDesc('created_at')
            ->take(10)
            ->values();

        // Pasamos todo a la vista
        return view('admin.dashboard', [
            'totalProperties'     => $properties->count(),
            'availableProperties' => Property::where('status_id', $availableStatusId)->count(),
            'reservedProperties'  => Property::where('status_id', $reservedStatusId)->count(),
            'totalClients'        => $clients->count(),
            'recentActivity'      => $recentActivity, // <-- importante
        ]);
    }
}
