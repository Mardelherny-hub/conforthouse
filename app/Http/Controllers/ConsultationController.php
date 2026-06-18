<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConsultationMail;
use App\Mail\UserConfirmationMail;
use App\Models\Consultation;

class ConsultationController extends Controller
{
    /**
     * Procesa el formulario del modal flotante
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Agregar tipo de formulario
        $validated['form_type'] = 'Modal de Consulta';

        try {
            $this->guardarConsulta($validated, $request);

            // Enviar email al administrador
            Mail::to(config('mail.from.address'))
                ->send(new ConsultationMail($validated));

            // Enviar email de confirmación al usuario
            Mail::to($validated['email'])
                ->send(new UserConfirmationMail($validated));

            return response()->json([
                'success' => true,
                'message' => __('messages.message_sent_success')
            ]);

        } catch (\Exception $e) {
            // Log del error para debugging
            \Log::error('Error enviando email de consulta:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validated
            ]);

            return response()->json([
                'success' => false,
                'message' => __('messages.message_sent_error'),
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Procesa el formulario del home
     */
    public function storeHomeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Agregar tipo de formulario
        $validated['form_type'] = 'Formulario Home';

        try {
            $this->guardarConsulta($validated, $request);

            // Enviar email al administrador
            Mail::to(config('mail.from.address'))
                ->send(new ConsultationMail($validated));

            // Enviar email de confirmación al usuario
            Mail::to($validated['email'])
                ->send(new UserConfirmationMail($validated));

            return response()->json([
                'success' => true,
                'message' => __('messages.message_sent_success')
            ]);

        } catch (\Exception $e) {
            // Log del error para debugging
            \Log::error('Error enviando email de home:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validated
            ]);

            return response()->json([
                'success' => false,
                'message' => __('messages.message_sent_error'),
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Procesa el formulario de la página de contacto
     */
    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'interest' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Agregar tipo de formulario
        $validated['form_type'] = 'Página de Contacto';

        try {
            $this->guardarConsulta($validated, $request);

            // Enviar email al administrador
            Mail::to(config('mail.from.address'))
                ->send(new ConsultationMail($validated));

            // Enviar email de confirmación al usuario
            Mail::to($validated['email'])
                ->send(new UserConfirmationMail($validated));

            return response()->json([
                'success' => true,
                'message' => __('messages.message_sent_success')
            ]);

        } catch (\Exception $e) {
            // Log del error para debugging
            \Log::error('Error enviando email de contacto:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validated
            ]);

            return response()->json([
                'success' => false,
                'message' => __('messages.message_sent_error'),
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Procesa el formulario de contacto de propiedades
     */
    public function storePropertyContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:2000',
            'property_id' => 'required|exists:properties,id',
        ]);

        // Agregar tipo de formulario
        $validated['form_type'] = 'Consulta de Propiedad';
        
        // Obtener información de la propiedad
        $property = \App\Models\Property::find($validated['property_id']);
        $validated['property_title'] = $property ? $property->title : 'Propiedad no encontrada';
        $validated['property_reference'] = $property ? $property->reference : '';
        
        // Agregar subject automático basado en la propiedad
        $validated['subject'] = 'Consulta sobre: ' . $validated['property_title'];

        try {
            $this->guardarConsulta($validated, $request);

            // Enviar email al administrador
            Mail::to(config('mail.from.address'))
                ->send(new ConsultationMail($validated));

            // Enviar email de confirmación al usuario
            Mail::to($validated['email'])
                ->send(new UserConfirmationMail($validated));

            return response()->json([
                'success' => true,
                'message' => __('messages.message_sent_success')
            ]);

        } catch (\Exception $e) {
            // Log del error para debugging
            \Log::error('Error enviando email de propiedad:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validated
            ]);

            return response()->json([
                'success' => false,
                'message' => __('messages.message_sent_error'),
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Guarda la consulta en la base de datos mapeando los campos del
     * formulario a las columnas reales de la tabla consultations.
     */
    private function guardarConsulta(array $data, Request $request): void
    {
        $origenMap = [
            'Modal de Consulta'     => 'modal_flotante',
            'Formulario Home'       => 'home_contacto',
            'Página de Contacto'    => 'pagina_contacto',
            'Consulta de Propiedad' => 'pagina_contacto',
        ];

        // Mapeo del valor del formulario al enum real de la columna interested_in.
        // Si no coincide con ninguno permitido, se guarda null (la columna lo admite).
        $interesValidos = ['buying_property', 'selling_property', 'renting_property', 'investment', 'other'];
        $interesMap = [
            'buy'     => 'buying_property',
            'sell'    => 'selling_property',
            'rent'    => 'renting_property',
            'invest'  => 'investment',
        ];
        $interesRecibido = $data['interest'] ?? null;
        $interesFinal = $interesMap[$interesRecibido] ?? $interesRecibido;
        if (!in_array($interesFinal, $interesValidos, true)) {
            $interesFinal = null;
        }

        Consultation::create([
            'nombre'        => $data['name'],
            'email'         => $data['email'],
            'telefono'      => $data['phone'] ?? null,
            'asunto'        => $data['subject'] ?? null,
            'interested_in' => $interesFinal,
            'mensaje'       => $data['message'],
            'origen'        => $origenMap[$data['form_type']] ?? 'modal_flotante',
            'locale'        => app()->getLocale(),
            'ip_address'    => $request->ip(),
            'user_agent'    => $request->userAgent(),
        ]);
    }
}