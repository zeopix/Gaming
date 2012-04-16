function resize(){
		var window_height = $(window).height();
		var window_width = $(window).width();
		var correction = 0.68;
		
		if(window_height >= window_width){
			var block_arest = window_width/14;
			var margin = (window_height - window_width)*correction/2;
			var type = "top";
			var correction= 0.50;
		}else{
			var divisions = 8;
			var block_arest = window_height/divisions;
			var margin = (window_width - window_height)*correction/2;
			var type = "left";

		}
		$(".block").css("height",(block_arest*correction-3));
		$(".block").css("width",(block_arest*correction-3));
		$(".block").css("margin",block_arest/8);
		$(".tablero").css("margin-"+type,margin*1);
		$(".tablero").css("width",((block_arest*(divisions*0.91)))+"px");
		$(".tablero").css("margin-top",margin*0.1);
	
	}
	$(function(){
		resize();
		$(window).resize(function(){
			resize();
		});	
	})