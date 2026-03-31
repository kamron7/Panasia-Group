@php
    $tab_input = [
        'title'         => a_lang('title'),
        'short_content' => a_lang('region'),
    ];
    $btns     = [];
    $includes = ['alias', 'status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    {{-- options = city/hub names, e.g. "Tashkent · Chinaz" --}}
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('location')"/>
    @include("admin/save_components/includes")
</x-admin.save>
