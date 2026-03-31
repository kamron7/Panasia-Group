@php
    $tab_input = [
        'title' => a_lang('title'),
    ];
    $tab_input2 = [];
    $btns = array('media');
    $includes = array('alias', 'status', 'btns');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    @include("admin/save_components/includes")
</x-admin.save>
