<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $imageData = $this['images'] ?? [];

        $imageUrls = array_map(function ($image) {
            $imageArray = (array) $image;
            return url_u() . 'gallery/' . $imageArray['url'];
        }, $imageData);

        $query = $request->query('query');
        $words = array_filter(explode(' ', strtolower($query)));
        $highlightedTitle = $this->highlightText($this->title->{LANG} ?? '', $words);
        return
            [
                'id' => $this['id'],
                'alias' => $this['alias'],
                'title' => $highlightedTitle,
                'key_link' => url("/gallery-slug/{$this['alias']}") ?? '',
                'images' => $imageUrls,
                'created_at' => $this['created_at'] ? $this['created_at']->format('d.m.Y') : null,
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
