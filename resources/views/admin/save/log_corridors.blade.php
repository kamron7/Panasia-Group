@php
    $tab_input = [
        'title' => a_lang('title'),   // corridor name, e.g. "Central Asia — Caucasus — Europe"
    ];
    $btns = [];
    $includes = ['alias', 'status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    {{-- options = corridor label, e.g. "Corridor I" --}}
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('label')"/>
    {{-- options2 = pipe-separated nodes list, e.g. "Turkmenistan|Caspian Sea|Azerbaijan|Railway|Georgia|Black Sea|Europe" --}}
    <x-admin.input :post="$post ?? null" name="options2" :value="a_lang('nodes')"/>
    @include("admin/save_components/includes")
</x-admin.save>
