@php
    $tab_input = [
        'title' => a_lang('title'),

    ];
    $tab_input2 = [
//        'short_content' => a_lang('short_content'),
    ];

    $btns = array('media');
    $includes = array('alias', 'status', 'btns');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('stats')"/>
    @include("admin/save_components/includes")
</x-admin.save>
