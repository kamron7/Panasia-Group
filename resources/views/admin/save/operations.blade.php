@php
    $tab_input = [
        'title' => a_lang('title'),   // country name
    ];
    $btns = array();
    $includes = array('status', 'btns');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    @include("admin/save_components/includes")
</x-admin.save>
