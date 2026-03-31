@php
    $tab_input = [
        'title' => a_lang('title'),  // e.g. "LinkedIn"
    ];
    $btns = [];
    $includes = ['alias', 'status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    {{-- options = full URL link --}}
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('label_link')"/>
    {{-- options2 = icon identifier: linkedin, telegram, instagram, etc. --}}
    <x-admin.input :post="$post ?? null" name="options2" :value="a_lang('icon')"/>
    @include("admin/save_components/includes")
</x-admin.save>
