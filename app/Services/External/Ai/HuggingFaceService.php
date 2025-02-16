<?php

namespace App\External\Ai\Services;

use App\Generators\FilenameGenerator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class HuggingFaceService
{
    protected $apiKey;

    // API URL for Hugging Face model
    // private $apiUrl = "https://api-inference.huggingface.co/models/openai-community/gpt2";
    // private $apiUrl = "https://api-inference.huggingface.co/models/deepseek-ai/DeepSeek-R1/v1/chat/completions";
    // private $apiUrl = "https://api-inference.huggingface.co/models/EleutherAI/gpt-neo-2.7B";
    private string $apiUrl = 'https://api-inference.huggingface.co/models/meta-llama/Meta-Llama-3-8B-Instruct/v1/chat/completions';

    // Your Hugging Face API Token
    private string $apiToken = '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';  // Replace with your token

    public function __construct($apiKey = null, protected Client $client = new Client())
    {
        $this->apiKey = $this->apiToken ?? $apiKey;
    }

    // Method to query the Hugging Face model
    // public function queryModel(string $inputText)
    // {
    //     // Prepare the payload (input text)
    //     $payload = [
    //         "inputs" => $inputText
    //     ];

    //     // Send the POST request to Hugging Face API
    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . $this->apiToken,
    //     ])->post($this->apiUrl, $payload);

    //     // Check for successful response
    //     if ($response->successful()) {
    //         return $response->json(); // Return the response as an array
    //     } else {
    //         // Handle error (optional)
    //         return [
    //             'error' => 'Failed to communicate with Hugging Face API',
    //             'details' => $response->body()
    //         ];
    //     }
    // }
    public function sendMessage(string $message)
    {
        // Define the request payload for the Llama model
        $payload = [
            'model' => 'meta-llama/Meta-Llama-3-8B-Instruct', // Llama model name
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $message, // User message in the content
                ],
            ],
            'max_tokens' => 5000,
            'stream' => false,
            'temperature' => 0.01,
            'top_p' => 0.95,
            'top_k' => 50,
            'return_full_text' => false,
            'language' => 'ar',
        ];

        // Send the POST request to Hugging Face API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, $payload);

        // Check if the request was successful
        if ($response->successful()) {
            return $response->json();  // Return the response as an array
        } else {
            // Handle error response
            return [
                'error' => 'Failed to communicate with Hugging Face API',
                'details' => $response->body(),
            ];
        }
    }

    /**
     * Generate text from a given prompt.
     *
     * @return array
     */
    public function generateText(string $prompt)
    {
        try {
            $retryCount = 0;
            $maxRetries = 5; // You can set a limit for retries
            $waitTime = 10; // Wait time in seconds before retrying (can be dynamic based on response)

            while ($retryCount < $maxRetries) {
                $response = $this->client->post('https://api-inference.huggingface.co/models/gpt2', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                    'json' => [
                        'inputs' => $prompt,
                    ],
                ]);

                $responseData = json_decode($response->getBody()->getContents(), true);

                // Check if the response indicates that the model is still loading
                if (isset($responseData['error']) && str_contains((string) $responseData['error'], 'currently loading')) {
                    $retryCount++;
                    $estimatedTime = $responseData['estimated_time'] ?? $waitTime;
                    sleep($estimatedTime); // Wait for the estimated time before retrying
                    continue;
                }

                // If no error, break out of the loop
                break;
            }

            // If retries exceeded, throw an error
            if ($retryCount >= $maxRetries) {
                throw new \Exception('Model loading took too long. Try again later.');
            }

            // Check if the response contains the necessary data
            if (isset($responseData[0]['generated_text'])) {
                return $responseData;
            }

            throw new \Exception('Text generation failed. No "generated_text" in response.');
        } catch (RequestException $e) {
            throw new \Exception('Request failed: ' . $e->getMessage(), $e->getCode(), $e);
        } catch (\Exception $e) {
            throw new \Exception('Unexpected error: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Generate an image from a prompt.
     *
     * @return array
     */
    public function generateImage(string $prompt)
    {
        try {
            $retryCount = 0;
            $maxRetries = 5; // You can set a limit for retries
            $waitTime = 10; // Wait time in seconds before retrying (can be dynamic based on response)

            while ($retryCount < $maxRetries) {
                $response = $this->client->post('https://api-inference.huggingface.co/models/stabilityai/stable-diffusion-2', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                    'json' => [
                        'inputs' => $prompt,
                    ],
                ]);

                $responseData = json_decode($response->getBody()->getContents(), true);

                // Check if the response indicates that the model is still loading
                if (isset($responseData['error']) && str_contains((string) $responseData['error'], 'currently loading')) {
                    $retryCount++;
                    $estimatedTime = $responseData['estimated_time'] ?? $waitTime;
                    sleep($estimatedTime); // Wait for the estimated time before retrying
                    continue;
                }

                // If no error, break out of the loop
                break;
            }

            // If retries exceeded, throw an error
            if ($retryCount >= $maxRetries) {
                throw new \Exception('Model loading took too long. Try again later.');
            }

            // Process the response (if model is ready)
            if ('image/jpeg' === $response->getHeader('Content-Type')[0]) {
                $imageStream = $response->getBody();
                $imageName = FilenameGenerator::generate('jpg', prefix: 'ai');
                $dir = 'generated_images/';

                FacadesStorage::disk('public')->put($dir . $imageName, $imageStream);

                return [
                    'image_path' => $dir . $imageName, // Path to the saved image
                    'message' => 'Image generated successfully.',
                ];
            }

            throw new \Exception('Image generation failed. Unexpected response format.');
        } catch (RequestException $e) {
            throw new \Exception('Request failed: ' . $e->getMessage(), $e->getCode(), $e);
        } catch (\Exception $e) {
            throw new \Exception('Unexpected error: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
