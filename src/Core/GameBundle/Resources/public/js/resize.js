function resize(){
		var fitice_height = $(window).height();
		var fitice_width = $(window).width();
		//firefox
		//webkit
		var correction = 0.91;
		if($.browser.mozilla){
			 correction = 0.86;
		
		}
		var correction_height = 1.04;
		var divisions = 8;
		var offset = 50;
		
		var window_width = fitice_width;
		var window_height = fitice_height-offset;
		
		if(window_height >= window_width){
			var block_arest = window_width/(divisions+1);
			var margin = (window_height - window_width)/2;
			var type = "top";
			var other="left";
		}else{
			window_height = window_height - 40;
			var block_arest = window_height/(divisions+1);
			block_arest = block_arest*correction_height;
			var margin = (window_width - window_height)/2;
			var type = "left";
			var other = "top";

		}
		
		//$("#gamepanel").css("height",window_height+"px")
		
		$(".block").css("height",(block_arest*correction)+"px");
		$(".block").css("width",(block_arest*correction)+"px");
		$(".block").css("margin",block_arest*correction/(divisions+1)+"px");
		
		$(".tablero").css("margin-"+type,margin*correction*0.9+"px");
		$(".tablero").css("margin-"+other,"5px");
//		$(".tablero").css("width",((block_arest*(divisions*0.91)))+"px");
	
	}
	$(function(){
		resize();
		$(window).resize(function(){
			resize();
		});	
	})