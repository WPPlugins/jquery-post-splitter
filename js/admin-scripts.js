// JavaScript Document
jQuery(document).ready(function($){
	
	$('.mce-ico.mce-i-jpsPPBtnBtn').on('click', function(){
		
	});
	
	if($('select[name="jps_options[nav_style]"]').length>0){
		$('select[name="jps_options[nav_style]"]').on('change keyup', function(){
			var obj = $(this);
			var jps_preview_url = jps_url+obj.val().replace('jps_', '')+'.png';
			$('.jps_preview img').attr('src', jps_preview_url).show();
		});
		
		
		$('select[name="jps_options[nav_style]"]').trigger('change');
		$('.jps_settings_table .jps_preview').show();
	}
	
	$('.jps_styles_preview').on('click', function(){
		
		$(this).toggleClass( "small" );
	});	
	
});