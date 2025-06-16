<?php

namespace Tests\Unit;

use App\Helpers\GoogleTranslateHelper;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GoogleTranslateHelperTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Eliminar el Http::fake de aquí y manejar los mocks en cada prueba
    }

    /** @test */
    public function it_translates_single_text()
    {
        // Limpiar cualquier mock anterior
        Http::fake([
            'translation.googleapis.com/*' => Http::response([
                'data' => [
                    'translations' => [
                        [
                            'translatedText' => 'Hello world'
                        ]
                    ]
                ]
            ], 200)
        ]);

        $translated = GoogleTranslateHelper::translate('Hola mundo', 'es', 'en', 'fr', 'de');

        $this->assertEquals('Hello world', $translated);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://translation.googleapis.com/language/translate/v2' &&
                   $request['q'] === 'Hola mundo' &&
                   $request['source'] === 'es' &&
                   $request['target'] === 'en';
        });
    }

    /** @test */
    public function it_returns_original_text_when_translation_fails()
    {
        Http::fake([
            'translation.googleapis.com/*' => Http::response([], 500)
        ]);

        $originalText = 'Hola mundo';
        $translated = GoogleTranslateHelper::translate($originalText, 'es', 'en');

        $this->assertEquals($originalText, $translated);
    }

    /** @test */
    public function it_translates_batch_of_texts()
    {
        Http::fake([
            'translation.googleapis.com/*' => Http::response([
                'data' => [
                    'translations' => [
                        ['translatedText' => 'Hello'],
                        ['translatedText' => 'World']
                    ]
                ]
            ], 200)
        ]);

        $texts = ['Hola', 'Mundo'];
        $translated = GoogleTranslateHelper::translateBatch($texts, 'es', 'en');

        $this->assertEquals(['Hello', 'World'], $translated);

        Http::assertSent(function ($request) use ($texts) {
            return $request->url() === 'https://translation.googleapis.com/language/translate/v2' &&
                   $request['q'] === $texts &&
                   $request['source'] === 'es' &&
                   $request['target'] === 'en';
        });
    }

    /** @test */
    public function it_handles_empty_input()
    {
        // No necesita mock para este test
        $this->assertEquals('', GoogleTranslateHelper::translate(''));
        $this->assertEquals([], GoogleTranslateHelper::translateBatch([]));
    }

    /** @test */
    public function it_handles_api_error_response()
    {
        Http::fake([
            'translation.googleapis.com/*' => Http::response([
                'error' => [
                    'code' => 400,
                    'message' => 'Invalid API key'
                ]
            ], 400)
        ]);

        $texts = ['Hola', 'Mundo'];
        $translated = GoogleTranslateHelper::translateBatch($texts);

        $this->assertEquals($texts, $translated);
    }
}
