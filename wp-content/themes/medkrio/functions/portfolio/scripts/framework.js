var $j = jQuery.noConflict();

$j(function(){
	$j('ul#filter a').click(function() {
		$j(this).css('outline','none');
		$j('ul#filter .current').removeClass('current');
		$j(this).parent().addClass('current');
		
		var filterVal = $j(this).text().toLowerCase().replace(' ','-');
				
		if(filterVal == 'all') {
			$j('ul.portfolio-one li.hidden, ul.portfolio-two li.hidden, ul.portfolio-three li.hidden, ul.portfolio-four li.hidden').fadeIn(800).removeClass('hidden');
		} else {
			
			$j('ul.portfolio-one li, ul.portfolio-two li, ul.portfolio-three li, ul.portfolio-four li').each(function() {
				if(!$j(this).hasClass(filterVal)) {
					$j(this).fadeOut(800).addClass('hidden');
				} else {
					$j(this).fadeIn(800).removeClass('hidden');
				}
			});
		}
		
		return false;
	});
});