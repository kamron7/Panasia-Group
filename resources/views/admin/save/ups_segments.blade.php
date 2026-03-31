@php
    $tab_input = [
        'title'         => a_lang('title'),
        'short_content' => a_lang('segment_tag'),
        'content'       => a_lang('content'),
    ];
    $btns     = [];
    $includes = ['alias', 'status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    {{-- options = comma-separated regions, e.g. "Kazakhstan, Turkmenistan, Central Asia" --}}
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('countries')"/>
    @include("admin/save_components/includes")
</x-admin.save>
