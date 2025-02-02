<?php

use App\Exceptions\FailedToParseResponseException;
use App\Traits\Command\AiFileGenerationApiTrait;
use Illuminate\Support\Facades\File;

use function Pest\test;

uses(AiFileGenerationApiTrait::class);

function mockResponse(string $text)
{
    $mock = Mockery::mock(EchoLabs\Prism\Text\Response::class);
    $mock->text = $text;

    return $mock;
}

test('it can parse a valid JSON response', function () {
    $response = mockResponse('{"key": "value"}');
    $parsed = $this->generateAiFiles($response);

    expect($parsed)->toBe(['key' => 'value']);
});

test('it can parse a JSON response wrapped in markdown code block', function () {
    $response = mockResponse("```json\n{\"key\": \"value\"}\n```");
    $parsed = $this->generateAiFiles($response);
    expect($parsed)->toBe(['key' => 'value']);

    $response = mockResponse("```\n{\"key\": \"value\"}\n```");
    $parsed = $this->generateAiFiles($response);
    expect($parsed)->toBe(['key' => 'value']);
});

test('it throws an exception for invalid JSON', function () {
    $response = mockResponse('invalid json');
    $this->expectException(FailedToParseResponseException::class);
    $this->generateAiFiles($response);
});

test('it creates a folder and files', function () {
    $response = mockResponse('{"__CREATE_FOLDER__": "test_folder","__FILES__": {"test_folder/test_file.txt": "test content"}}');
    $this->generateAiFiles($response);

    expect(File::exists(base_path('test_folder/test_file.txt')))->toBeTrue();
    expect(File::get(base_path('test_folder/test_file.txt')))->toBe('test content');

    File::deleteDirectory(base_path('test_folder'));
});

test('it handles a response without folder creation', function () {
    $response = mockResponse('{"__FILES__": {"test_file.txt": "test content"}}');
    $this->generateAiFiles($response);
    expect(File::exists(base_path('test_file.txt')))->toBeTrue();
    expect(File::get(base_path('test_file.txt')))->toBe('test content');

    File::delete(base_path('test_file.txt'));
});

test('it creates nested folders', function () {
    $response = mockResponse('{"__CREATE_FOLDER__": "nested/test/folder","__FILES__": {"nested/test/folder/test_file.txt": "nested content"}}');
    $this->generateAiFiles($response);

    expect(File::exists(base_path('nested/test/folder/test_file.txt')))->toBeTrue();
    expect(File::get(base_path('nested/test/folder/test_file.txt')))->toBe('nested content');
    File::deleteDirectory(base_path('nested'));
});

test('it overwrites existing files', function () {
    $filePath = base_path('overwrite_test.txt');
    File::put($filePath, 'old content');

    $response = mockResponse('{"__FILES__": {"overwrite_test.txt": "new content"}}');
    $this->generateAiFiles($response);

    expect(File::get($filePath))->toBe('new content');
    File::delete($filePath);
});
