@php
    $tab_input = [
        'title' => a_lang('title'),   // year label
    ];
    $tab_input2 = [
        'short_content' => a_lang('badge'),   // e.g. "↑ 2.4×"
    ];
    $btns = array();
    $includes = array('status', 'btns');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    {{-- options = shipment volume string, e.g. "784,963" --}}
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('volume')"/>
    @include("admin/save_components/includes")
</x-admin.save>
