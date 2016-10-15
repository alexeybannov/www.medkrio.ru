/*********************
//* jQuery Multi Level CSS Menu #2- By Dynamic Drive: http://www.dynamicdrive.com/
//* Last update: Nov 7th, 08': Limit # of queued animations to minmize animation stuttering
//* Menu avaiable at DD CSS Library: http://www.dynamicdrive.com/style/
*********************/

//Update: April 12th, 10: Fixed compat issue with jquery 1.4x

//Specify full URL to down and right arrow images (23 is padding-right to add to top level LIs with drop downs):
var arrowimages={down:['', ''], right:['', '']};

var jqueryslidemenu={

buildmenu:function(menuid, arrowsvar){
	var $j = jQuery.noConflict();

$j(function(){
		var $jmainmenu=$j("#"+menuid+">ul");
		var $jheaders=$jmainmenu.find("ul").parent();
		$jheaders.each(function(i){
			var $jcurobj=$j(this);
			var $jsubul=$j(this).find('ul:eq(0)');
			this._dimensions={w:this.offsetWidth, h:this.offsetHeight, subulw:$jsubul.outerWidth(), subulh:$jsubul.outerHeight()};
			this.istopheader=$jcurobj.parents("ul").length==1? true : false
			$jsubul.css({top:this.istopheader? this._dimensions.h+"px" : 0});
		
			$jcurobj.hover(
				function(e){
					var $jtargetul=$j(this).children("ul:eq(0)");	
					this._offsets={left:$j(this).offset().left, top:$j(this).offset().top};
					var menuleft=this.istopheader? 0 : this._dimensions.w;
					menuleft=(this._offsets.left+menuleft+this._dimensions.subulw>$j(window).width())? (this.istopheader? -this._dimensions.subulw+this._dimensions.w : -this._dimensions.w) : menuleft;
					if ($jtargetul.queue().length<=1) //if 1 or less queued animations
						$jtargetul.css({left:menuleft+"px", width:this._dimensions.subulw+'px'}).slideDown(400);
				},
				function(e){
					var $jtargetul=$j(this).children("ul:eq(0)");
					$jtargetul.slideUp(0);
				}
			); //end hover
			$jcurobj.click(function(){
				$j(this).children("ul:eq(0)").hide();
			});
		}); //end $jheaders.each()
		$jmainmenu.find("ul").css({display:'none', visibility:'visible'});
	}) //end document.ready
}
};

//build menu with ID="main_menu" on page:
jqueryslidemenu.buildmenu("main_menu");