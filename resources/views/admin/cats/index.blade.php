@php($sel = $sel ?? session('sel', ''))
@php($sel_g = session('sel_g', ''))
<x-app-layout>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">
                        {{ _t($cat->title) }}
                    </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url_a() }}">{{ a_lang('main') }}</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrum-right">
                <a href="{{ url_a() . "$sel/create/$cat->id" }}" class="btn btn-primary pull-right" type="button">
                    <i class="icon-plus-sign icon-white"></i>
                    <span>{{ a_lang('add') }}</span>
                </a>
            </div>
        </div>
    </div>
    @include('admin/partials/filter_posts')

    <div class="clearfix"></div>

    @if($posts)
        <div id="ajax">
            @include ('admin/cats/list')
        </div>
    @endif
</x-app-layout>

