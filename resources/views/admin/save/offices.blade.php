@php
    $tab_input = [
        'title'         => a_lang('title'),         // city/name, e.g. "Almaty, Kazakhstan"
        'short_content' => a_lang('short_content'), // address lines
    ];
    $btns = [];
    $includes = ['alias', 'status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    {{-- options = region tag, e.g. "Central Asia HQ" --}}
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('region_tag')"/>
    @include("admin/save_components/includes")
</x-admin.save>
