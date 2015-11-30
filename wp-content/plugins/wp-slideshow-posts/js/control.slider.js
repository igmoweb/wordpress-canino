(function($) {
    $('#slideshow_1').cycle({
        fx: 'fade',		
		easing: 'easeInOutCirc',
		pause:   1,
		speed: 700,
		timeout: slider_params.time, 
		pager: '.ss1_wrapper .slideshow_paging',
        prev: '.ss1_wrapper .slideshow_prev',
        next: '.ss1_wrapper .slideshow_next',
		before: function(currSlideElement, nextSlideElement) {
			var data = $('.data', $(nextSlideElement)).html();
			$('.ss1_wrapper .slideshow_box .data').fadeOut(300, function(){
				$('.ss1_wrapper .slideshow_box .data').remove();
				$('<div class="data"><div class="color-transparent"></div>'+data+'</div>').hide().appendTo('.ss1_wrapper .slideshow_box').fadeIn(600);
			});
		}
    });
	
	// not using the 'pause' option. instead make the slideshow pause when the mouse is over the whole wrapper
	$('.ss1_wrapper').mouseenter(function(){
		$('#slideshow_1').cycle('pause');
    }).mouseleave(function(){
		$('#slideshow_1').cycle('resume');
    });
	
	$('a[href="#"]').click(function(event){ 
		event.preventDefault(); // for this demo disable all links that point to "#"
	});

})(jQuery);


