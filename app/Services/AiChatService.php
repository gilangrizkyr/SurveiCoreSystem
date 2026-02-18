<?php

namespace App\Services;

use App\Traits\AiPersonaTrait;
use App\Models\AiSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiChatService
{
    use AiPersonaTrait;

    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.google.gemini_key');
    }

    /**
     * Get AI response for a given message
     */
    public function getResponse(string $message, array $history = []): string
    {
        // 1. Get System Prompt from DB (if exists) or Trait (default)
        $systemPrompt = AiSetting::where('key', 'system_prompt')->first()?->value ?? $this->getAiSystemPrompt();
        $securityRules = AiSetting::where('key', 'security_rules')->first()?->value ?? '';
        
        $fullSystemInstruction = $systemPrompt . "\n\nATURAN KEAMANAN TAMBAHAN:\n" . $securityRules;

        // 2. If API Key is configured, call Gemini
        if ($this->apiKey) {
            return $this->callGemini($message, $fullSystemInstruction, $history);
        }

        // 3. Fallback: Intelligent Simulated Response (Better than hardcoded)
        return $this->simulatedSmartResponse($message);
    }

    /**
     * Call Google Gemini API
     */
    protected function callGemini(string $message, string $systemInstruction, array $history): string
    {
        try {
            $contents = [];
            
            // System instruction as a separate context if supported, 
            // or prepended to the first user message for Gemini 1.5
            $contents[] = [
                'role' => 'user',
                'parts' => [['text' => "SYSTEM INSTRUCTION:\n" . $systemInstruction . "\n\nUSER MESSAGE: " . $message]]
            ];

            $response = Http::post($this->baseUrl . '?key=' . $this->apiKey, [
                'contents' => $contents,
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? $this->simulatedSmartResponse($message);
            }

            Log::error('Gemini API Error: ' . $response->body());
            return $this->simulatedSmartResponse($message);

        } catch (\Exception $e) {
            Log::error('AiChatService Exception: ' . $e->getMessage());
            return $this->simulatedSmartResponse($message);
        }
    }

    /**
     * Simulate a smart response when no API is available
     * Still uses the persona tone but logic is limited.
     */
    protected function simulatedSmartResponse(string $message): string
    {
        $lowMessage = strtolower($message);
        
        if (str_contains($lowMessage, 'siapa') || str_contains($lowMessage, 'apa itu')) {
            return "Halo! Saya adalah **BumbuAI**, asisten cerdas dari DPMPTSP Tanah Bumbu. Saya dilatih untuk membantu Anda memahami data survei dan memberikan informasi platform ini secara interaktif. Ada yang bisa saya bantu?";
        }

        if (str_contains($lowMessage, 'survei') || str_contains($lowMessage, 'data')) {
            return "Tentu! Saya memiliki akses ke data survei publik. Kamu bisa menanyakan hal spesifik seperti 'Berapa jumlah survei bulan ini?' atau 'Apa survei paling populer?'.";
        }

        // Default "Modern" conversational response
        return "Saya mengerti maksud Anda. Sebagai **BumbuAI**, saya siap berdiskusi lebih lanjut mengenai data survei atau fitur platform ini. Silakan sampaikan pertanyaan Anda dengan lebih detail! 😊";
    }
}