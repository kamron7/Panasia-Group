@php
    $tab_input = [
        'title' => a_lang('title'),
    ];
     $tab_input2 = [
        'content_2' => a_lang('post'),
        'content' => a_lang('Reception_days'),
    ];
      $tab_note = [
        'short_content' => a_lang('bio'),
    ];

    $btns = array('media');
    $includes = array('status', 'alias', 'btns');
//     $cats = \App\Models\Region::gets(['sort' => 'asc']);
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    <x-admin.input :post="$post ?? null" name="options" :value="a_lang('email')"/>
    <x-admin.input :post="$post ?? null" name="options2" :value="a_lang('phone')"/>
    @include("admin/save_components/includes")
</x-admin.save>
