<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AntiSpam
{
    /**
     * Tiempo mínimo en segundos que debe pasar desde la carga del formulario
     * Un humano normal tarda al menos 3-5 segundos en llenar un formulario
     */
    protected int $minTimeSeconds = 3;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Validar Honeypot - si el campo tiene contenido, es un bot
        if ($this->failsHoneypot($request)) {
            \Log::warning('AntiSpam: Bot detectado por honeypot', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            return $this->rejectRequest($request);
        }

        // 2. Validar tiempo mínimo de llenado
        if ($this->failsTimeCheck($request)) {
            \Log::warning('AntiSpam: Bot detectado por tiempo de envío muy rápido', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            return $this->rejectRequest($request);
        }

        return $next($request);
    }

    /**
     * Verifica si el honeypot fue llenado (indica bot)
     */
    protected function failsHoneypot(Request $request): bool
    {
        // El campo honeypot debe existir y estar vacío
        $honeypotValue = $request->input('website_url');
        
        // Si tiene contenido, es bot
        return !empty($honeypotValue);
    }

    /**
     * Verifica si el formulario se envió demasiado rápido (indica bot)
     */
    protected function failsTimeCheck(Request $request): bool
    {
        $formLoadedAt = $request->input('_form_token');
        
        // Si no hay timestamp, permitir (formularios antiguos sin el campo)
        if (empty($formLoadedAt)) {
            return false;
        }

        // Decodificar el timestamp
        $decodedTime = base64_decode($formLoadedAt);
        
        if (!is_numeric($decodedTime)) {
            return true; // Timestamp inválido = sospechoso
        }

        $loadTime = (int) $decodedTime;
        $currentTime = time();
        $elapsedSeconds = $currentTime - $loadTime;

        // Si pasaron menos de X segundos, es sospechoso
        return $elapsedSeconds < $this->minTimeSeconds;
    }

    /**
     * Rechaza la solicitud de forma silenciosa
     */
    protected function rejectRequest(Request $request): Response
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => __('messages.message_sent_error'),
            ], 200);
        }

        return redirect()->back()->with('error', __('messages.message_sent_error'));
    }
}