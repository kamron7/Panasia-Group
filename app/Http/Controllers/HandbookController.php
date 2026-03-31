<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\PublicController;
use App\Models\Handbook\Answers;
use App\Models\Handbook\Chapters;
use App\Models\Handbook\Sub_chapters;
use App\Models\Handbook\Tests;
use App\Models\Handbook\Video;
use App\Models\Handbook\Words;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;

class HandbookController extends PublicController
{
    public function __construct()
    {
        parent::__construct();

        $this->data['defaultLang'] = LANG;
        $this->data['footer'] = json_decode(file_get_contents('../public/assets/public/handbook-json/footer.json'), true);
        $this->data['games'] = json_decode(file_get_contents('../public/assets/public/handbook-json/games.json'), true);
        $this->data['links'] = json_decode(file_get_contents('../public/assets/public/handbook-json/links.json'), true);
        $this->data['localization'] = json_decode(file_get_contents('../public/assets/public/handbook-json/localization.json'), true);

        $this->data['chapters'] = Chapters::gets(['sort' => 'asc', 'orderBy' => 'sort_order']);

        $this->data['assets_handbook_root'] = assets_p() . 'handbook/';
        $this->data['href_extension'] = '';
        $this->data['sel_main'] = 'handbook_main';
        $this->getBanner();
    }

    public function main(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->data['sel'] = 'handbook';
        session(['sel' => 'handbook']);
        $this->metaParams($this->data['p'][106]);
        $this->data['body'] = '';

        return view('public/main/handbook/main', $this->data);
    }

    public function render($slug): View|Application|Factory|string|\Illuminate\Contracts\Foundation\Application
    {
        $this->data['handbook_main'] = false;
        $this->data['sel'] = $slug;
        session(['sel' => 'handbook']);

        if ($slug == 'main1') {
            $body = 'main';
            $this->data['handbook_main'] = true;

        } else if ($slug == 'games') {
            $body = 'games';

            $this->data['chapter'] = $this->data['links'][1];
            $chapter_title = $this->data['links'][1];

        } else if ($slug == 'scramble') {
            $body = 'scramble';
            $this->data['chapter'] = $this->data['games'][0];
            $chapter_title = $this->data['games'][0];
            $this->data['words'] = Words::gets(['sort' => 'asc', 'orderBy' => 'sort']);;
        } else if ($slug == 'escape-plan') {
            $body = 'escape_plan';
            $this->data['chapter'] = $this->data['games'][1];
            $chapter_title = $this->data['games'][1];
        } else if ($slug == 'earthquake-protection') {
            $body = 'earthquake_protection';
            $this->data['chapter'] = $this->data['games'][2];
            $chapter_title = $this->data['games'][2];
        } else if ($slug == 'video') {
            $video_id = getFilterData('id');

            if ($video_id and is_numeric($video_id)) {
                $body = 'video/view';
                $this->data['chapter'] = $this->data['links'][0];
                $chapter_title = $this->data['links'][0];
                $this->data['video'] = Video::get(['id' => $video_id, 'status' => 'A']);
                Video::updateViewed($video_id);
            } else {
                $body = 'video/list';
                $this->data['chapter'] = $this->data['links'][0];
                $chapter_title = $this->data['links'][0];
                $this->data['videos'] = $test = Video::gets(['status' => 'A', 'lang' => LANG]);
            }
        } else if (str_starts_with($slug, 'test')) {
            $body = 'test';
            $this->data['chapter'] = $chapter = Chapters::get(['id' => substr($slug, 5)]);
            $next_chapter = Chapters::get(['sort_order' => $chapter['sort_order'] + 1]);
            $this->data['sub_chapters'] = $sub_chapters = Sub_chapters::gets(['chapter_id' => $chapter['id']])->toArray();
            $tests = Tests::gets(['chapter_id' => $chapter['id']]);

            foreach ($tests as $key => $test)
                $tests[$key]['answers'] = Answers::gets(['test_id' => $test['id']]);

            $this->data['tests'] = $tests;
            $this->data['test'] = array();

            $last_sub_chapters = end($sub_chapters);
            $this->data['test']['prev'] = $last_sub_chapters['href'];

            if (isset($next_chapter['href'])) {
                $this->data['test']['next'] = $next_chapter['href'];
            } else {
                $this->data['test']['next'] = 'games';
            }
        } else if ($current_sub_chapter = Sub_chapters::get(['href' => $slug])) {
            $chapter_id = $current_sub_chapter['chapter_id'];
            $body = 'subchapter';

            $this->data['chapter'] = $chapter = Chapters::get(['id' => $chapter_id]);

            $current_sub_chapters = Sub_chapters::gets(['chapter_id' => $chapter_id])->toArray();

            if ($current_sub_chapter['sort_order'] == 0) {
                if ($chapter['sort_order'] == 0) {
                    $current_sub_chapter['prev'] = 'main';
                } else {
                    $prev_chapter = Chapters::get(['sort_order' => $chapter['sort_order'] - 1]);
                    $current_sub_chapter['prev'] = 'test-' . $prev_chapter['id'];
                }
            } else {
                $prev_sub_chapter = $current_sub_chapters[$current_sub_chapter['sort_order'] - 1];
                $current_sub_chapter['prev'] = $prev_sub_chapter['href'];
            }
            $last_current_sub_chapters = end($current_sub_chapters);

            if ($current_sub_chapter['href'] == $last_current_sub_chapters['href']) {
                $current_sub_chapter['next'] = 'test-' . $chapter['id'];

            } else {
                $next_sub_chapter = $current_sub_chapters[$current_sub_chapter['sort_order'] + 1] ?? null;
                $current_sub_chapter['next'] = $next_sub_chapter['href'] ?? null;
            }

            $current_sub_chapter['body'] = $current_sub_chapter['content_' . LANG];

            $this->data['sub_chapter'] = $current_sub_chapter;
            $this->data['sub_chapters'] = $current_sub_chapters;

        } else {
            return url_p() . 'handbook';
        }

        if (isset($chapter['title_' . LANG]) and $chapter['title_' . LANG]) {
            $this->data['title'] = $chapter['title_' . LANG];
        } else {
            $this->data['title'] = $chapter_title['title_' . LANG];
        }

        $this->data['handbook_sidebar'] = view('public/main/handbook/sidebar', $this->data);
        $this->data['handbook_body'] = view('public/main/handbook/' . $body, $this->data);

        return view('public/main/handbook/container', $this->data);
    }


    function _load_json($path)
    {
        return json_decode(file_get_contents($path), true);
    }
}

/* End of file handbook.php */
/* Location: ./application/controllers/handbook.php */
