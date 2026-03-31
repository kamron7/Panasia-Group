<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FederationsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $type = $this->resource['type'] ?? '';
        $query = $request->query('query');
        $words = array_filter(explode(' ', strtolower($query)));
        $highlightedTitle = $this->highlightText($this->title->{LANG} ?? '', $words);

        return [
            'id' => $this->resource['id'] ?? null,
            'title' => $highlightedTitle,
            'alias' => $this->resource['alias'] ?? '',
            'content' => _t($this->resource['content']) ?? '',
            'key_link' => "/{$this->group}-slug/{$this['alias']}" ?? '',
            'children' => $this->when($this->children->isNotEmpty(), self::collection($this->children)) ?? '',
            'created_at' => isset($this->resource['created_at']) ? $this->resource['created_at']->format('d.m.Y') : null,
        ];
    }
    private function highlightText(string $text, array $words): string
    {
        foreach ($words as $word) {
            $text = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', '<span class="highlight">$0</span>', $text);
        }
        return $text;
    }
}
