<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use OpenAI;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = OpenAI::client('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');
    }

    public function askGPT($context, $question)
    {
        try {
            $response = $this->client->chat()->create([
                'model' => 'gpt-4-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'Be concise and direct.'],
                    // ['role' => 'user', 'content' => "Here is the text:\n\n$context\n\nQuestion: $question\n\nProvide a direct and specific answer."],
                    ['role' => 'user', 'content' => "$context\n\nQ: $question"],
                ],
                'max_tokens' => 100,
                'temperature' => 0.3,
            ]);
            $responses = trim($response['choices'][0]['message']['content']);
            $finalAnswer = $responses;
            return [
                'success' => true,
                'answer' => $finalAnswer,
                'tokens_used' => $response['usage']['total_tokens'] ?? 0,
                'model' => $response['model'] ?? 'unknown',
            ];

        } catch (\Exception $e) {
            Log::error("OpenAI API Error: " . $e->getMessage());

            return [
                'success' => false,
                'error' => "Failed to process the request. Please try again later.",
                'details' => $e->getMessage(),
            ];
        }
    }

    
}

