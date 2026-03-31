$(document).ready(function(){

	$('.delete').click(function(){
		if (!confirm("Вы уверены ?")) {
	        return false;
	    }
	});

	$('.back').click(function(){
		history.back();
	});

	$('tr.edit').click(function(){
		location.href = $(this).attr('url');
	});

	$(".fancybox").fancybox();

	$(".datepicker").datepicker({
		dateFormat: 'yy-mm-dd'
	});

	$(document).on('click', '.ajax_delete', function(){
		if (!confirm("Вы уверены ?")) {
	        return false;
	    }
	    else {
	    	var data = $(this);

	    	$.post( data.attr('href'),
	    		function (response)
	    		{
	    			if (response == 'deleted')
	    			{
	    				data.closest('li').remove();
	    			}
	    		}
    		);
    		return false;
	    }
	});

	$(document).on('click', '.ajax_set_main', function(){
		var data = $(this);

		$.post( data.attr('href'),
    		function (response)
    		{
    			if (response == 'set_main')
    			{
    				$('.media-block .btn-info').removeClass('btn-info');
    				data.addClass('btn-info');
    			}
    		}
		);
		return false;
	});

  $(document).on('click', '.ajax_set_main1', function(){
		var data = $(this);

		$.post( data.attr('href'),
    		function (response)
    		{
    			if (response == 'set_main')
    			{
    				$('.btn-info1').removeClass('btn-info1');
    				data.addClass('btn-info1');
    			}
    		}
		);
		return false;
	});

 /* $(document).on('click', '.lang_ru', function(){
		var data = $(this);

		$.post( data.attr('href'),
    		function (response)
    		{
    			if (response == 'lang_ru')
    			{
    				$('.btn-info').removeClass('btn-info');
    				data.addClass('btn-info');
    			}
    		}
		);
		return false;
	});

  $(document).on('click', '.lang_oz', function(){
		var data = $(this);

		$.post( data.attr('href'),
    		function (response)
    		{
    			if (response == 'lang_oz')
    			{
    				$('.btn-info').removeClass('btn-info');
    				data.addClass('btn-info');
    			}
    		}
		);
		return false;
	});*/

	$('#title').syncTranslit({destination: 'alias'});
    $('.titles').syncTranslit({destination: 'alias'});
  $('#title1').syncTranslit({destination: 'alias1'});
  $('#title2').syncTranslit({destination: 'alias2'});
  $('#title3').syncTranslit({destination: 'alias3'});
  $('#title4').syncTranslit({destination: 'alias4'});
  $('#title5').syncTranslit({destination: 'alias5'});
});

function openForm(url)
{
	$.ajax({
		type: "POST",
		url: url,
		success: function(content)
		{
            $.fancybox({
                content: content,
            });
		}
	});
}
