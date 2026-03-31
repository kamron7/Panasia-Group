@php
    $tab_input = [
        'title' => a_lang('title'),
    ];
    $includes = array('meta');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")

    <x-admin.input name="email" value="E-mail (системный)" :post="$post ?? null"/>

    @include("admin/save_components/includes")
</x-admin.save>
