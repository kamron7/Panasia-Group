@php
    $tab_input = [
        'title' => a_lang('title'),
    ];
    $includes = ['alias', 'status'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")

    <x-admin.input name="options" :value="a_lang('link_ru')" :post="$post ?? null"/>
    <x-admin.input name="options2" :value="a_lang('link_oz')" :post="$post ?? null"/>
    <x-admin.input name="keywords" :value="a_lang('link_uz')" :post="$post ?? null"/>

    @include("admin/save_components/includes")
</x-admin.save>
