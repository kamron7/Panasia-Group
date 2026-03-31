<div class="tab-content" id="ajax">
    <div id="catalog-menu" class="dd">
        {!! $menu_admin !!}
    </div>
</div>
<style>
    .menu-head {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #catalog-menu .onoffswitch {
        width: 65px !important;
    }

    #catalog-menu .action .btn-group {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #catalog-menu .btn-group .btn-info {
        margin-left: 10px;
        padding: 0 24px;
        height: 60%;
        border-radius: 10%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #catalog-menu .btn-group .btn-danger {
        width: 34%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 10px;
        height: 60%;
        border-radius: 10%;
    }
</style>
<script>
    $(document).ready(function () {
        $('#catalog-menu li.has-sub>a').on('click', function () {
            $(this).removeAttr('href');
            let element = $(this).parent('li');
            if (element.hasClass('open')) {
                element.removeClass('openLink');
                element.removeClass('open');
                element.find('li').removeClass('open');
                element.find('li').removeClass('openLink');
                element.find('ul').slideUp();
            } else {
                element.addClass('open');
                element.addClass('openLink');
                element.children('ul').slideDown();
                element.siblings('li').children('ul').slideUp();
                element.siblings('li').removeClass('openLink');
                element.siblings('li').removeClass('open');
                element.siblings('li').find('li').removeClass('openLink');
                element.siblings('li').find('li').removeClass('open');
                element.siblings('li').find('ul').slideUp();
            }
        });

        $(".list_move").sortable({
            handle: "button",
            cancel: '',
            delay: 100,
            containment: '.list_move',
            revert: 'true',
            update: function (event, ui) {
                let list_sortable = $(this).sortable('serialize');
                console.log(list_sortable)
                $.ajax({
                    type: "GET",
                    async: true,
                    url: '{{ url_a() }}menu/sort_order?sort=asc',
                    data: list_sortable,
                    success: function (data) {
                        console.log(data)
                    },
                    error: function () {
                        alert("Ошибка");
                    }
                });
            }
        }).disableSelection();
        $('[data-toggle="tooltip"]').tooltip();

        $('.sort-order_input').on('focus', function () {
            let sort_id = $(this).data('order_enter');
            $('#sort-order_enter-' + sort_id).css('display', 'block');
        });
        $('.sort-order_enter').css('display', 'none');
    });

</script>
