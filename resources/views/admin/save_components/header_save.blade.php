<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">
                    @if($type == 'create')
                        {{a_lang('add')}}
                    @else
                        {{a_lang('edit')}}
                    @endif
                </h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url_a() }}">{{ a_lang('main') }}</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#" onclick="history.go(-1)"> {{ a_lang('back') }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
