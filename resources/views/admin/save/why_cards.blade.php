@php
    $tab_input = [
        'title'         => a_lang('title'),
        'short_content' => a_lang('short_content'),
    ];
    $btns = ['media'];
    $includes = ['alias', 'status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    @include("admin/save_components/includes")
</x-admin.save>
