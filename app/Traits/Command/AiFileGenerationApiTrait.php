<?php

namespace App\Traits\Command;

use App\Exceptions\FailedToParseResponseException;
use Illuminate\Support\Facades\File;

trait AiFileGenerationApiTrait
{
    /**
     * Takes a Prism response and parses it into an associative array.
     * Uses the associative array to create files and folders on the local filesystem.
     * Returns the parsed associative array.
     *
     * @param \EchoLabs\Prism\Text\Response $response the Prism response to parse
     *
     * @return array the parsed response associative array
     */
    public function generateAiFiles(\EchoLabs\Prism\Text\Response $response): array
    {
        $parsedResponse = $this->parseAiApiResponse($response->text);
        $this->createAiFilesAndFolder($parsedResponse);

        return $parsedResponse;
    }

    private function createAiFilesAndFolder($parsedResponse): void
    {
        // **Step 1: Create the folder if needed**
        if (isset($parsedResponse['__CREATE_FOLDER__'])) {
            $folderPath = base_path($parsedResponse['__CREATE_FOLDER__']);

            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }
        }

        // **Step 2: Create the files**
        if (isset($parsedResponse['__FILES__'])) {
            foreach ($parsedResponse['__FILES__'] as $filePath => $fileContent) {
                $fullPath = base_path($filePath);

                // Ensure the parent directory exists
                File::ensureDirectoryExists(dirname($fullPath));

                // Create or overwrite the file with content
                File::put($fullPath, $fileContent);
            }
        }
    }

    /**
     * Parses and cleans an AI API response string, removing unwanted markdown
     * and extraneous characters, then decodes it into an associative array.
     *
     * @param string $data the raw AI API response text
     *
     * @return array the parsed response data as an associative array
     *
     * @throws \Exception if the response cannot be decoded into JSON
     */
    private function parseAiApiResponse(string $data): array
    {
        // First, trim any leading/trailing whitespace.
        $cleanedResponse = trim($data);

        // If the response is wrapped in Markdown code block markers, extract the inner JSON.
        if (preg_match('/^```(?:json)?\s*(.*?)\s*```$/is', $cleanedResponse, $matches)) {
            $cleanedResponse = $matches[1];
        }

        // Log the cleaned response for debugging purposes.
        log_dev('Cleaned AI response: ' . $cleanedResponse);

        // Attempt to decode the JSON.
        $decodedData = json_decode($cleanedResponse, true);

        // If decoding fails, log the JSON error message.
        if (JSON_ERROR_NONE !== json_last_error()) {
            $errorMsg = json_last_error_msg();
            log_dev('JSON decode error: ' . $errorMsg);
            log_dev('Decoded data: ' . var_export($decodedData, true));
            throw new FailedToParseResponseException('Invalid AI response: Unable to parse JSON. ' . $errorMsg);
        }

        return $decodedData;
    }
}
