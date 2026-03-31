@php
    $includes = array('status');
@endphp

<x-admin.save :type="$type">

    <x-admin.input name="name" :value="a_lang('name')" :post="$post ?? null " class="w-25"/>
    <x-admin.input name="ip_address" value="IP Адрес" :post="$post ?? null" class="w-25" />

    @include("admin/save_components/includes")
</x-admin.save>
