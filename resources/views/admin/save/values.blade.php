@php
    $tab_input = [
        'title'         => a_lang('title'),
        'short_content' => a_lang('short_content'),
    ];
    $btns = array();
    $includes = array('status', 'btns');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    {{-- options = category label, e.g. "Integrity" --}}
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('category')"/>
    @include("admin/save_components/includes")
</x-admin.save>
