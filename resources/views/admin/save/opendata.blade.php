@php
    $tab_input = [
        'title' => a_lang('savol'),
    ];

   $btns = array('media', 'docs');
    $includes = array('status', 'btns');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    <x-admin.input name="options" :value="a_lang('options')" :post="$post ?? null"/>
    @include("admin/save_components/includes")
</x-admin.save>
