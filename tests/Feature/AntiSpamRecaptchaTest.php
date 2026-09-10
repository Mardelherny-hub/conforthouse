<?php

namespace Tests\Feature;

use App\Http\Middleware\AntiSpam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AntiSpamRecaptchaTest extends TestCase
{
    public function test_allows_request_when_recaptcha_is_valid(): void
    {
        config(['services.recaptcha.secret_key' => 'test-secret']);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => true,
            ], 200),
        ]);

        $response = $this->middleware()->handle(
            $this->makeRequest('valid-token'),
            fn () => response('ok', 200)
        );

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('ok', $response->getContent());

        Http::assertSentCount(1);
    }

    public function test_rejects_request_when_recaptcha_is_invalid(): void
    {
        config(['services.recaptcha.secret_key' => 'test-secret']);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => false,
                'error-codes' => ['invalid-input-response'],
            ], 200),
        ]);

        $response = $this->middleware()->handle(
            $this->makeRequest('invalid-token'),
            fn () => response('ok', 200)
        );

        $this->assertSame(200, $response->getStatusCode());
        $this->assertFalse((bool) json_decode($response->getContent(), true)['success']);

        Http::assertSentCount(1);
    }

    public function test_rejects_request_when_recaptcha_token_is_missing(): void
    {
        config(['services.recaptcha.secret_key' => 'test-secret']);

        Http::fake();

        $response = $this->middleware()->handle(
            $this->makeRequest(null),
            fn () => response('ok', 200)
        );

        $this->assertSame(200, $response->getStatusCode());
        $this->assertFalse((bool) json_decode($response->getContent(), true)['success']);

        Http::assertNothingSent();
    }

    private function makeRequest(?string $recaptchaResponse): Request
    {
        $timestamp = time() - 4;
        $formToken = base64_encode(
            $timestamp . '|' . hash_hmac('sha256', $timestamp, config('app.key'))
        );

        $parameters = [
            'website_url' => '',
            '_form_token' => $formToken,
        ];

        if ($recaptchaResponse !== null) {
            $parameters['g-recaptcha-response'] = $recaptchaResponse;
        }

        return Request::create('/test', 'POST', $parameters, [], [], [
            'HTTP_ACCEPT' => 'application/json',
            'HTTP_USER_AGENT' => 'Mozilla/5.0',
        ]);
    }

    private function middleware(): AntiSpam
    {
        return new class extends AntiSpam
        {
            protected function recordSpamAttempt(string $type, Request $request): void
            {
                // No escribir estadísticas reales durante los tests.
            }
        };
    }
}
