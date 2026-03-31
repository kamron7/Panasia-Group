@php
    $tab_input = [
        'title' => a_lang('title'),
    ];
    $tab_note = [
        'short_content' => a_lang('short_content'),
    ];

    $btns = array('media');
    $includes = array('status', 'btns');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
{{--    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('link')"/>--}}
    @include("admin/save_components/includes")
</x-admin.save>
