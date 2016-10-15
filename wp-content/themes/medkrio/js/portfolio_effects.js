	var $j = jQuery.noConflict();
			$j(function(){
				
				$j('.magnifier').mosaic({
					opacity		:	0.8			//Opacity for overlay (0-1)
				});

				$j('.magnifier2').mosaic({
					opacity		:	0.8			//Opacity for overlay (0-1)
				});
				
				$j('.fade').mosaic();
				
				$j('.bar').mosaic({
					animation	:	'slide'		//fade or slide
				});
				
				$j('.bar2').mosaic({
					animation	:	'slide'		//fade or slide
				});
				
				$j('.bar3').mosaic({
					animation	:	'slide',	//fade or slide
					anchor_y	:	'top'		//Vertical anchor position
				});
				
				$j('.cover').mosaic({
					animation	:	'slide',	//fade or slide
					hover_x		:	'428px'		//Horizontal position on hover
				});
				
				$j('.cover2').mosaic({
					animation	:	'slide',	//fade or slide
					anchor_y	:	'top',		//Vertical anchor position
					hover_y		:	'120px'		//Vertical position on hover
				});
				
				$j('.cover3').mosaic({
					animation	:	'slide',	//fade or slide
					hover_x		:	'400px',	//Horizontal position on hover
					hover_y		:	'300px'		//Vertical position on hover
				});
		    
		    });