<x-app-layout>

    @include('admin/save_components/header_save')

    <form action="" method="POST" class="form-horizontal my_form"
          enctype="multipart/form-data">
        @csrf
        @if($type == 'edit')
            @method('patch')
        @endif

        {{$slot}}

        <div class="form-actions">
            <button type="reset" class="btn btn-success mr-1 mb-1" onclick="history.go(-1)">{{ a_lang('save') }}</button>
        </div>
    </form>

</x-app-layout>
