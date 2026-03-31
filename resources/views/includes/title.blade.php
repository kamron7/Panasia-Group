@php($sel= session('sel'))
<?php

echo match ($sel) {
    'home' => removeTags(_t($meta_global->title ?? '')),
    'search' => p_lang('search_result'),
    'sitemap' => p_lang('sitemap'),
    'faq' => p_lang('faq'),
    default => _t(session('title')),
};

