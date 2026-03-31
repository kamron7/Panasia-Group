<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Collection\Collection;
use App\Models\Menu;

class NewsViewResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $base_url = url_u();

        $content = _t($this['content']);

        if ($content) {
            $content = str_replace(
                'src="/storage/uploads/',
                'src="' . $base_url,
                $content
            );
            $content = preg_replace('/https:\s*\/\//', 'https://', $content);
            $content = str_replace('\"', '"', $content);
        } else {
            $content = _t($this['content']);
        }
//
//        $query = $request->query('query');
//        $words = array_filter(explode(' ', strtolower($query)));
//        $highlightedTitle = $this->highlightText($this->title->{LANG} ?? '', $words);
//
//        if ($this->cat_id !== 0){
//            $group = Menu::find($this->cat_id)->inner_link;
//            if (!$group){
//                $group = 'news';
//            }
//        }else{
//            $group = 'news';
//        }
//        $frontendUrl = 'https://olympic.uz';
        return
            [
                'id' => $this->id ?? '',
                'cat_id' => $this->cat_id ?? '',
                'title' => _t('title'),
                'short_content' => _t($this['short_content']) ?? '',
                'content' => $content ?? '',
                'is_banner' => $this->options ?? '',
                'event_type' => $this['event_type'],
                'event_time' => $this['event_time'],
//                'key_link' => $group,
//                'key_link' => $frontendUrl ."/{$group}-slug/{$this['alias']}" ?? '',
                'images' => $this->getImages(),
//                'images' => url_u() . $this->group . '/' . getImgMain($this) ?? '',
                'description' => _t($this['description']) ?? '',
                'keywords' => _t($this['keywords']) ?? '',
                'views' => $this->views ?? '',
                'alias' => $this->alias ?? '',
                'created_at' => $this['created_at'] ? $this['created_at']->format('d.m.Y') : null,
            ];
    }

    private function getImages()
    {
        $images = $this->resource->images instanceof Collection ? $this->resource->images : collect($this->resource->images);

        return $images->map(function ($image) {
            return [
                'url' => url_u() . 'news/' . $image->url,
                'is_main' => ($image->is_main == "1") ? true : false,
            ];
        })->toArray();
    }
}
