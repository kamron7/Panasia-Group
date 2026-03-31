<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\PublicController;
use App\Models\Gallery;
use App\Models\Products;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use App\Models\Pages;
use App\Models\Docs;
use App\Models\DatasetRating;
use Illuminate\Support\Facades\Http;
use App\Models\Opendata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Main;
use App\Models\Menu;
use App\Models\Video;
use App\Models\Polls;
use App\Models\News;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Telegram\Bot\Laravel\Facades\Telegram;

class MgController extends PublicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function apparat(Request $request): array|object
    {
        $this->data['sel'] = 'apparat';
        session(['sel' => 'apparat']);
        $post = $this->menu->getByAliasORLinkPublic("apparat");
        $this->data['apparat'] = Main::paginatePublic([
            'status' => true,
            'group' => 'apparat',
            'orderBy' => 'sort_order',
            'limit' => 10,
            'except' => ['content', 'short_content']]);
        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/apparat/index', $this->data);
    }

    public function products(Request $request): array|object
    {
        $this->data['sel'] = 'products';
        session(['sel' => 'products']);
        $post = $this->menu->getByAliasORLinkPublic("products");
        $this->data['products'] = Products::paginatePublic([
            'status' => true,
            'orderBy' => 'sort_order',
            'limit' => 10,
            'except' => ['content', 'short_content']]);
        $this->data['news'] = News::getsPublic([
            'status' => true,
            'group' => 'news',
            'limit' => 2,
            'except' => ['content', 'short_content']])
            ->filter(fn($item) => !empty(_t($item->title) ?? null));
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/products/index', $this->data);
    }

    public function products_view($alias)
    {
        $this->data['sel'] = 'products';
        session(['sel' => 'products']);

        $post = $this->menu->getByAliasORLinkPublic("products");

        $current = Products::getsPublic([
            'status' => true,
            'alias'  => $alias,
            'except' => ['content', 'content2', 'content3', 'content4', 'content5'],
        ])->firstOrFail();

        $this->data['products'] = $current;

        $allProducts = Products::getsPublic([
            'status'  => true,
            'orderBy' => 'sort_order',
            'except'  => ['content', 'short_content'],
        ]);

        $this->data['product'] = $allProducts
            ->where('id', '!=', $current->id)
            ->values();

        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/products/view', $this->data);
    }

    public function archive_vacancy(Request $request): array|object
    {
        $this->data['sel'] = 'archive_vacancy';
        session(['sel' => 'archive_vacancy']);
        $post = $this->menu->getByAliasORLinkPublic("vacancy");
        $this->data['vacancy'] = Main::paginatePublic([
            'status' => true,
            'group' => 'arxiv_vacancy',
            'orderBy' => 'sort_order',
            'limit' => 10,
            'except' => ['content', 'short_content']]);
        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/archive_vacancy/index', $this->data);
    }

    public function arxiv_vacancy_view($alias)
    {
        $this->data['sel'] = 'vacancy';
        session(['sel' => 'vacancy']);
        $post = $this->menu->getByAliasORLinkPublic("vacancy");
        $this->data['arxiv_vacancy'] = Main::getsPublic([
            'status' => true,
            'group' => 'arxiv_vacancy',
            'alias' => $alias,
            'except'=>['content', 'content_2', 'short_content']
        ])->firstOrFail();
        $sessionKey = 'arxiv_vacancy_viewed_' . $this->data['arxiv_vacancy']->id;
        if (!session()->has($sessionKey)) {
            $this->data['arxiv_vacancy']->increment('views');
            session()->put($sessionKey, true);
        }
        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/archive_vacancy/view', $this->data);
    }

    public function vacancy(Request $request)
    {
        $this->data['sel'] = 'vacancy';
        session(['sel' => 'vacancy']);

        $menuPost = $this->menu->getByAliasORLinkPublic("vacancy");
        $this->metaParams($menuPost);
        $this->getSidebar($menuPost);

        $this->data['region'] = Main::query()
            ->where('status', true)
            ->where('group', 'region')
            ->orderBy('sort_order')
            ->get();

        $this->data['city'] = Main::query()
            ->where('status', true)
            ->where('group', 'city')
            ->orderBy('sort_order')
            ->get();

        $this->data['structural'] = Main::query()
            ->where('status', true)
            ->where('group', 'structural')
            ->orderBy('sort_order')
            ->get();

        $this->data['vacancy_category'] = Main::query()
            ->where('status', true)
            ->where('group', 'vacancy_category')
            ->orderBy('sort_order')
            ->get();

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');

        // 🔥 Build mapping: structural.id (cat_id2) -> [vacancy_category.id (cat_id), ...]
        $structVacMap = Main::query()
            ->select('cat_id2', 'cat_id')
            ->where('status', true)
            ->where('group', 'vacancy')
            ->whereNotNull('cat_id2')
            ->whereNotNull('cat_id')
            ->get()
            ->groupBy('cat_id2')
            ->map(function ($rows) {
                return $rows->pluck('cat_id')->unique()->values();
            })
            ->toArray();

        $this->data['structVacMap'] = $structVacMap;

        // ---------------- filters ----------------
        $regionOldId = $request->get('region_id');
        $cityOldId   = $request->get('city_id');
        $structId    = $request->get('cat_id2');
        $vacCatId    = $request->get('cat_id');

        $newsQuery = Main::query()
            ->where('status', true)
            ->where('group', 'vacancy');

        if ($regionOldId && !$cityOldId) {
            $cityOldIds = Main::query()
                ->where('status', true)
                ->where('group', 'city')
                ->where('cat_id', $regionOldId)   // city.cat_id = region.old_id
                ->pluck('old_id');

            if ($cityOldIds->count()) {
                $newsQuery->whereIn('options', $cityOldIds);  // vacancy.options = city.old_id
            } else {
                $newsQuery->whereRaw('1 = 0');
            }
        }

        if ($cityOldId) {
            $newsQuery->where('options', $cityOldId);        // vacancy.options = city.old_id
        }

        if ($structId) {
            $newsQuery->where('cat_id2', $structId);         // structural filter
        }

        if ($vacCatId) {
            $newsQuery->where('cat_id', $vacCatId);          // vacancy category filter
        }

        $news = $newsQuery
            ->orderBy('created_at', 'desc')
            ->paginate(9)
            ->appends($request->query());

        $this->data['news'] = $news;

        return view('public/agmk/vacancy/index', $this->data);
    }

    public function vacancy_view($alias)
    {
        $this->data['sel'] = 'vacancy';
        session(['sel' => 'vacancy']);
        $post = $this->menu->getByAliasORLinkPublic("vacancy");
        $this->data['vacancy'] = Main::getsPublic([
            'status' => true,
            'group' => 'vacancy',
            'alias' => $alias,
            'except'=>['content', 'content_2', 'short_content']
        ])->firstOrFail();
        $sessionKey = 'vacancy_viewed_' . $this->data['vacancy']->id;
        if (!session()->has($sessionKey)) {
            $this->data['vacancy']->increment('views');
            session()->put($sessionKey, true);
        }
        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/vacancy/view', $this->data);
    }

    public function sovet(Request $request): array|object
    {
        $this->data['sel'] = 'sovet';
        session(['sel' => 'sovet']);
        $post = $this->menu->getByAliasORLinkPublic("sovet");
        $this->data['sovet'] = Main::paginatePublic([
            'status' => true,
            'group' => 'sovet',
            'orderBy' => 'sort_order',
            'limit' => 10,
            'except' => ['content', 'short_content']]);

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/sovet/index', $this->data);
    }

    public function organ(Request $request): array|object
    {
        $this->data['sel'] = 'organ';
        session(['sel' => 'organ']);
        $post = $this->menu->getByAliasORLinkPublic("organ");
        $this->data['organ'] = Main::paginatePublic([
            'status' => true,
            'group' => 'organ',
            'orderBy' => 'sort_order',
            'limit' => 10,
            'except' => ['content', 'short_content']]);

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/organ/index', $this->data);
    }

    public function partners(Request $request): array|object
    {
        $this->data['sel'] = 'partners';
        session(['sel' => 'partners']);
        $post = $this->menu->getByAliasORLinkPublic("partners");

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');

        $this->data['partners'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'partners',
            'orderBy' => 'sort_order',
            'except'  => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));

        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/pages/partners', $this->data);
    }

    public function about(Request $request): array|object
    {
        $this->data['sel'] = 'about';
        session(['sel' => 'about']);
        $post = $this->menu->getByAliasORLinkPublic("about-the-company");

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');

        $this->data['about_stats'] = Main::getsPublic([
            'status' => true,
            'group'  => 'about_stats',
            'except' => ['content', 'short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));

        // blade uses: content ?? short_content — keep both
        $this->data['history'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'history',
            'orderBy' => 'sort_order',
            'except'  => ['content', 'short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));

        // blade uses: short_content
        $this->data['values'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'values',
            'orderBy' => 'sort_order',
            'except'  => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));

        // blade uses: short_content
        $this->data['about_entities'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'about_entities',
            'orderBy' => 'sort_order',
            'except'  => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));

        // blade uses: title only — exclude both content fields
        $this->data['operations'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'operations',
            'orderBy' => 'sort_order',
            'except'  => ['content', 'short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));

        $this->data['mission'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'mission',
            'orderBy' => 'sort_order',
            'limit'   => 1,
            'except'  => ['content', 'short_content'],
        ])->first();

        $this->data['org_parent'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'org_parent',
            'orderBy' => 'sort_order',
            'limit'   => 1,
            'except'  => ['content', 'short_content'],
        ])->first();

        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/pages/about', $this->data);
    }
    
     public function projects(Request $request): array|object
    {
        $this->data['sel'] = 'projects';
        session(['sel' => 'projects']);
        $post = $this->menu->getByAliasORLinkPublic("projects");

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');

        $this->data['ops_table'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'ops_table',
            'orderBy' => 'sort_order',
            'except'  => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));

        $this->data['ops_regions'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'ops_regions',
            'orderBy' => 'sort_order',
            'except'  => ['content', 'short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));

        $this->data['ops_routes'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'ops_routes',
            'orderBy' => 'sort_order',
            'except'  => ['content'],
        ])->filter(fn($item) => !empty(_t($item->title)));

        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/pages/projects', $this->data);
    }
    
      public function services(Request $request): array|object
    {
        $this->data['sel'] = 'services';
        session(['sel' => 'services']);
        $post = $this->menu->getByAliasORLinkPublic("services");
       

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');

        $this->data['services_caps'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'services_caps',
            'orderBy' => 'sort_order',
            'except'  => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));

        $this->data['services_process'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'services_process',
            'orderBy' => 'sort_order',
            'except'  => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));

        $this->data['svc_commodities'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'svc_commodities',
            'orderBy' => 'sort_order',
            'except'  => ['content', 'short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));

        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/pages/services', $this->data);
    }
    
      public function contacts(Request $request): array|object
    {
        $this->data['sel'] = 'contacts';
        session(['sel' => 'contacts']);
        $post = $this->menu->getByAliasORLinkPublic("contacts");
       

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');

        $this->data['contacts_info'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'contacts_info',
            'orderBy' => 'sort_order',
            'except'  => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));

        $this->data['offices'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'offices',
            'orderBy' => 'sort_order',
            'except'  => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));

        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/pages/contacts', $this->data);
    }


    public function investment(Request $request): array|object
    {
        $this->data['sel'] = 'investment';
        session(['sel' => 'investment']);
        $post = $this->menu->getByAliasORLinkPublic("investment");
        $this->data['investment'] = News::paginatePublic([
            'status' => true,
            'group' => 'investment',
            'orderBy' => 'sort_order',
            'limit' => 10,
            'except' => ['content', 'short_content']]);

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/investment/index', $this->data);
    }

    public function tenders(Request $request): array|object
    {
        $this->data['sel'] = 'tenders';
        session(['sel' => 'tenders']);
        $post = $this->menu->getByAliasORLinkPublic("tenders");
        $this->data['tenders'] = News::paginatePublic([
            'status' => true,
            'group' => 'tenders',
            'orderBy' => 'sort_order',
            'limit' => 10,
            'except' => ['content', 'short_content']]);

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/tenders/index', $this->data);
    }
    public function tenders_view($alias)
    {
        $this->data['sel'] = 'tenders';
        session(['sel' => 'tenders']);
        $post = $this->menu->getByAliasORLinkPublic("tenders");
        $this->data['tenders'] = News::getsPublic([
            'status' => true,
            'group' => 'tenders',
            'alias' => $alias,
            'except'=>['content', 'short_content']
        ])->firstOrFail();
        $sessionKey = 'tenders_viewed_' . $this->data['tenders']->id;
        if (!session()->has($sessionKey)) {
            $this->data['tenders']->increment('views');
            session()->put($sessionKey, true);
        }
        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/tenders/view', $this->data);
    }

    public function investment_view($alias)
    {
        $this->data['sel'] = 'investment';
        session(['sel' => 'investment']);
        $post = $this->menu->getByAliasORLinkPublic("investment");
        $this->data['investment'] = News::getsPublic([
            'status' => true,
            'group' => 'investment',
            'alias' => $alias,
            'except'=>['content', 'short_content']
        ])->firstOrFail();
        $sessionKey = 'investment_viewed_' . $this->data['investment']->id;
        if (!session()->has($sessionKey)) {
            $this->data['investment']->increment('views');
            session()->put($sessionKey, true);
        }
        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/investment/view', $this->data);
    }
    public function sobranie_view($alias)
    {
        $this->data['sel'] = 'sobranie';
        session(['sel' => 'sobranie']);
        $post = $this->menu->getByAliasORLinkPublic("sobranie");
        $this->data['sobranie'] = News::getsPublic([
            'status' => true,
            'group' => 'sobranie',
            'alias' => $alias,
            'except'=>['content', 'short_content']
        ])->firstOrFail();
        $sessionKey = 'sobranie_viewed_' . $this->data['sobranie']->id;
        if (!session()->has($sessionKey)) {
            $this->data['sobranie']->increment('views');
            session()->put($sessionKey, true);
        }
        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/sobranie/view', $this->data);
    }

    public function press_conference(Request $request): array|object
    {
        $this->data['sel'] = 'press-conference';
        session(['sel' => 'press-conference']);
        $post = $this->menu->getByAliasORLinkPublic("press-conference");
        $this->data['press_conference'] = News::paginatePublic([
            'status' => true,
            'group' => 'press_conference',
            'orderBy' => 'sort_order',
            'limit' => 10,
            'except' => ['content', 'short_content']]);

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/press_conference/index', $this->data);
    }
    public function press_conference_view($alias)
    {
        $this->data['sel'] = 'press_conference';
        session(['sel' => 'press_conference']);
        $post = $this->menu->getByAliasORLinkPublic("press-conference");
        $this->data['press_conference'] = News::getsPublic([
            'status' => true,
            'group' => 'press_conference',
            'alias' => $alias,
            'except'=>['content', 'short_content']
        ])->firstOrFail();
        $sessionKey = 'press-conference_viewed_' . $this->data['press_conference']->id;
        if (!session()->has($sessionKey)) {
            $this->data['press_conference']->increment('views');
            session()->put($sessionKey, true);
        }
        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/press_conference/view', $this->data);
    }

    public function mining(Request $request): array|object
    {
        $this->data['sel'] = 'mining';
        session(['sel' => 'mining']);
        $post = $this->menu->getByAliasORLinkPublic("mining");
        $this->data['mining'] = News::paginatePublic([
            'status' => true,
            'group' => 'mining',
            'orderBy' => 'sort_order',
            'limit' => 10,
            'except' => ['content', 'short_content']]);

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/mining/index', $this->data);
    }

    public function complex(Request $request): array|object
    {
        $this->data['sel'] = 'complex';
        session(['sel' => 'complex']);
        $post = $this->menu->getByAliasORLinkPublic("complex");
        $this->data['complex'] = News::paginatePublic([
            'status' => true,
            'group' => 'complex',
            'orderBy' => 'sort_order',
            'limit' => 10,
            'except' => ['content', 'short_content']]);

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/complex/index', $this->data);
    }

    public function metallurgija(Request $request): array|object
    {
        $this->data['sel'] = 'metallurgija';
        session(['sel' => 'metallurgija']);
        $post = $this->menu->getByAliasORLinkPublic("metallurgija");
        $this->data['metallurgija'] = News::paginatePublic([
            'status' => true,
            'group' => 'metallurgija',
            'orderBy' => 'sort_order',
            'limit' => 10,
            'except' => ['content', 'short_content']]);

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/metallurgija/index', $this->data);
    }

    public function auxiliary(Request $request): array|object
    {
        $this->data['sel'] = 'auxiliary';
        session(['sel' => 'auxiliary']);
        $post = $this->menu->getByAliasORLinkPublic("auxiliary");
        $this->data['auxiliary'] = News::paginatePublic([
            'status' => true,
            'group' => 'auxiliary',
            'orderBy' => 'sort_order',
            'limit' => 10,
            'except' => ['content', 'short_content']]);

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/auxiliary/index', $this->data);
    }

    public function transport(Request $request): array|object
    {
        $this->data['sel'] = 'transport';
        session(['sel' => 'transport']);
        $post = $this->menu->getByAliasORLinkPublic("transport");
        $this->data['transport'] = News::paginatePublic([
            'status' => true,
            'group' => 'transport',
            'orderBy' => 'sort_order',
            'limit' => 10,
            'except' => ['content', 'short_content']]);

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/transport/index', $this->data);
    }
    public function transport_view($alias)
    {
        $this->data['sel'] = 'transport';
        session(['sel' => 'transport']);
        $post = $this->menu->getByAliasORLinkPublic("transport");
        $this->data['transport'] = News::getsPublic([
            'status' => true,
            'group' => 'transport',
            'alias' => $alias,
            'except'=>['content', 'content_2', 'short_content']
        ])->firstOrFail();
        $sessionKey = 'transport_viewed_' . $this->data['transport']->id;
        if (!session()->has($sessionKey)) {
            $this->data['transport']->increment('views');
            session()->put($sessionKey, true);
        }
        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/transport/view', $this->data);
    }
    public function auxiliary_view($alias)
    {
        $this->data['sel'] = 'auxiliary';
        session(['sel' => 'auxiliary']);
        $post = $this->menu->getByAliasORLinkPublic("auxiliary");
        $this->data['auxiliary'] = News::getsPublic([
            'status' => true,
            'group' => 'auxiliary',
            'alias' => $alias,
            'except'=>['content', 'content_2', 'short_content']
        ])->firstOrFail();
        $sessionKey = 'auxiliary_viewed_' . $this->data['auxiliary']->id;
        if (!session()->has($sessionKey)) {
            $this->data['auxiliary']->increment('views');
            session()->put($sessionKey, true);
        }
        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/auxiliary/view', $this->data);
    }
    public function metallurgija_view($alias)
    {
        $this->data['sel'] = 'metallurgija';
        session(['sel' => 'metallurgija']);
        $post = $this->menu->getByAliasORLinkPublic("metallurgija");
        $this->data['metallurgija'] = News::getsPublic([
            'status' => true,
            'group' => 'metallurgija',
            'alias' => $alias,
            'except'=>['content', 'content_2', 'short_content']
        ])->firstOrFail();
        $sessionKey = 'metallurgija_viewed_' . $this->data['metallurgija']->id;
        if (!session()->has($sessionKey)) {
            $this->data['metallurgija']->increment('views');
            session()->put($sessionKey, true);
        }
        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/metallurgija/view', $this->data);
    }

    public function uppt(Request $request): array|object
    {
        $this->data['sel'] = 'uppt';
        session(['sel' => 'uppt']);
        $post = $this->menu->getByAliasORLinkPublic("uppt");
        $this->data['uppt'] = News::paginatePublic([
            'status' => true,
            'group' => 'uppt',
            'orderBy' => 'sort_order',
            'limit' => 10,
            'except' => ['content', 'short_content']]);

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/uppt/index', $this->data);
    }

    public function vote(Request $request): array|object
    {
        $this->data['sel'] = 'vote';
        session(['sel' => 'vote']);
        $post = $this->menu->getByAliasORLinkPublic("vote");
        $this->data['polls'] = Polls::paginatePublic([
            'status' => true,
            'orderBy' => 'sort_order',
            'limit' => 10,
            'except' => ['content', 'short_content']]);

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/vote/index', $this->data);
    }
    public function mining_view($alias)
    {
        $this->data['sel'] = 'mining';
        session(['sel' => 'mining']);
        $post = $this->menu->getByAliasORLinkPublic("mining");
        $this->data['mining'] = News::getsPublic([
            'status' => true,
            'group' => 'mining',
            'alias' => $alias,
            'except'=>['content', 'content_2', 'short_content']
        ])->firstOrFail();
        $sessionKey = 'mining_viewed_' . $this->data['mining']->id;
        if (!session()->has($sessionKey)) {
            $this->data['mining']->increment('views');
            session()->put($sessionKey, true);
        }
        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/mining/view', $this->data);
    }

    public function news_view($alias)
    {
        $this->data['sel'] = 'news';
        session(['sel' => 'news']);
        $post = $this->menu->getByAliasORLinkPublic("novosti");
        $this->data['news'] = News::getsPublic([
            'status' => true,
            'group' => 'news',
            'alias' => $alias,
            'except'=>['content', 'content_2', 'short_content']
        ])->firstOrFail();
        $sessionKey = 'news_viewed_' . $this->data['news']->id;
        if (!session()->has($sessionKey)) {
            $this->data['news']->increment('views');
            session()->put($sessionKey, true);
        }
        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/news/view', $this->data);
    }

    public function smi_view($alias)
    {
        $this->data['sel'] = 'smi';
        session(['sel' => 'smi']);
        $post = $this->menu->getByAliasORLinkPublic("smi-onas");
        $this->data['smi'] = News::getsPublic([
            'status' => true,
            'group' => 'smi',
            'alias' => $alias,
            'except'=>['content', 'content_2', 'short_content']
        ])->firstOrFail();
        $sessionKey = 'smi_viewed_' . $this->data['smi']->id;
        if (!session()->has($sessionKey)) {
            $this->data['smi']->increment('views');
            session()->put($sessionKey, true);
        }
        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/smi/view', $this->data);
    }
    public function vesty_view($alias)
    {
        $this->data['sel'] = 'vesty';
        session(['sel' => 'vesty']);
        $post = $this->menu->getByAliasORLinkPublic("trade-union-news");
        $this->data['vesty'] = News::getsPublic([
            'status' => true,
            'group' => 'vesty',
            'alias' => $alias,
            'except'=>['content', 'content_2', 'short_content']
        ])->firstOrFail();
        $sessionKey = 'vesty_viewed_' . $this->data['vesty']->id;
        if (!session()->has($sessionKey)) {
            $this->data['vesty']->increment('views');
            session()->put($sessionKey, true);
        }
        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/vesty/view', $this->data);
    }
    public function uppt_view($alias)
    {
        $this->data['sel'] = 'uppt';
        session(['sel' => 'uppt']);
        $post = $this->menu->getByAliasORLinkPublic("uppt");
        $this->data['uppt'] = News::getsPublic([
            'status' => true,
            'group' => 'uppt',
            'alias' => $alias,
            'except'=>['content', 'content_2', 'short_content']
        ])->firstOrFail();
        $sessionKey = 'uppt_viewed_' . $this->data['uppt']->id;
        if (!session()->has($sessionKey)) {
            $this->data['uppt']->increment('views');
            session()->put($sessionKey, true);
        }
        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/uppt/view', $this->data);
    }

    public function analitik(Request $request): array|object
    {
        $this->data['sel'] = 'analitik';
        session(['sel' => 'analitik']);

        $post = $this->menu->getByAliasORLinkPublic("analitik");

        $analitik = Main::paginatePublic([
            'status'  => true,
            'group'   => 'analitik',
            'orderBy' => 'sort_order',
            'limit'   => 10,
            'except'  => ['content', 'short_content'],
        ]);

        $this->data['analitik'] = $analitik;

        $ids = collect($analitik->items())->pluck('id')->all();

        $docsByPost = Docs::where('group', 'analitik')
            ->whereIn('cat_id', $ids)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('cat_id');

        $this->data['docsByPost'] = $docsByPost;

        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');

        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/analitik/index', $this->data);
    }
    public function apparat_view($alias)
    {
        $this->data['sel'] = 'apparat';
        session(['sel' => 'apparat']);
        $post = $this->menu->getByAliasORLinkPublic("apparat");
        $this->data['apparat'] = Main::getsPublic([
            'status' => true,
            'group' => 'apparat',
            'alias' => $alias,
            'except'=>['content', 'content_2', 'short_content']
        ])->firstOrFail();

        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/apparat/view', $this->data);
    }
    public function analitik_view($alias)
    {
        $this->data['sel'] = 'analitik';
        session(['sel' => 'analitik']);
        $post = $this->menu->getByAliasORLinkPublic("analitik");
        $this->data['analitik'] = Main::getsPublic([
            'status' => true,
            'group' => 'analitik',
            'alias' => $alias,
            'except'=>['content', 'content_2', 'short_content']
        ])->firstOrFail();
        $sessionKey = 'analitik_viewed_' . $this->data['analitik']->id;

        if (!session()->has($sessionKey)) {
            $this->data['analitik']->increment('views');
            session()->put($sessionKey, true);
        }

        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/analitik/view', $this->data);
    }

    public function leadership(Request $request): array|object
    {
        $this->data['sel'] = 'leadership';
        session(['sel' => 'leadership']);
        $post = $this->menu->getByAliasORLinkPublic("leadership");
        $this->data['leadership'] = Main::paginatePublic([
            'status' => true,
            'group' => 'leadership',
            'orderBy' => 'sort_order',
            'limit' => 10,
            'except' => ['content', 'short_content']]);
        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/leadership/index', $this->data);
    }
    public function leadership_view($alias)
    {
        $this->data['sel'] = 'leadership';
        session(['sel' => 'leadership']);
        $post = $this->menu->getByAliasORLinkPublic("leadership");
        $this->data['leadership'] = Main::getsPublic([
            'status' => true,
            'group' => 'leadership',
            'alias' => $alias,
            'except'=>['content', 'content_2', 'short_content']
        ])->firstOrFail();

        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/agmk/leadership/view', $this->data);
    }

    public function video(Request $request)
    {
        $this->data['sel'] = 'video';
        session(['sel' => 'video']);

        $post = $this->menu->getByAliasORLinkPublic("video");

        $this->data['video'] = Video::where('status', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->through(function ($item) {
                return !empty(_t($item->title)) ? $item : null;
            });

        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/pages/video', $this->data);
    }

    public function gallery(Request $request)
    {
        $lang = LANG;
        $this->data['sel'] = 'gallery';
        session(['sel' => 'gallery']);
        $post = $this->menu->getByAliasORLinkPublic("gallery");
        $this->data['gallery'] = Gallery::where('status', true)
            ->whereJsonDoesntContain('title', [$lang => null])
            ->whereJsonDoesntContain('title', [$lang => ''])
            ->orderBy('sort_order')
            ->get();
        $this->data['testimonials'] = Main::getsPublic([
            'status' => true,
            'group' => 'testimonials',
            'orderBy' => 'sort_order',
            'except' => ['content', 'short_content']])
            ->filter(fn($item) => !empty(_t($item->title) ?? null));
        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/pages/gallery', $this->data);
    }

    public function news()
    {
        $this->data['sel'] = 'news';
        session(['sel' => 'news']);
        $post = $this->menu->getByAliasORLinkPublic("novosti");
        $this->data['news'] = News::paginatePublic([
            'status' => true,
            'group' => 'news',
            'limit' => 12,
            'except' => ['content', 'short_content']]);

        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/news/index', $this->data);
    }

    public function vesty()
    {
        $this->data['sel'] = 'vesty';
        session(['sel' => 'vesty']);
        $post = $this->menu->getByAliasORLinkPublic("trade-union-news");
        $this->data['vesty'] = News::paginatePublic([
            'status' => true,
            'group' => 'vesty',
            'limit' => 12,
            'except' => ['content', 'short_content']]);

        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/vesty/index', $this->data);
    }

    public function smi()
    {
        $this->data['sel'] = 'smi';
        session(['sel' => 'smi']);
        $post = $this->menu->getByAliasORLinkPublic("smi-onas");
        $this->data['smi'] = News::paginatePublic([
            'status' => true,
            'group' => 'smi',
            'limit' => 12,
            'except' => ['content', 'short_content']]);

        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/agmk/smi/index', $this->data);
    }

    public function sitemap(): \Illuminate\View\View
    {
        $this->data['sel'] = 'sitemap';
        session(['sel' => 'sitemap']);

        $preferredLangs = ['oz', 'ru', 'en'];

        $menus = Menu::where('status', true)->get();

        $menus = $menus->filter(function ($item) use ($preferredLangs) {
            $titles = (array)$item->title;
            foreach ($preferredLangs as $lang) {
                if (!empty($titles[$lang])) {
                    return true;
                }
            }
            return false;
        });

        $menus = $menus->map(function ($item) use ($preferredLangs) {
            $titles = (array)$item->title;
            foreach ($preferredLangs as $lang) {
                if (!empty($titles[$lang])) {
                    $item->translated_title = $titles[$lang];
                    return $item;
                }
            }
            $item->translated_title = '';
            return $item;
        });

        $groupedMenus = $menus->groupBy('cat_id');
        $this->data['menus'] = $groupedMenus;

        return view('public/pages/sitemap', $this->data);
    }


    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            $options
        );
    }

    public function rss()
    {
        $posts = News::where('group', 'news')
            ->where('status', true)
            ->latest()
            ->take(50)
            ->get();

        $content = View::make('public.pages.rss', [
            'feed_name' => 'Новости',
            'encoding' => 'utf-8',
            'feed_url' => url('/'),
            'page_description' => 'Новости',
            'page_language' => 'oz',
            'creator_email' => url('/'),
            'news' => $posts,
        ]);

        return Response::make($content, 200)
            ->header('Content-Type', 'application/rss+xml; charset=UTF-8');
    }

    public function recordDownload(Request $request)
    {
        $alias = $request->input('alias');

        if (!$alias) {
            return response()->json(['ok' => false], 422);
        }

        $row = Opendata::whereColumn('alias', 'options')->where('alias', $alias)->first();

        if (!$row) {
            return response()->json(['ok' => false], 404);
        }

        $row->increment('downloads');

        return response()->json(['ok' => true, 'count' => $row->downloads]);
    }
    private function fetchOpendataListFromApi(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;

        $url = "https://data.egov.uz/apiClient/main/gettable"
            . "?orgId=457"
            . "&limit={$perPage}"
            . "&offset={$offset}"
            . "&sortType=1";

        $response = Http::withoutVerifying()->get($url);

        if (!$response->successful()) {
            return [
                'items' => [],
                'total' => 0,
            ];
        }

        $json = $response->json();

        return [
            'items' => $json['result']['data']  ?? [],
            'total' => $json['result']['count'] ?? 0,
        ];
    }

    public function investment_strategy(Request $request): array|object
    {
        $this->data['sel'] = 'investment-strategy';
        session(['sel' => 'investment-strategy']);
        $post = $this->menu->getByAliasORLinkPublic("investment-strategy");
        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->data['inv_pillars'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'inv_pillars',
            'orderBy' => 'sort_order',
            'except'  => ['content', 'short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/pages/investment', $this->data);
    }

    public function upstream(Request $request): array|object
    {
        $this->data['sel'] = 'upstream';
        session(['sel' => 'upstream']);
        $post = $this->menu->getByAliasORLinkPublic("upstream");
        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->data['ups_segments'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'ups_segments',
            'orderBy' => 'sort_order',
            'except'  => ['content', 'short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/pages/upstream', $this->data);
    }

    public function logistics(Request $request): array|object
    {
        $this->data['sel'] = 'logistics';
        session(['sel' => 'logistics']);
        $post = $this->menu->getByAliasORLinkPublic("logistics");
        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->metaParams($post);
        $this->getSidebar($post);
        $this->data['log_hubs'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'log_hubs',
            'orderBy' => 'sort_order',
            'except'  => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));

        $this->data['log_corridors'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'log_corridors',
            'orderBy' => 'sort_order',
        ])->filter(fn($item) => !empty(_t($item->title)));

        return view('public/pages/logistics', $this->data);
    }

    public function refinery(Request $request): array|object
    {
        $this->data['sel'] = 'refinery';
        session(['sel' => 'refinery']);
        $post = $this->menu->getByAliasORLinkPublic("refinery");
        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->data['ref_products'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'ref_products',
            'orderBy' => 'sort_order',
            'except'  => ['content'],
        ])->filter(fn($item) => !empty(_t($item->title)));
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/pages/refinery', $this->data);
    }

    public function fuel_retail(Request $request): array|object
    {
        $this->data['sel'] = 'fuel-retail';
        session(['sel' => 'fuel-retail']);
        $post = $this->menu->getByAliasORLinkPublic("fuel-retail");
        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->data['fr_steps'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'fr_steps',
            'orderBy' => 'sort_order',
            'except'  => ['content', 'short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/pages/fuel-retail', $this->data);
    }

    public function team(Request $request): array|object
    {
        $this->data['sel'] = 'team';
        session(['sel' => 'team']);
        $post = $this->menu->getByAliasORLinkPublic("team");
        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->data['team'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'team',
            'orderBy' => 'sort_order',
            'except'  => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/pages/team', $this->data);
    }

    public function geography(Request $request): array|object
    {
        $this->data['sel'] = 'geography';
        session(['sel' => 'geography']);
        $post = $this->menu->getByAliasORLinkPublic("geography");
        $this->data['p'] = Pages::getsPublic(['limit' => 500])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('options');
        $this->data['geo_countries'] = Main::getsPublic([
            'status'  => true,
            'group'   => 'geo_countries',
            'orderBy' => 'sort_order',
            'except'  => ['short_content'],
        ])->filter(fn($item) => !empty(_t($item->title)));
        $this->metaParams($post);
        $this->getSidebar($post);
        return view('public/pages/geography', $this->data);
    }

}
