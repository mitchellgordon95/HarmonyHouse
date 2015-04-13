(function($){

	$(document).ready(function(){
 
	/*$(window).resize(
		function(){
			$('.g_map').width($(window).width());
			$('.g_map').css({width: $(window).width(), "margin-left": ($(window).width()/-2)});
		}
	).trigger('resize');*/

	$('.nav__primary>ul>li>a').each(function(){
	        var $this = $(this),
	            txt = $this.text();
		        $this.html('<div><span>'+ txt +'</span></div><div><span>'+ txt +'</span></div>');
		});

	

	$('.block_1>.recent-posts>li')
        .on('mouseover',function(e){
            $(this).find('.btn-primary').addClass('act_1');
        })
        .on('mouseout', function(e) {
            $(this).find('.btn-primary').removeClass('act_1');    
    });

   /* $('.banner_list>li>.thumbnail>a').each(function(){
		        $(this).append('<span class="zoom-icon"></span>'); 
		});*/

  

    $('.block_2>li')
        .on('mouseover',function(e){
            $(this).find('.btn-primary').addClass('act_1');
        })
        .on('mouseout', function(e) {
            $(this).find('.btn-primary').removeClass('act_1');    
    });

    $(window).resize(
	   function(){
	    $('.banner_list').width($(window).width());
	    $('.banner_list').css({width: $(window).width(), "margin-left": ($(window).width()/-2)});
	    $('.banner_list>li>.featured-thumbnail>a img').css({width: $(window).width()/2, "max-width": ($(window).width()/2)});
	   }
	  ).trigger('resize');



    $('.banner_list li>.thumbnail>a').each(function(){
		  $(this).append('<div class="hover_part"></div>');
	});





	});

 
})(jQuery);

$(document).ready(function(){
		jQuery(".banner_list li:even").addClass("extra");
	});