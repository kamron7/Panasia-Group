@php
    $tab_input = [
        'title'         => a_lang('title'),         // e.g. "Commodity Sourcing"
        'short_content' => a_lang('short_content'), // description paragraph
    ];
    $btns = [];
    $includes = ['alias', 'status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    {{-- options = icon name (feather), e.g. "search" --}}
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('icon')"/>
    @include("admin/save_components/includes")
</x-admin.save>
