<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConsultationMail;
use App\Mail\UserConfirmationMail;

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
}