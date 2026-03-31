<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\PublicController;
use App\Models\Main;
use App\Models\News;
use App\Models\Pages;

class HomeController extends PublicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): array|object
    {
        $lang = LANG;
        $this->data['sel'] = 'home';
        session(['sel' => 'home']);
        $this->data['p'] = Pages::getsPublic(['limit' => 500, 'except' => ['content', 'short_content']])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->data['home_stats'] = Main::getsPublic([
            'status' => true,
            'group'  => 'home_stats',
            'except' => ['content', 'short_content'],
        ])->filter(fn($item) => !empty(_t($item->title) ?? null));
        $this->data['about_c'] = Main::getsPublic([
            'status' => true,
            'group'  => 'about_c',
            'except' => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title) ?? null));
        $this->data['markets'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'markets',
            'orderBy' => 'sort_order',
            'except'  => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));
        $this->data['commodities'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'commodities',
            'orderBy' => 'sort_order',
            'except'  => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));
        $this->data['why_cards'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'why_cards',
            'orderBy' => 'sort_order',
            'except'  => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));
        $this->data['home_entities'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'home_entities',
            'orderBy' => 'sort_order',
            'except'  => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));
        $this->data['home_growth'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'home_growth',
            'orderBy' => 'sort_order',
            'except'  => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));

        return view('public/pages/home', $this->data);
    }

    public function calendarPlan()
    {
        \Log::info('CalendarPlan endpoint hit');

        $newsDates = News::where('status', true)
            ->whereNotNull('created_at')
            ->where('group' , 'news')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            });

        \Log::info('News dates found:', $newsDates->keys()->toArray());

        $events = [];
        $enabledDates = [];

        foreach ($newsDates as $date => $newsItems) {
            $enabledDates[] = $date;
            $events[] = [
                'date' => $date,
                'title' => _t($newsItems->first()->title),
                'count' => $newsItems->count()
            ];
        }

        \Log::info('Calendar data prepared:', ['events' => $events, 'dates' => $enabledDates]);

        return response()->json([
            'result_1' => $events,
            'result_2' => $enabledDates
        ]);
    }

    public function showMap()
    {
        $inspections = Main::where([
            'status' => true,
            'group' => 'regions'
        ])
            ->orderBy('title')
            ->get(['id', 'title', 'alias', 'url', 'group', 'content_1', 'option_1', 'option_4', 'category_title', 'short_content']);

        $inspections->each(function ($item) {
            if (is_string($item->title) && is_array(json_decode($item->title, true))) {
                $item->title = json_decode($item->title);
            }
        });

        $mapPost = Main::find(298);
        $mapTitle = $mapPost ? (is_string($mapPost->title) ? json_decode($mapPost->title) : $mapPost->title) : 'Uzbekistan Regions';

        return view('map', [
            'inspections' => $inspections,
            'mapTitle' => $mapTitle,
            'LANG' => app()->getLocale()
        ]);
    }


    function decodeUnicodeStrings($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => &$value) {
                if (is_string($value)) {
                    $decodedValue = json_decode('"' . $value . '"');
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $value = $decodedValue;
                    }
                } elseif (is_array($value) || is_object($value)) {
                    $value = $this->decodeUnicodeStrings((array)$value);
                }
            }
        } elseif (is_object($data)) {
            foreach ($data as $key => &$value) {
                if (is_string($value)) {
                    $decodedValue = json_decode('"' . $value . '"');
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $value = $decodedValue;
                    }
                } elseif (is_array($value) || is_object($value)) {
                    $value = $this->decodeUnicodeStrings((array)$value);
                }
            }
        }
        return $data;
    }

    private function replaceUploads($data)
    {
        $search2 = 'src="/uploads/';
        $replace = 'src="/storage/uploads/';
        if ($data)
            foreach ($data as $key => $val)
                $data[$key] = str_replace($search2, $replace, $val);
        return $data;
    }

}
