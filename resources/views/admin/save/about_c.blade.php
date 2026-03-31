@php
    $tab_input = [
        'title' => a_lang('title'),
    ];
     $tab_note = [
        'short_content' => a_lang('short_content'),
    ];
    $btns = array('media');
    $includes = array('status', 'alias', 'btns');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    @include("admin/save_components/includes")
</x-admin.save>
