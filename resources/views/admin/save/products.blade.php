@php
    $tab_input = [
        'title' => a_lang('title'),
    ];
      $tab_input2 = [
              'content3' => a_lang('gost'),
    ];

    $tab_note = [
        'content4' => a_lang('content'),
        'content2' => a_lang('table'),
        'content5' => a_lang('prim'),
        'content' => a_lang('forma_i'),
    ];
    $btns = ['media'];
    $includes = ['alias','meta', 'status', 'btns'];

    $vacancyCats = \App\Models\Main::where('group', 'product_category')->orderBy('sort_order')->get();
@endphp
<x-admin.save :type="$type">
    @include("admin/save_components/tab")

    <div class="form-group">
        <label for="cat_id">{{ a_lang('product_category') }}</label>
        <select name="cat_id" id="cat_id" class="form-control">
            <option value="">{{ a_lang('select') }}</option>
            @foreach($vacancyCats as $cat)
                <option value="{{ $cat->id }}"
                        @if(isset($post) && $post->cat_id == $cat->id) selected @endif>
                    {{ _t($cat->title) }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="control-group">
                {{--                <label class="control-label" for="focusedInput">Дата</label>--}}
                <div class="controls">
                    <x-admin.dates name="created_at" class="w-50" :value="a_lang('date_create')" :post="$post ?? null"/>
                </div>
            </div>
        </div>


    </div>
    <script type="text/javascript">
        $(function() {
            $("#date").datetimepicker({
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'dd.mm.yy'
            });
            $("#date1").datepicker({
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'dd/mm/yy'
            });
            $("#date2").datepicker({
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'dd/mm/yy'
            });
        });
    </script>


    @include("admin/save_components/includes")
</x-admin.save>
