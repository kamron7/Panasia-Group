<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $imageData = $this['images'] ?? [];

        $imageUrls = array_map(function ($image) {
            $imageArray = (array)$image;
            return;
        }, $imageData);

        $options = $request->get('options');
        $query = $request->query('query');
        $words = array_filter(explode(' ', strtolower($query)));

        $content = $options ? char_lim(_t($this['content']), 120) : _t($this['content']);
        $highlightedTitle = $this->highlightText($this->title->{LANG} ?? '', $words);

        return [
            'id' => $this['id'],
            'video_code' => _t($this['video_code']),
            'views' => $this['views'],
            'title' => $highlightedTitle,
            'key_link' => "/news-slug/{$this['alias']}" ?? '',
            'alias' => $this['alias'],
            'content' => $content,
            'group' => $this['group'],
            'event_type' => $this['event_type'],
            'event_time' => $this['event_time'],
            'keywords' => _t($this['keywords']),
            'description' => _t($this['description']),
            'file' => optional(collect($this->images)->firstWhere('is_main', '1'))->url
                ? url_u() . $this->group . '/' . collect($this->images)->firstWhere('is_main', '1')->url
                : null,
            'created_at' => $this['created_at']
                ? $this['created_at']->day . ' ' . getMonthName($this['created_at']) . ' ' . $this['created_at']->year
                : null,

        ];
    }

    /**
     * Highlight the search query in the text.
     *
     * @param string $text
     * @param array $words
     * @return string
     */
    private function highlightText(string $text, array $words): string
    {
        foreach ($words as $word) {
            $text = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', '<span class="highlight">$0</span>', $text);
        }
        return $text;
    }
}
