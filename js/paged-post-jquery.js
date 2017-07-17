jQuery(document).ready(function($){



	if($('.jps-wrap-content').length>0){



	

	$('body.page .jps-wrap-content a[class^="next_to"], body.single .jps-wrap-content a[class^="next_to"]').click(function(){
		var nthis = $(this).attr('data-this');
		var rep = 'post-part-';
		var expected_object = $('#'+rep+''+nthis);
		//console.log(expected_object);
		if(expected_object.length>0 && !$(expected_object).is(':visible')){



			$('.jps-wrap-content, .jps-fullpost-link').hide();

			$(expected_object).fadeIn();
			
			jps.move_to_post();
			
		}
		
	});

	$('body.page .jps-wrap-content .jps-next, body.single .jps-wrap-content .jps-next, .jps-wrap-content a[class^="the_next"]').click(function(){



		var rep = 'post-part-';



		var current_div = $('.jps-parent-div:visible');



		var current_page = current_div.attr('id').replace(rep, '');



		var next_page = parseInt(current_page)+1;



		var expected_object = $('#'+rep+''+next_page);



		if(expected_object.length>0){



			$('.jps-wrap-content, .jps-fullpost-link').hide();

			$(expected_object).fadeIn();

			

			if($('.jps-fullpost-link').length>0)

			$(expected_object).next().show();



		}else{

			$('.jps-wrap-content, .jps-fullpost-link').hide();

			$('.jps-wrap-content').eq(0).fadeIn();

			

			if($('.jps-fullpost-link').length>0)

			$('.jps-wrap-content').eq(0).next().show();



		}







		jps.move_to_post();



	});



	$('body.page .jps-wrap-content .jps-prev, body.single .jps-wrap-content .jps-prev').click(function(){



		var rep = 'post-part-';



		var current_div = $('.jps-parent-div:visible');



		var current_page = current_div.attr('id').replace(rep, '');



		var prev_page = parseInt(current_page)-1;



		var expected_object = $('#'+rep+''+prev_page);

		

		if(expected_object.length>0){



			$('.jps-wrap-content, .jps-fullpost-link').hide();



			$(expected_object).fadeIn();

			

			if($('.jps-fullpost-link').length>0)

			$(expected_object).next().show();



		}else{

			$('.jps-wrap-content, .jps-fullpost-link').hide();

			$('.jps-wrap-content').eq(($('.jps-wrap-content').length-1)).fadeIn();

			

			if($('.jps-fullpost-link').length>0)

			$('.jps-wrap-content').eq(($('.jps-wrap-content').length-1)).next().show();

		}



		jps.move_to_post();



	});	



	



	$('body.page .jps-wrap-content, body.single .jps-wrap-content').eq(0).fadeIn();



	



	$('body.page .jps-wrap-content .jps-slider-nav a, body.single .jps-wrap-content .jps-slider-nav a').removeAttr('href');



	



	}



});







var jps = {



	'move_to_post': function(){

		if (jpps_options_object.scroll_up) {

			jQuery('html, body').animate({
	
	
	
							scrollTop: jQuery('.jps-wrap-content:visible').offset().top-160
	
	
	
						}, 2000);

		}

	}



};