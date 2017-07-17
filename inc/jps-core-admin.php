<?php


function jps_theme_add_editor_styles() {
    add_editor_style( plugins_url( 'css/jps-admin.css' , dirname(__FILE__)) );
}
add_action( 'admin_init', 'jps_theme_add_editor_styles' );

function jps_add_meta_box() {



	global $jps_title;

	

	$screens = array( 'post' );



	foreach ( $screens as $screen ) {



		add_meta_box(

			'jps_metabox_id',

			__( $jps_title, 'jps_metabox' ),

			'jps_metabox_callback',

			$screen

		);

	}

}

add_action( 'add_meta_boxes', 'jps_add_meta_box', 1 );





function jps_metabox_callback( $post ) {

	

	global $jps_premium;

	

	// Add a nonce field so we can check for it later.

	wp_nonce_field( 'jps_save_meta_box_data', 'jps_meta_box_nonce' );



	/*

	 * Use get_post_meta() to retrieve an existing value

	 * from the database and use the value for the form.

	 */

	$value = get_post_meta( $post->ID, 'jps_nav_type', true );



	$opt_name = 'jps_nav_type_'.$post->ID;





	echo '<p>You can select a different navigation type for each post. This setting will override the default <a href="options-general.php?page=jpsoptions">settings</a>.</p>';



	jps_nav_method($value, $opt_name);

	

	jps_go_premium();

	

}







//Add Settings Link To Plugins Page



function jpps_plugin_meta($links, $file) {



	$plugin = plugin_basename(__FILE__);



	// create link



	if ($file == $plugin) {



		return array_merge(



			$links,



			array( sprintf( '<a href="options-general.php?page=jpsoptions">Settings</a>', $plugin, __('Settings') ) )



		);



	}



	return $links;



}











function jpps_add_options() {



	global $jps_title;



	add_options_page($jps_title.' Settings', $jps_title, 'manage_options', 'jpsoptions', 'jpps_options_page');



}







function jpps_options_page() {



	



	global $jps_title, $jps_premium_link, $jps_premium;

	$hidden_field_name = 'jpps_submit_hidden';


	if(isset($_POST[$hidden_field_name ]) && $_POST[$hidden_field_name ] == 'Y' ) {



		update_option('jps_options', $_POST['jps_options']);


	}







	//Options Form

	include('jps-settings.php');

	?>













<?php }



	function jps_go_premium(){

		global $jps_premium, $jps_premium_link, $jps_styles;



		if(!$jps_premium): ?>



   <a href="<?php echo $jps_premium_link; ?>" target="_blank" class="jps_premium_link">Go Premium</a>
	<?php if(!empty($jps_styles)){ ?>
	<ul title="Click here to preview" class="jps_styles_preview small">
    <?php foreach($jps_styles as $style){ ?>
    <li><strong><?php echo ucwords(str_replace('_', ' ', $style)); ?></strong><img alt="<?php echo $style; ?>" src="<?php echo plugins_url( 'images/'.$style.'.png', dirname(__FILE__) ); ?>" />
</li>
    <?php } ?>
    </ul>
    <?php } ?>


   <?php endif; 

   

	}



	function jps_nav_method($opt_val='', $opt_name='nav_implementation'){
		global $jps_premium;
		$opt_val = ($opt_val!=''?$opt_val:jps_get($opt_name));

?>

<select name="jps_options[<?php echo $opt_name; ?>]">



<option value="" <?php echo ($opt_val == "") ? 'selected="selected"' : ''; ?> >Select</option>





                            <option value="jQuery" <?php echo ($opt_val == "jQuery") ? 'selected="selected"' : ''; ?> >jQuery</option>



                            



                            <option <?php echo $jps_premium?'':'disabled="disabled"'; ?> value="Ajax" <?php echo ($opt_val == "Ajax") ? 'selected="selected"' : ''; ?> >Ajax<?php echo $jps_premium?'':' (Premium)'; ?></option>



                            <option <?php echo $jps_premium?'':'disabled="disabled"'; ?> value="Page Refresh" <?php echo ($opt_val == "Page Refresh") ? 'selected="selected"' : ''; ?> >Page Refresh<?php echo $jps_premium?'':' (Premium)'; ?></option>



							</select>

<?php		

	}





function paged_post_tinymce($mce_buttons) {



	$pos = array_search('wp_more', $mce_buttons, true);



	if ($pos !== false) {



		$buttons = array_slice($mce_buttons, 0, $pos + 1);







		$buttons[] = 'wp_page';







		$mce_buttons = array_merge($buttons, array_slice($mce_buttons, $pos + 1));



	}



	return $mce_buttons;



}







function jps_plugin_links($links) { 



		global $jps_premium_link, $jps_premium;



		



		$settings_link = '<a href="options-general.php?page=jpsoptions">Settings</a>';



		



		if($jps_premium){



			array_unshift($links, $settings_link); 



		}else{



			$jps_premium_link = '<a href="'.$jps_premium_link.'" title="Go Premium" target=_blank>Go Premium</a>'; 



			array_unshift($links, $settings_link, $jps_premium_link); 



		



		}



		



		



		return $links; 



}







function jps_admin_scripts(){



	wp_enqueue_style('paged-post-style',plugins_url( 'css/jps-admin.css' , dirname(__FILE__)));

	wp_enqueue_script('jps-admin-scripts', plugins_url( 'js/admin-scripts.js', dirname(__FILE__)), array('jquery', 'jquery-ui-core'), '', true);

}



	

	

	function jps_save_meta_box_data( $post_id ) {

	

		/*

		 * We need to verify this came from our screen and with proper authorization,

		 * because the save_post action can be triggered at other times.

		 */

	

		// Check if our nonce is set.

		if ( ! isset( $_POST['jps_meta_box_nonce'] ) ) {

			return;

		}

	

		// Verify that the nonce is valid.

		if ( ! wp_verify_nonce( $_POST['jps_meta_box_nonce'], 'jps_save_meta_box_data' ) ) {

			return;

		}

	

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

			return;

		}

	







		if ( ! current_user_can( 'edit_post', $post_id ) ) {

			return;

		}

		

		/* OK, it's safe for us to save the data now. */

		

		// Make sure that it is set.

		if ( ! isset( $_POST['jps_nav_type_'.$post_id] ) ) {

			return;

		}

	

		// Sanitize user input.

		$my_data = $_POST['jps_nav_type_'.$post_id];

	

		// Update the meta field in the database.

		update_post_meta( $post_id, 'jps_nav_type', $my_data );

	}

	add_action( 'save_post', 'jps_save_meta_box_data' );