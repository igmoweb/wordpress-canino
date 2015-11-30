jQuery(document).ready(function($) {

$('.vkrpsl-slider').css('width', vkrpsl_object.slider_width);
var sliderWidth = $('.vkrpsl-slider').width();
var wrapWidth = sliderWidth + 70;
$('.slider-wrap').css('width', wrapWidth);
if ( vkrpsl_object.nav_arrows == 'yes' ) {
	$('.sa-left').hide();
	$('.sa-right').hide();
}
var auto;
if ( vkrpsl_object.autoplay == 'false') {
	auto = false;
} else if ( vkrpsl_object.autoplay == 'true' ) {
	auto = true;
} 
var v = parseInt(vkrpsl_object.visible);
$('.vkrpsl-slider').lbSlider({
    leftBtn: '.sa-left',
    rightBtn: '.sa-right',
    visible: v,
    autoPlay: auto,
    autoPlayDelay: vkrpsl_object.autoplay_speed
});
}); 
