@php
    $tab_input = [
        'title'         => a_lang('title'),
        'short_content' => a_lang('pillar_tag'),
        'content'       => a_lang('content'),
    ];
    $btns     = [];
    $includes = ['alias', 'status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    @include("admin/save_components/includes")
</x-admin.save>
