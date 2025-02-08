<?php

use App\Services\HuggingFaceService;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Storage;

uses(
    Tests\TestCase::class,
)->in('Feature');

beforeEach(function (): void {
    Storage::fake('public');
    $this->apiKey = 'test_api_key';
});

describe('HuggingFaceService', function () {
    it('should send a message and return a successful response', function () {
        $mockResponse = [
            'choices' => [
                [
                    'message' => [
                        'content' => 'This is a test response.',
                    ],
                ],
            ],
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($mockResponse)),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $service = new HuggingFaceService(client: $client);

        $message = 'Test message';
        $response = $service->sendMessage($message);

        expect($response)->toBe($mockResponse);
    });

    it('should handle API errors when sending a message', function () {
        $mockResponse = [
            'error' => 'Failed to communicate with Hugging Face API',
            'details' => 'Error details',
        ];

        $mock = new MockHandler([
            new Response(500, [], json_encode(['message' => 'Error details'])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $service = new HuggingFaceService(client: $client);

        $message = 'Test message';
        $response = $service->sendMessage($message);

        expect($response['error'])->toBe('Failed to communicate with Hugging Face API');
        expect($response['details'])->toBe('{"message":"Error details"}');
    });

    it('should generate text successfully', function () {
        $mockResponse = [[['generated_text' => 'Generated text']]];

        $mock = new MockHandler([
            new Response(200, [], json_encode($mockResponse)),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $service = new HuggingFaceService($this->apiKey, $client);

        $prompt = 'Test prompt';
        $response = $service->generateText($prompt);

        expect($response)->toBe($mockResponse);
    });

    it('should handle model loading errors during text generation', function () {
        $mockResponse = ['error' => 'Model is currently loading', 'estimated_time' => 1];

        $mock = new MockHandler([
            new Response(200, [], json_encode($mockResponse)), // Initial loading response
            new Response(500, [], json_encode(['message' => 'Model loading took too long. Try again later.'])), // Retry exceeds
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $service = new HuggingFaceService($this->apiKey, $client);

        $prompt = 'Test prompt';

        expect(fn () => $service->generateText($prompt))->toThrow(
            Exception::class,
            'Model loading took too long. Try again later.'
        );
    });

    it('should generate an image successfully', function () {
        $imageContent = 'test_image_content';
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => ['image/jpeg']], $imageContent),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $service = new HuggingFaceService($this->apiKey, $client);

        $prompt = 'Test prompt';
        $response = $service->generateImage($prompt);

        Storage::disk('public')->assertExists($response['image_path']);

        expect($response['message'])->toBe('Image generated successfully.');
    });

    it('should handle image generation failures', function () {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => ['text/plain']], 'failure'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $service = new HuggingFaceService($this->apiKey, $client);

        $prompt = 'Test prompt';

        expect(fn () => $service->generateImage($prompt))->toThrow(
            Exception::class,
            'Image generation failed. Unexpected response format.'
        );
    });
});
