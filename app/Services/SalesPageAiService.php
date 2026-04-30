<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class SalesPageAiService
{
    public function generate(array $data): array
    {
        $prompt = $this->buildPrompt($data);

        $response = Http::timeout(60)->post(
            rtrim(config('services.hugging_face.base_url'), '/') . '/' . config('services.hugging_face.model'),
            [
                'inputs' => $prompt,
            ]
        );

        if (! $response->successful()) {
            throw new RuntimeException('Failed to connect to Hugging Face.');
        }

        $result = $response->json();
        $rawText = $result['generated_text'] ?? null;  // Hugging Face biasanya mengembalikan teks dengan key 'generated_text'

        if (! $rawText) {
            throw new RuntimeException('Empty AI response.');
        }

        $jsonText = $this->extractJson($rawText);
        $decoded = json_decode($jsonText, true);

        if (! is_array($decoded)) {
            throw new RuntimeException('AI response is not valid JSON.');
        }

        return [
            'headline' => $decoded['headline'] ?? null,
            'subheadline' => $decoded['subheadline'] ?? null,
            'benefits' => $this->normalizeValue($decoded['benefits'] ?? null),
            'features_breakdown' => $this->normalizeValue($decoded['features_breakdown'] ?? null),
            'social_proof' => $this->normalizeValue($decoded['social_proof'] ?? null),
            'cta' => $this->normalizeValue($decoded['cta'] ?? null),
            'full_output' => json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
        ];
    }

    private function buildPrompt(array $data): string
    {
        $productName = $data['product_name'] ?? '';
        $description = $data['description'] ?? '';
        $keyFeatures = $data['key_features'] ?? '';
        $targetAudience = $data['target_audience'] ?? '';
        $price = $data['price'] ?? '';
        $usp = $data['unique_selling_points'] ?? '';

        return <<<PROMPT
You are an expert copywriter.

Return ONLY valid JSON.
Do not add explanation.
Do not add markdown.
Do not wrap the response in code fences.

JSON format:
{
  "headline": "string",
  "subheadline": "string",
  "benefits": [
    {
      "name": "string",
      "description": "string"
    }
  ],
  "features_breakdown": [
    {
      "title": "string",
      "description": "string"
    }
  ],
  "social_proof": [
    {
      "name": "string",
      "quote": "string"
    }
  ],
  "cta": {
    "button_text": "string"
  }
}

Product name: {$productName}
Description: {$description}
Key features: {$keyFeatures}
Target audience: {$targetAudience}
Price: {$price}
Unique selling points: {$usp}
PROMPT;
    }

    private function extractJson(string $text): string
    {
        $text = trim($text);

        if (preg_match('/```json\s*(.*?)\s*```/is', $text, $matches)) {
            return trim($matches[1]);
        }

        if (preg_match('/\{.*\}/s', $text, $matches)) {
            return trim($matches[0]);
        }

        return $text;
    }

    private function normalizeValue(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            return $value;
        }

        return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}