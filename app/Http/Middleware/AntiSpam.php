<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AntiSpam
{
    /**
     * Tiempo mínimo en segundos que debe pasar desde la carga del formulario
     */
    protected int $minTimeSeconds = 3;

    /**
     * Versión máxima real de Chrome (actualizar periódicamente)
     * Chrome 131 es la versión estable actual (Dic 2024)
     */
    protected int $maxChromeVersion = 135;

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Validar User-Agent sospechoso
        if ($this->failsUserAgentCheck($request)) {
            \Log::warning('AntiSpam: Bot detectado por User-Agent falso', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            return $this->rejectRequest($request);
        }

        // 2. Validar Honeypot
        if ($this->failsHoneypot($request)) {
            \Log::warning('AntiSpam: Bot detectado por honeypot', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            return $this->rejectRequest($request);
        }

        // 3. Validar tiempo mínimo de llenado
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
     * Verifica si el User-Agent es falso/sospechoso
     */
    protected function failsUserAgentCheck(Request $request): bool
    {
        $userAgent = $request->userAgent();
        
        if (empty($userAgent)) {
            return true; // Sin User-Agent es sospechoso
        }

        // Detectar versiones falsas de Chrome (ej: Chrome/142.0.0.0)
        if (preg_match('/Chrome\/(\d+)\./', $userAgent, $matches)) {
            $chromeVersion = (int) $matches[1];
            
            // Si la versión es mayor a la máxima conocida, es falso
            if ($chromeVersion > $this->maxChromeVersion) {
                return true;
            }
        }

        return false;
    }

    /**
     * Verifica si el honeypot fue llenado (indica bot)
     */
    protected function failsHoneypot(Request $request): bool
    {
        $honeypotValue = $request->input('website_url');
        return !empty($honeypotValue);
    }

    /**
     * Verifica si el formulario se envió demasiado rápido (indica bot)
     */
    protected function failsTimeCheck(Request $request): bool
    {
        $formLoadedAt = $request->input('_form_token');
        
        if (empty($formLoadedAt)) {
            return false;
        }

        $decodedTime = base64_decode($formLoadedAt);
        
        if (!is_numeric($decodedTime)) {
            return true;
        }

        $loadTime = (int) $decodedTime;
        $currentTime = time();
        $elapsedSeconds = $currentTime - $loadTime;

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