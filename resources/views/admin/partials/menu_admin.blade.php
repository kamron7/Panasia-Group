@if(checkUserGroup())
    <li class="nav-item {{ ($sel == 'users') ? 'active' : '' }}"><a
            href="{{ url_a() . 'users' }}"><i
                class="feather icon-user"></i><span class="menu-title">{!! a_lang('users') !!}</span></a>
    </li>
    <li class="nav-item {{ ($sel == 'menu') ? 'active' : '' }}"><a href="{{ url_a() . 'menu' }}"><i
                class="feather icon-list"></i><span class="menu-title">{!! a_lang('menu') !!}</span></a>
    </li>
@endif

{{-- ══════════════════════════════════════
     ГЛАВНАЯ СТРАНИЦА
══════════════════════════════════════ --}}
<li class="nav-item">
    <a href="#"><i class="feather icon-home"></i><span class="menu-title">{!! a_lang('home_content') !!}</span></a>
    <ul class="menu-content">
        <li class="{{ ($sel == 'about_c') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/about_c' }}"><i class="feather icon-align-left"></i><span class="menu-item">{!! a_lang('about_text') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'home_stats') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/home_stats' }}"><i class="feather icon-bar-chart-2"></i><span class="menu-item">{!! a_lang('home_stats') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'home_entities') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/home_entities' }}"><i class="feather icon-briefcase"></i><span class="menu-item">{!! a_lang('home_entities') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'home_growth') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/home_growth' }}"><i class="feather icon-trending-up"></i><span class="menu-item">{!! a_lang('home_growth') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'markets') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/markets' }}"><i class="feather icon-globe"></i><span class="menu-item">{!! a_lang('markets') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'commodities') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/commodities' }}"><i class="feather icon-box"></i><span class="menu-item">{!! a_lang('commodities') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'why_cards') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/why_cards' }}"><i class="feather icon-star"></i><span class="menu-item">{!! a_lang('why_panasia_cards') !!}</span></a>
        </li>
    </ul>
</li>

{{-- ══════════════════════════════════════
     О КОМПАНИИ
══════════════════════════════════════ --}}
<li class="nav-item">
    <a href="#"><i class="feather icon-book-open"></i><span class="menu-title">{!! a_lang('about_content') !!}</span></a>
    <ul class="menu-content">
        <li class="{{ ($sel == 'about_stats') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/about_stats' }}"><i class="feather icon-bar-chart-2"></i><span class="menu-item">{!! a_lang('about_stats') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'about_entities') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/about_entities' }}"><i class="feather icon-briefcase"></i><span class="menu-item">{!! a_lang('about_entities') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'mission') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/mission' }}"><i class="feather icon-target"></i><span class="menu-item">{!! a_lang('mission_section') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'org_parent') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/org_parent' }}"><i class="feather icon-share-2"></i><span class="menu-item">{!! a_lang('org_parent_card') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'history') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/history' }}"><i class="feather icon-clock"></i><span class="menu-item">{!! a_lang('history_timeline') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'values') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/values' }}"><i class="feather icon-heart"></i><span class="menu-item">{!! a_lang('values') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'operations') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/operations' }}"><i class="feather icon-map-pin"></i><span class="menu-item">{!! a_lang('operations_countries') !!}</span></a>
        </li>
    </ul>
</li>

{{-- ══════════════════════════════════════
     КОНТАКТЫ
══════════════════════════════════════ --}}
<li class="nav-item">
    <a href="#"><i class="feather icon-phone"></i><span class="menu-title">{!! a_lang('contacts_content') !!}</span></a>
    <ul class="menu-content">
        <li class="{{ ($sel == 'contacts_info') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/contacts_info' }}"><i class="feather icon-info"></i><span class="menu-item">{!! a_lang('contacts_info_cards') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'offices') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/offices' }}"><i class="feather icon-map"></i><span class="menu-item">{!! a_lang('offices_cards') !!}</span></a>
        </li>
    </ul>
</li>

{{-- ══════════════════════════════════════
     УСЛУГИ
══════════════════════════════════════ --}}
<li class="nav-item">
    <a href="#"><i class="feather icon-layers"></i><span class="menu-title">{!! a_lang('services_content') !!}</span></a>
    <ul class="menu-content">
        <li class="{{ ($sel == 'services_caps') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/services_caps' }}"><i class="feather icon-zap"></i><span class="menu-item">{!! a_lang('services_capabilities') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'services_process') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/services_process' }}"><i class="feather icon-git-merge"></i><span class="menu-item">{!! a_lang('services_process_steps') !!}</span></a>
        </li>
    </ul>
</li>

{{-- ══════════════════════════════════════
     УСЛУГИ — ТОВАРЫ (Сommodities)
══════════════════════════════════════ --}}
<li class="nav-item {{ ($sel == 'svc_commodities') ? 'active' : '' }}">
    <a href="{{ url_a() . 'main/svc_commodities' }}"><i class="feather icon-package"></i><span class="menu-title">{!! a_lang('svc_commodities') !!}</span></a>
</li>

{{-- ══════════════════════════════════════
     ПРОЕКТЫ / ОПЕРАЦИИ
══════════════════════════════════════ --}}
<li class="nav-item">
    <a href="#"><i class="feather icon-activity"></i><span class="menu-title">{!! a_lang('projects_content') !!}</span></a>
    <ul class="menu-content">
        <li class="{{ ($sel == 'ops_table') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/ops_table' }}"><i class="feather icon-list"></i><span class="menu-item">{!! a_lang('ops_table_rows') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'ops_regions') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/ops_regions' }}"><i class="feather icon-map"></i><span class="menu-item">{!! a_lang('ops_regions_blocks') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'ops_routes') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/ops_routes' }}"><i class="feather icon-git-merge"></i><span class="menu-item">{!! a_lang('ops_routes_cards') !!}</span></a>
        </li>
    </ul>
</li>

{{-- ══════════════════════════════════════
     ИНВЕСТИЦИОННАЯ СТРАТЕГИЯ
══════════════════════════════════════ --}}
<li class="nav-item {{ ($sel == 'inv_pillars') ? 'active' : '' }}">
    <a href="{{ url_a() . 'main/inv_pillars' }}"><i class="feather icon-trending-up"></i><span class="menu-title">{!! a_lang('inv_pillars') !!}</span></a>
</li>

{{-- ══════════════════════════════════════
     ПЕРЕРАБОТКА (REFINERY)
══════════════════════════════════════ --}}
<li class="nav-item {{ ($sel == 'ref_products') ? 'active' : '' }}">
    <a href="{{ url_a() . 'main/ref_products' }}"><i class="feather icon-droplet"></i><span class="menu-title">{!! a_lang('ref_products') !!}</span></a>
</li>

{{-- ══════════════════════════════════════
     UPSTREAM / DOWNSTREAM
══════════════════════════════════════ --}}
<li class="nav-item {{ ($sel == 'ups_segments') ? 'active' : '' }}">
    <a href="{{ url_a() . 'main/ups_segments' }}"><i class="feather icon-layers"></i><span class="menu-title">{!! a_lang('ups_segments') !!}</span></a>
</li>

{{-- ══════════════════════════════════════
     АЗС (FUEL RETAIL)
══════════════════════════════════════ --}}
<li class="nav-item {{ ($sel == 'fr_steps') ? 'active' : '' }}">
    <a href="{{ url_a() . 'main/fr_steps' }}"><i class="feather icon-map-pin"></i><span class="menu-title">{!! a_lang('fr_steps') !!}</span></a>
</li>

{{-- ══════════════════════════════════════
     ЛОГИСТИКА
══════════════════════════════════════ --}}
<li class="nav-item">
    <a href="#"><i class="feather icon-truck"></i><span class="menu-title">{!! a_lang('logistics_content') !!}</span></a>
    <ul class="menu-content">
        <li class="{{ ($sel == 'log_hubs') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/log_hubs' }}"><i class="feather icon-anchor"></i><span class="menu-item">{!! a_lang('log_hubs_cards') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'log_corridors') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/log_corridors' }}"><i class="feather icon-navigation"></i><span class="menu-item">{!! a_lang('log_corridors_rows') !!}</span></a>
        </li>
    </ul>
</li>

{{-- ══════════════════════════════════════
     ГЕОГРАФИЯ
══════════════════════════════════════ --}}
<li class="nav-item {{ ($sel == 'geo_countries') ? 'active' : '' }}">
    <a href="{{ url_a() . 'main/geo_countries' }}"><i class="feather icon-globe"></i><span class="menu-title">{!! a_lang('geo_countries') !!}</span></a>
</li>

{{-- ══════════════════════════════════════
     ПАРТНЕРЫ
══════════════════════════════════════ --}}
<li class="nav-item {{ ($sel == 'partners') ? 'active' : '' }}">
    <a href="{{ url_a() . 'main/partners' }}"><i class="feather icon-users"></i><span class="menu-title">{!! a_lang('s_partners') !!}</span></a>
</li>

{{-- ══════════════════════════════════════
     НОВОСТИ
══════════════════════════════════════ --}}
<!-- <li class="nav-item {{ ($sel == 'news') ? 'active' : '' }}">
    <a href="{{ url_a() . 'news/news' }}"><i class="feather icon-file-text"></i><span class="menu-title">{!! a_lang('news') !!}</span></a>
</li> -->

{{-- ══════════════════════════════════════
     ТЕКСТЫ СТРАНИЦ (Pages)
══════════════════════════════════════ --}}
<li class="nav-item {{ ($sel == 'pages') ? 'active' : '' }}">
    <a href="{{ url_a() . 'pages' }}"><i class="feather icon-type"></i><span class="menu-title">{!! a_lang('list') !!}</span></a>
</li>

{{-- ══════════════════════════════════════
     НАСТРОЙКИ
══════════════════════════════════════ --}}
<li class="nav-item">
    <a href="#"><i class="ficon fa fa-cog"></i><span class="menu-title">{!! a_lang('setting') !!}</span></a>
    <ul class="menu-content">
        <li class="{{ ($sel == 'socials') ? 'active' : '' }}">
            <a href="{{ url_a() . 'main/socials' }}"><i class="feather icon-linkedin"></i><span class="menu-item">{!! a_lang('social') !!}</span></a>
        </li>
    </ul>
</li>

{{-- ══════════════════════════════════════
     FEEDBACK
══════════════════════════════════════ --}}
<li class="nav-item {{ ($sel == 'feedback') ? 'active' : '' }}">
    <a href="{{ url_a() . 'feedback' }}"><i class="feather icon-mail"></i><span class="menu-title">Feedback</span></a>
</li>

{{-- ══════════════════════════════════════
     МЕДИА
══════════════════════════════════════ --}}
<li class="nav-item">
    <a href="#"><i class="feather icon-grid"></i><span class="menu-title">{!! a_lang('media') !!}</span></a>
    <ul class="menu-content">
        <li class="{{ ($sel == 'gallery') ? 'active' : '' }}">
            <a href="{{ url_a() . 'gallery' }}"><i class="feather icon-image"></i><span class="menu-item">{!! a_lang('gallery') !!}</span></a>
        </li>
        <li class="{{ ($sel == 'video') ? 'active' : '' }}">
            <a href="{{ url_a() . 'video' }}"><i class="feather icon-play-circle"></i><span class="menu-item">{!! a_lang('video') !!}</span></a>
        </li>
    </ul>
</li>
