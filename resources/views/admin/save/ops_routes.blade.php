@php
    $tab_input = [
        'title'   => a_lang('title'),
        'content' => a_lang('content'),
    ];
    $btns     = [];
    $includes = ['alias', 'status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    {{-- options = "from" node, e.g. "Central Asia" --}}
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('route_from')"/>
    {{-- options2 = "to" node, e.g. "Europe" --}}
    <x-admin.input :post="$post ?? null" name="options2" :value="a_lang('route_to')"/>
    @include("admin/save_components/includes")
</x-admin.save>
