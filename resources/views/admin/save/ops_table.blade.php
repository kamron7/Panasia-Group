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
    {{-- options = commodity name, e.g. "Crude Oil" --}}
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('commodity')"/>
    {{-- options2 = status type: "active" or "expanding" --}}
    <x-admin.input :post="$post ?? null" name="options2" :value="a_lang('status_type')"/>
    @include("admin/save_components/includes")
</x-admin.save>
