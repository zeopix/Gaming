function resize(){
		var window_height = $(window).height();
		var window_width = $(window).width();
		var correction = 0.75;
		
		if(window_height >= window_width){
			var block_arest = window_width/10;
			var margin = (window_height - window_width)*correction/2;
			var type = "top";
		}else{
			var block_arest = window_height/10;
			var margin = (window_width - window_height)*correction/2;
			var type = "left";

		}
		$(".block").css("height",(block_arest*correction-3));
		$(".block").css("width",(block_arest*correction-3));
		$(".block").css("margin",block_arest/8);
		$(".tablero").css("margin-"+type,margin);
	
	}
	$(function(){
		resize();
		$(window).resize(function(){
			resize();
		});	
	})