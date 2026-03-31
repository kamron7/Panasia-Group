@php
    $tab_input = [
        'title' => a_lang('title'),
    ];
     $tab_input2 = [
        'short_content' => a_lang('post'),
    ];
    $btns = array('media');
    $includes = array('status', 'alias', 'btns');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    @include("admin/save_components/includes")
</x-admin.save>
