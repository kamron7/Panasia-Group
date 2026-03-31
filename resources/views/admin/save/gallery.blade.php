@php
    $tab_input = [
        'title' => a_lang('title'),
    ];

    $btns = array('media');
    $includes = array('alias', 'status', 'btns');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
        <x-admin.input :post="$post ?? null" name="keywords" :value="a_lang('options')"/>
    @include("admin/save_components/includes")
</x-admin.save>
