@php
    $tab_input = [
        'title' => a_lang('title'),
    ];
    $includes = array('alias', 'status');
    $btns = array('media');
    $includes = ['alias', 'status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")

    <x-admin.input name="options" :value="a_lang('label_link')" :post="$post ?? null"/>
    <x-admin.input name="options2" :value="a_lang('icon')" :post="$post ?? null"/>

    @include("admin/save_components/includes")
</x-admin.save>
