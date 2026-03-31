<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class DCategoryResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $query = $request->query('query');
        $words = array_filter(explode(' ', strtolower($query)));
        $highlightedTitle = $this->highlightText($this->title->{LANG} ?? '', $words);
        return
            [
                'id' => $this['id'],
                'title' => $highlightedTitle,
                'short_content' => _t($this['short_content']),
                'alias' =>$this['alias'],
                'images' => url_u().'doctors/'.getImgMain($this),
                'children' => $this->when($this->children->isNotEmpty(), DCategoryResources::collection($this->children)),
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
