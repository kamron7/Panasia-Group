<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ assets_a() }}app-assets/images/logo/osg_logo-01.svg"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- App css -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ assets_a().'app-assets/vendors/css/vendors.min.css' }}">
    <link rel="stylesheet" type="text/css"
          href="{{ assets_a().'app-assets/vendors/css/extensions/tether-theme-arrows.css' }}">
    <link rel="stylesheet" type="text/css" href="{{ assets_a().'app-assets/vendors/css/extensions/tether.min.css' }}">
    <link rel="stylesheet" type="text/css"
          href="{{ assets_a().'app-assets/vendors/css/extensions/shepherd-theme-default.css' }}">
    <!-- END: Vendor CSS-->
    <link rel='stylesheet' href='{{ assets_a().'fancybox/jquery.fancybox.min.css' }}' type='text/css'/>
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ assets_a().'app-assets/css/bootstrap.min.css' }}">
    <link rel="stylesheet" type="text/css"
          href="{{ assets_a().'app-assets/css/bootstrap-extended.css' }}">
    <link rel="stylesheet" type="text/css" href="{{ assets_a().'app-assets/css/colors.css' }}">
    <link rel="stylesheet" type="text/css" href="{{ assets_a().'app-assets/css/components.css' }}">
    <link rel="stylesheet" type="text/css" href="{{ assets_a().'app-assets/css/themes/dark-layout.css' }}">
    <link rel="stylesheet" type="text/css" href="{{ assets_a().'app-assets/css/themes/semi-dark-layout.css' }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
          href="{{ assets_a().'app-assets/css/core/menu/menu-types/vertical-menu.css' }}">

    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ assets_a().'css/mystyle.css' }}">
    <link rel="stylesheet" type="text/css" href="{{ assets_a().'css/jquery-ui.css' }}">

    <!-- END: Custom CSS-->

    <script>
        base_url = '{{ url('') }}';
        upload_file = '';
        admin_url = '{{ asset('') }}';
    </script>

    <!-- BEGIN: Vendor JS-->
    <script src="{{ assets_a().'app-assets/vendors/js/vendors.min.js' }}"></script>
    <!-- BEGIN Vendor JS-->
    <script src="{{ assets_a().'js/jquery.form.js' }}" type="text/javascript"></script>
    <script src="{{ assets_a().'js/jquery.synctranslit.min.js' }}" type="text/javascript"></script>
    <script src="{{ assets_a().'js/main.js' }}" type="text/javascript"></script>
    <script src="{{ assets_a().'js/jscolor.js' }}" type="text/javascript"></script>
    <script src="{{ assets_a().'js/slider-pro/dist/css/slider-pro.min.css' }}" type="text/javascript"></script>
    <script src="{{ assets_a().'js/jquery-ui.min.js' }}" type="text/javascript"></script>
    <script type='text/javascript' src="{{ assets_a().'fancybox/jquery.fancybox.min.js' }}"></script>

    <script src="{{ assets_a().'selectize/js/standalone/selectize.js' }}"></script>
    <link rel="stylesheet" href="{{ assets_a().'selectize/css/selectize.default.css' }}">

    <!-- Jquery Validation Engine -->
    <link href="{{ assets_a().'validation/validationEngine.css' }}" rel="stylesheet" type="text/css"/>
    <script src="{{ assets_a().'validation/languages/jquery.validationEngine-ru.js' }}" type="text/javascript"></script>
    <script src="{{ assets_a().'validation/jquery.validationEngine.js' }}" type="text/javascript"></script>
    <script src="{{ assets_a().'js/moment.min.js' }}" type="text/javascript"></script>
    <link href="{{ assets_a().'timepicker/jquery-ui-timepicker-addon.css' }}" rel="stylesheet" type="text/css"/>
    <script src="{{ assets_a().'timepicker/jquery-ui-timepicker-addon.js' }}" type="text/javascript"></script>
    <script src="{{ assets_a().'timepicker/languages/jquery-ui-timepicker-ru.js' }}" type="text/javascript"></script>
    <script>
        jQuery.browser = {};
        (function () {
            jQuery.browser.msie = false;
            jQuery.browser.version = 0;
            if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
                jQuery.browser.msie = true;
                jQuery.browser.version = RegExp.$1;
            }
        })();
    </script>

    {{--    <link href="{{ assets_a().'summernote-0.8.18-dist/summernote-lite.min.css' }}" rel="stylesheet">--}}
    {{--    <script src="{{ assets_a().'summernote-0.8.18-dist/summernote-lite.min.js' }}"></script>--}}
</head>
<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-floating footer-static  "
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

<style>
    .lang_ru:before {
        background: url('{{assets_a()}}img/lang/ru.svg') no-repeat;
        content: '';
        width: 20px;
        height: 20px;
        position: absolute;
        left: 0;
    }

    .lang_oz:before {
        background: url('{{assets_a()}}img/lang/oz.svg') no-repeat;
        content: '';
        width: 20px;
        height: 20px;
        position: absolute;
        left: 0;
    }

    .lang_uz:before {
        background: url('{{assets_a()}}img/lang/uz.svg') no-repeat;
        content: '';
        width: 20px;
        height: 20px;
        position: absolute;
        left: 0;
    }

    .lang_en:before {
        background: url('{{assets_a()}}img/lang/en.svg') no-repeat;
        content: '';
        width: 20px;
        height: 20px;
        position: absolute;
        left: 0;
    }
</style>

@php($sel = session('sel') ?? '')
@php($sel_g = session('sel_g') ?? '')

{{--            @include('layouts.navigation')--}}

<!-- Begin page -->
<!-- BEGIN: Header-->
@include('admin/partials/header')
<!-- END: Header-->

<!-- ========== Left Sidebar Start ========== -->
@include('admin/partials/sidebar')
<!-- Left Sidebar End -->

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-body">
            {{ $slot }}
        </div>
    </div>
</div>
<!-- End Page-content -->
<!-- Overlay-->
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>
<!-- end main content-->

<!-- BEGIN: Footer-->
@include('admin/partials/footer')
<!-- END: Footer-->

<script src="{{ assets_a().'app-assets/js/core/app-menu.js' }} "></script>
<script src="{{ assets_a().'app-assets/js/core/app.js' }}"></script>
<script src="{{ assets_a().'app-assets/js/scripts/components.js' }} "></script>
{{--<script src="{{ assets_a().'app-assets/js/scripts/modal/components-modal.min.js' }} "></script>--}}

@php( $route = request()->segment(3) ?? 'main')

<script>
    $('.checkbox-onoff').change(function () {
        let mode = $(this).prop('checked');
        let postid = $(this).data('postid');
        let status_ajax = $(this).data('status_ajax');
        jQuery.ajax({
            type: 'get',
            url: '{{ url_a() . $route . '/status_ajax' }}',
            data: {
                status: mode, status_ajax: status_ajax, postid: postid, "_token": "{{ csrf_token() }}"
            },
            success: function (data) {
            }
            ,
            error: function (data) {
            }
        })
        ;
        return true;
    });
</script>
@if(in_array(request()->segment(4) ?? '', array('edit', 'create')))
    @include("admin/media/index")
@else
    <script>
        $(function () {
            $("#list tbody").sortable({
                axis: 'y',
                handle: ".move",
                update: function (event, ui) {
                    let list_sortable = $(this).sortable('serialize');
                    $.ajax({
                        type: "get",
                        async: true,
                        url: '{{ url_a() . $route }}/sort_order?sort={{ Request::get('sort') ?? 'DESC' }}',
                        data: list_sortable,
                        success: function (data) {
                        },
                        error: function () {
                            alert("Ошибка");
                        }
                    });
                }
            });
            $("#list").disableSelection();
        });
    </script>
@endif

<script>
    $('.my_form').submit(function (event) {

        if ($(this).attr('id') !== 'media_form') {
            event.preventDefault(); // Предотвращаем отправку формы

            let postid = $('#post_id').val();
            let alias = $('#alias').val();
            // console.log(postid)
            jQuery.ajax({
                type: 'get',
                url: '{{ url_a() . "$route/check_alias" }}',
                data: {
                    alias: alias, postid: postid
                },
                success: function (data) {
                    // console.log(data);
                    if (data.result) {
                        $('#err_alias_block').css("display", 'block');
                        $('#err_alias').html(alias);
                        $('#alias_err_modal').modal('show');
                    } else {
                        // Если алиас уникален, отправляем форму
                        document.querySelector('.my_form').submit();
                    }
                },
                error: function (data) {
                    // Обработка ошибок AJAX запроса
                }
            });
        }
    });
</script>
<script type="text/javascript" src="<?= assets_a() ?>js/tinymce4_moxiecut/tinymce/tinymce.js"></script>

<script>
    var moxiecutUrl = '{{ url('api/admin/moxiecut') }}';
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    tinymce.PluginManager.load('moxiecut', '<?= assets_a() ?>js/tinymce4_moxiecut/tinymce/plugins/moxiecut/plugin.min.js');
    tinymce.init({
        selector: ".moxiecut",
        language: 'ru',
        theme: "modern",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste moxiecut",
            "textcolor colorpicker"
        ],
        toolbar: "undo redo | styleselect | bold italic fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link insertfile image media | forecolor backcolor",
        autosave_ask_before_unload: false,
        height: 500,
        relative_urls: false,
        valid_elements: "*[*]",
        entity_encoding: 'raw',
    });
    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    this._initRequest();
                    this._initListeners(resolve, reject, file);
                    this._sendRequest(file);
                }));
        }

        _initRequest() {
            const xhr = this.xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ url('upload') }}', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.responseType = 'json';
        }

        _initListeners(resolve, reject, file) {
            const xhr = this.xhr;
            const loader = this.loader;
            const genericErrorText = `Couldn't upload file: ${file.name}.`;

            xhr.addEventListener('error', () => reject(genericErrorText));
            xhr.addEventListener('abort', () => reject());
            xhr.addEventListener('load', () => {
                const response = xhr.response;

                if (!response || response.error) {
                    return reject(response && response.error ? response.error.message : genericErrorText);
                }

                resolve({
                    default: response.url
                });
            });

            if (xhr.upload) {
                xhr.upload.addEventListener('progress', evt => {
                    if (evt.lengthComputable) {
                        loader.uploadTotal = evt.total;
                        loader.uploaded = evt.loaded;
                    }
                });
            }
        }

        _sendRequest(file) {
            const data = new FormData();
            data.append('upload', file);

            this.xhr.send(data);
        }
    }

    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new MyUploadAdapter(loader);
        };
    }

    document.querySelectorAll('#editor').forEach(editorElement => {
        ClassicEditor
            .create(editorElement, {
                extraPlugins: [MyCustomUploadAdapterPlugin],
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>
@if(  session('message') or  session('success') or  session('error_success') or session('erro_subtime') or session('error') )
    <div class="modal fade" id="messages_s" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Сообщение</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ session('message') }}
                    {{ session('success') }}
                    <p> {{ session('error_success') }} {{ session('erro_subtime') }} </p>
                    {{ error_get_last()}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#messages_s').modal('show')
    </script>
@endif

<script>
    $(document).ready(function () {
        // Обработчик события при клике на строку таблицы
        $('#list').on('click', '.click', function () {
            // Получаем URL из атрибута data-url и Перенаправляем пользователя на новый URL
            window.location.href = $(this).data('url');
        });
    });
</script>

<div class="modal fade" id="alias_err_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Сообщение</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="display: none" id="err_alias_block">
                    <p>
                        {{a_lang('err_alias')}}
                        <span style="color: red" id="err_alias"></span>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    // $('.summernote').summernote({
    //     tabsize: 5,
    //     height: 350
    // });
</script>
</html>
