function str_pad (str, max) {
  str = str.toString();
  return str.length < max ? str_pad("0" + str, max) : str;
}


$(document).ready(function(){
	$('body').on('show.bs.modal', '#modal', function() {
		//$(this).removeClass('modal-open')
	})
	.on('hidden.bs.modal', '#modal', function () {
		$(this).removeClass('modal-open')
		$(this).removeData('bs.modal');
		$(this).find('.modal-content').html('<div class="loader bubble-loader"><div class="1"></div><div class="2"></div><div class="3"></div><div class="4"></div><div class="5"></div></div>');
	});

    $('#nav').perfectScrollbar();
    $("#nav > .nav").metisMenu();

    $('[data-toggle="tooltip"]').tooltip()

    $(window).resize(function() {
        $('#welcome-banner').height(function() {
        	var height = $(window).height() - $('#welcome-banner').offset().top
        		outerHeight = $('#welcome-banner .container').outerHeight();
        	
        	if( height < outerHeight ) {
        		return outerHeight;
        	}

        	return height;
        });
    });
    $(window).resize();
	
	$('.selectpicker').selectpicker();

    $('body').on('click', '.modal-get', function(event) {
        event.preventDefault();
        $(this).parents('.modal-content').load( $(this).attr('href'));
    });
});
