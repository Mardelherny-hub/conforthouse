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
     * Tiempo máximo en segundos de validez del token del formulario (2 horas)
     */
    protected int $maxTimeSeconds = 7200;

   

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
            $this->recordSpamAttempt('user_agent', $request);
            return $this->rejectRequest($request);
        }

        // 2. Validar Honeypot
        if ($this->failsHoneypot($request)) {
            \Log::warning('AntiSpam: Bot detectado por honeypot', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            $this->recordSpamAttempt('honeypot', $request);
            return $this->rejectRequest($request);
        }

        // 3. Validar tiempo mínimo de llenado
        if ($this->failsTimeCheck($request)) {
            \Log::warning('AntiSpam: Bot detectado por tiempo de envío muy rápido', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            $this->recordSpamAttempt('time_check', $request);
            return $this->rejectRequest($request);
        }

        return $next($request);
    }

    /**
     * Registra el intento de spam para estadísticas
     */
    protected function recordSpamAttempt(string $type, Request $request): void
    {
        $statsFile = storage_path('app/spam_stats.json');
        
        // Cargar estadísticas existentes
        $stats = [];
        if (file_exists($statsFile)) {
            $stats = json_decode(file_get_contents($statsFile), true) ?? [];
        }

        // Mes actual
        $month = date('Y-m');

        // Inicializar mes si no existe
        if (!isset($stats[$month])) {
            $stats[$month] = [
                'total' => 0,
                'by_type' => [
                    'user_agent' => 0,
                    'honeypot' => 0,
                    'time_check' => 0,
                ],
                'ips' => [],
            ];
        }

        // Incrementar contadores
        $stats[$month]['total']++;
        $stats[$month]['by_type'][$type]++;

        // Registrar IP (limitado a 50 para no crecer infinito)
        $ip = $request->ip();
        if (!in_array($ip, $stats[$month]['ips']) && count($stats[$month]['ips']) < 50) {
            $stats[$month]['ips'][] = $ip;
        }

        // Guardar estadísticas
        file_put_contents($statsFile, json_encode($stats, JSON_PRETTY_PRINT));
    }

    /**
     * Verifica si el User-Agent es falso/sospechoso
     */
    protected function failsUserAgentCheck(Request $request): bool
    {
        $userAgent = $request->userAgent();

        // Solo rechazar si no hay User-Agent
        return empty($userAgent);
    }

    /**
     * Verifica si el honeypot fue llenado (indica bot)
     */
    protected function failsHoneypot(Request $request): bool
    {
        // El campo debe existir en todos los formularios protegidos.
        if (!$request->request->has('website_url')) {
            return true;
        }

        $honeypotValue = $request->input('website_url');

        return !empty($honeypotValue);
    }

    /**
     * Verifica si el formulario se envió demasiado rápido (indica bot)
     */
    protected function failsTimeCheck(Request $request): bool
    {
        $formLoadedAt = $request->input('_form_token');

        // El token debe existir en todos los formularios protegidos.
        if (empty($formLoadedAt)) {
            return true;
        }

        $decoded = base64_decode($formLoadedAt, true);

        if ($decoded === false || !str_contains($decoded, '|')) {
            return true;
        }

        [$timestamp, $signature] = explode('|', $decoded, 2);

        if (!is_numeric($timestamp)) {
            return true;
        }

        // La firma debe coincidir con la generada por la app.
        $expected = hash_hmac('sha256', $timestamp, config('app.key'));

        if (!hash_equals($expected, $signature)) {
            return true;
        }

        $elapsedSeconds = time() - (int) $timestamp;

        // Demasiado rápido: bot. Demasiado viejo: token reutilizado.
        return $elapsedSeconds < $this->minTimeSeconds
            || $elapsedSeconds > $this->maxTimeSeconds;
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