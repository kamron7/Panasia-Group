@php
    $tab_input = [
        'title' => a_lang('title'),
    ];

    $includes = array('status', 'alias');
@endphp

<x-admin.save :type="$type">
    @include("admin/save_components/tab")
    <div class="row">
        <div class="col-md-4">
            <div class="control-group">
                <div class="controls">
                    <x-admin.dates name="created_at" class="w-50" :value="a_lang('date_create')" :post="$post ?? null"/>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
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
