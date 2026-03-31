@php
    $tab_input = [
        'title' => a_lang('savol'),
    ];

     $tab_note = [
        'short_content' => a_lang('javob'),

    ];
   $btns = array('media');
    $includes = array('status', 'btns');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    <x-admin.input name="options" :value="a_lang('options')" :post="$post ?? null"/>

    @include("admin/save_components/includes")
</x-admin.save>
