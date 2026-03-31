 function validate(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
   // console.log(key);
    key = String.fromCharCode( key );
    var regex = /[0-9\+\()]|\./;
    if( !regex.test(key)) {
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
    }
  }
 
   $("a.btn-adaptive").click(function() {
        var a = $(this).attr("href");
        OpenWindow(a, 352, 568, "media");
        return false
    });
 
function OpenWindow(b, d, a, c) {
    if (!c) {
        c = window
    }
    if (!d) {
        d = 800
    }
    if (!a) {
        a = 600
    }
    var f = (screen.width - d) / 2;
    var e = window.open(b, c, "left=" + f + ",top=100,width=" + d + ",height=" + a + ",directories=no,menubar=no,status=yes,resizable=yes,scrollbars=yes,toolbar=no");
    if (e.opener == null) {
        e.opener = self
    }
    e.focus()
}


// SEARCH BAR STARTS HERE

  
  var search_timer = false;
$(document).ready(function() {
        $(document).on('click', '.search-toggle', function(e) {
            e.stopPropagation();
            var parent = $(this).parent();
            $('body').addClass('thim-search-active');
            setTimeout(function() {
                parent.find('.thim-s').focus();
            }, 500);
        });
        $(document).on('click', '.search-popup-bg', function() {
            var parent = $(this).parent();
            window.clearTimeout(search_timer);
            parent.find('.courses-list-search').empty();
            parent.find('.thim-s').val('');
            $('body').removeClass('thim-search-active');
        });
        $(document).on('keyup', '.courses-search-input', function(event) {
            clearTimeout($.data(this, 'search_timer'));
            var contain = $(this).parents('.courses-searching'),
                list_search = contain.find('.courses-list-search'),
                item_search = list_search.find('>li');
            /*if (event.which == 13) {
                event.preventDefault();
               // $(this).stop();
            } else*/ if (event.which == 38) {
                if (navigator.userAgent.indexOf('Chrome') != -1 && parseFloat(navigator.userAgent.substring(navigator.userAgent.indexOf('Chrome') + 7).split(' ')[0]) >= 15) {
                    var selected = item_search.filter(".ob-selected");
                    if (item_search.length > 1) {
                        item_search.removeClass("ob-selected");
                        if (selected.prev().length == 0) {
                            selected.siblings().last().addClass("ob-selected");
                        } else {
                            selected.prev().addClass("ob-selected");
                        }
                    }
                }
            } else if (event.which == 40) {
                if (navigator.userAgent.indexOf('Chrome') != -1 && parseFloat(navigator.userAgent.substring(navigator.userAgent.indexOf('Chrome') + 7).split(' ')[0]) >= 15) {
                    var selected = item_search.filter(".ob-selected");
                    if (item_search.length > 1) {
                        item_search.removeClass("ob-selected");
                        if (selected.next().length == 0) {
                            selected.siblings().first().addClass("ob-selected");
                        } else {
                            selected.next().addClass("ob-selected");
                        }
                    }
                }
            } else if (event.which == 27) {
                if ($('body').hasClass('thim-search-active')) {
                    $('body').removeClass('thim-search-active');
                }
                list_search.html('');
                $(this).val('');
                $(this).stop();
            } else {
                var search_timer = setTimeout(function() {
                    thimlivesearch(contain);
                }, 500);
                $(this).data('search_timer', search_timer);
            }
        });
        $(document).on('keypress', '.courses-search-input', function(event) {
            var item_search = $(this).parents('.courses-searching').find('.courses-list-search>li');
            /*if (event.keyCode == 13) {
                var selected = $(".ob-selected");
                if (selected.length > 0) {
                    var ob_href = selected.find('a').first().attr('href');
                    window.location.href = ob_href;
                }
                event.preventDefault();
            }*/
            if (event.keyCode == 27) {
                if ($('body').hasClass('thim-search-active')) {
                    $('body').removeClass('thim-search-active');
                }
                $('.courses-list-search').html('');
                $(this).val('');
                $(this).stop();
            }
            if (event.keyCode == 38) {
                var selected = item_search.filter(".ob-selected");
                if (item_search.length > 1) {
                    item_search.removeClass("ob-selected");
                    if (selected.prev().length == 0) {
                        selected.siblings().last().addClass("ob-selected");
                    } else {
                        selected.prev().addClass("ob-selected");
                    }
                }
            }
            if (event.keyCode == 40) {
                var selected = item_search.filter(".ob-selected");
                if (item_search.length > 1) {
                    item_search.removeClass("ob-selected");
                    if (selected.next().length == 0) {
                        selected.siblings().first().addClass("ob-selected");
                    } else {
                        selected.next().addClass("ob-selected");
                    }
                }
            }
        });
        $(document).on('click', '.courses-list-search, .courses-search-input', function(event) {
            event.stopPropagation();
        });
        $(document).on('click', 'body', function() {
            if (!$('body').hasClass('course-scroll-remove')) {
                $('body').addClass('course-scroll-remove');
            }
        });
        $(window).scroll(function() {
            if ($('body').hasClass('course-scroll-remove') && $(".courses-list-search li").length > 0) {
                $(".courses-searching .courses-list-search").empty();
                $(".courses-searching .thim-s").val('');
            }
        });
        $(document).on('focus', '.courses-search-input', function() {
            if ($('body').hasClass('course-scroll-remove')) {
                $('body').removeClass('course-scroll-remove');
            }
        });
    
      
  
    
    });


// SEARCH BAR ENDSD HERE