@php
    $tab_input = [
        'title'         => a_lang('title'),         // partner company name
        'short_content' => a_lang('short_content'),  // short description
    ];
    $btns = ['media'];
    $includes = ['alias', 'status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    {{-- options2 = abbreviation shown in logo placeholder, e.g. "SOCAR" --}}
    <x-admin.input :post="$post ?? null" name="options2" :value="a_lang('abbreviation')"/>
    {{-- options = country / region label, e.g. "Azerbaijan" --}}
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('country')"/>
    @include("admin/save_components/includes")
</x-admin.save>
