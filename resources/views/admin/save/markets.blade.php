@php
    $tab_input = [
        'title'         => a_lang('title'),
        'short_content' => a_lang('short_content'),
    ];
    $btns = array('media');
    $includes = array('alias', 'status', 'btns');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    {{-- options2 = comma-separated country list, e.g. "Kazakhstan,Uzbekistan,Turkmenistan" --}}
    <x-admin.input :post="$post ?? null" name="options2" :value="a_lang('countries')"/>
    @include("admin/save_components/includes")
</x-admin.save>
