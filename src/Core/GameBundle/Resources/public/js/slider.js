function resizeSlider(){
	var window_width = $(window).width();
	var length = $("ul#slider > li").length;
	$("ul#slider li").css("width",(window_width*0.8)+'px');
	$("ul#slider").css("width",(window_width*0.8*length)+'px');
	$("ul#slider").attr("margin",window_width*0.8);
	console.log(window_width)
}
$(function(){
	resizeSlider();
	$(window).resize(function(){
		resizeSlider();
	})
	
})