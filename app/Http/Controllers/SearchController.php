<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\PublicController;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class SearchController extends PublicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->data['sel'] = 'search';
        session(['sel' => 'search']);
        $word = getFilterData('word');
        $this->data['word_2'] = $word;

        if ($word) {
            $all = collect();
            foreach (['menu', 'news'] as $item) {
                $data = ['likeSearch' => [$word => ['title', 'content']], 'except' => 'content'];
                $arr = getTables()[$item]->getsPublic($data);
                if ($arr->count()) {
                    $arr = $this->addKey($arr, $item);
                    if ($item == 'menu')
                        foreach ($arr as $key1 => $item1)
                            if ($item1->cat_id == 0 and in_array($item1->inner_link, ['', '#', 0, '0']) and in_array($item1->external_link, ['', '#', 0, '0']))
                                unset($arr[$key1]);
                    $all = $all->merge($arr);
                }
            }

            $paginator = $this->makePaginator($all);
            $this->data['results'] = $paginator->items();
            $this->data['pager'] = $paginator->links('vendor.pagination.custom');
        }
        return view('public/pages/search', $this->data);
    }

    private function addKey($arr, $key)
    {
        foreach ($arr as $item)
            $item->key = $key;
        return $arr;
    }

    private function makePaginator($all, $limit = 10): LengthAwarePaginator
    {
        $all = $all->sortByDesc('created_at');
        $page = request()->input('page', 1);
        $perPage = $limit;
        $offset = ($page - 1) * $perPage;
        $paginatedResults = $all->skip($offset)->take($perPage);

        $total = count($all);
        return new LengthAwarePaginator($paginatedResults, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
            'query' => request()->except('page'),
        ]);
    }
}
