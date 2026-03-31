@php
    $tab_input = [
        'title' => a_lang('title'),
    ];
      $btns = array('media', 'docs');
    $includes = ['alias', 'status', 'btns'];
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    @include("admin/save_components/includes")
</x-admin.save>
