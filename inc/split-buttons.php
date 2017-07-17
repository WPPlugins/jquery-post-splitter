<?php


	function spnp_init() {
		
		
		
		global $pagenow;
			
		load_plugin_textdomain('jquery-post-splitter', false, 'jquery-post-splitter/languages');
		
		if (in_array($pagenow,array('page.php', 'page-new.php', 'post.php', 'post-new.php'))) { 
			if (current_user_can('edit_posts') && current_user_can('edit_pages') && get_user_option('rich_editing') == 'true') {
				add_filter('mce_external_plugins', 'spnp_add_tinymce_plugin');
				add_filter('mce_buttons', 'spnp_register_button');
			}
			add_action('admin_print_footer_scripts', 'spnp_quicktag_js', 99);
		}
	}
	add_action('admin_init', 'spnp_init');



	function spnp_register_button($buttons) {
		array_push($buttons, '|', "jpsPPBtnBtn");
		return $buttons;
	}
	function spnp_add_tinymce_plugin($plugin_array) {
		$plugin_array['spnpnextpage'] = trailingslashit(get_bloginfo('wpurl')).'index.php?spnp-action=spnp-admin-js';
		return $plugin_array;
	}

	function spnp_quicktag_js() {
		global $pagenow;

		echo '
<script type="text/javascript">
	jQuery(function($) {
		QTags.addButton("ed_next", "page", "<!--nextpart-->","","p");

		$("<input />")
			.attr("type", "button")
			.attr("id","ed_next")
			.attr("value","' . __('next page', 'jquery-post-splitter') . '")
			.attr("accesskey","p")
			.attr("title","' . __('Insert Next Page Tag', 'jquery-post-splitter') . '")
			.addClass("ed_button button-small button")
			.click(function(e){
				e.preventDefault();
				edInsertTag(edCanvas, $(this).attr("name"));
			})
			.appendTo($("#ed_toolbar"));
	});
</script>
		';
	}