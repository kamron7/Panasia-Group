@php
    $tab_input = [
        'title'         => a_lang('title'),         // country, e.g. "Turkmenistan"
        'short_content' => a_lang('short_content'), // hub description
    ];
    $btns = [];
    $includes = ['alias', 'status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    {{-- options = region label, e.g. "Central Asia" --}}
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('region_tag')"/>
    {{-- options2 = comma-separated port names, e.g. "Turkmenbashi" --}}
    <x-admin.input :post="$post ?? null" name="options2" :value="a_lang('ports')"/>
    @include("admin/save_components/includes")
</x-admin.save>
