@php
    $tab_input = [
        'title' => a_lang('title'),
    ];


    $includes = array('status', 'alias');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    <x-admin.input :post="$post ?? null" name="cat_id" :value="a_lang('link')"/>
    @include("admin/save_components/includes")
</x-admin.save>
