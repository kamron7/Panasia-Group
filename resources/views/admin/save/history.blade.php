@php
    $tab_input = [
        'title' => a_lang('title'),
    ];
    $tab_note = [
        'content' => a_lang('content'),
    ];
    $btns = array();
    $includes = array('status', 'btns');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    {{-- options = year, e.g. "2024" --}}
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('year')"/>
    @include("admin/save_components/includes")
</x-admin.save>
