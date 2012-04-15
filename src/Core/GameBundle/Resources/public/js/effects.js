
		//Block click effect
		$(".block").click(function(){ 
			$(this).addClass("active");
			setTimeout(function(){ $(".block.active").removeClass('active'); },200);
		})