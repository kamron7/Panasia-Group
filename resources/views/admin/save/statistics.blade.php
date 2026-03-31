@php
    $tab_input = [
        'title' => a_lang('title'),

    ];


    $includes = array('alias', 'status');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('stats')"/>
    @include("admin/save_components/includes")
</x-admin.save>
