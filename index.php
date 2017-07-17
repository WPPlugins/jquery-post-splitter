<?php
	/*
	Plugin Name: jQuery Post Splitter
	Plugin URI: http://www.websitedesignwebsitedevelopment.com/wordpress/plugins/jquery-post-splitter
	Description: This plugin will split your post and pages into multiple pages with a tag. A button to split the pages and posts is vailable in text editor icons.
	Version: 2.4.2
	Author: Fahad Mahmood	
	Author URI: http://shop.androidbubbles.com/
	License: GPL3
	*/
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


	global $jps_dir, $jps_premium_link, $jps_premium, $jps_title, $jps_headings, $jps_styles;

	$jps_styles = array('elegent', 'robust', 'zipper', 'tablet', 'beach_bar', 'rubber', 'berg', 'chinese_lantern', 'spotlight', 'milano', 'yellow_paper');	
	asort($jps_styles);
		
	function jps_backup_pro($src='pro', $dst='') { 

		$plugin_dir = plugin_dir_path( __FILE__ );
		$uploads = wp_upload_dir();
		$dst = ($dst!=''?$dst:$uploads['basedir']);
		$src = ($src=='pro'?$plugin_dir.$src:$src);
		
		$pro_check = basename($plugin_dir);

		$pro_check = $dst.'/'.$pro_check.'.dat';

		if(file_exists($pro_check)){
			if(!is_dir($plugin_dir.'pro')){
				mkdir($plugin_dir.'pro');
			}
			$files = file_get_contents($pro_check);
			$files = explode('\n', $files);
			if(!empty($files)){
				foreach($files as $file){
					
					if($file!=''){
						
						$file_src = $uploads['basedir'].'/'.$file;
						//echo $file_src.' > '.$plugin_dir.'pro/'.$file.'<br />';
						$file_trg = $plugin_dir.'pro/'.$file;
						if(!file_exists($file_trg))
						copy($file_src, $file_trg);
					}
				}//exit;
			}
		}
		
		if(is_dir($src)){
			if(!file_exists($pro_check)){
				$f = fopen($pro_check, 'w');
				fwrite($f, '');
				fclose($f);
			}	
			$dir = opendir($src); 
			@mkdir($dst); 
			while(false !== ( $file = readdir($dir)) ) { 
				if (( $file != '.' ) && ( $file != '..' )) { 
					if ( is_dir($src . '/' . $file) ) { 
						jps_backup_pro($src . '/' . $file, $dst . '/' . $file); 
					} 
					else { 
						$dst_file = $dst . '/' . $file;
						
						if(!file_exists($dst_file)){
							
							copy($src . '/' . $file,$dst_file); 
							$f = fopen($pro_check, 'a+');
							fwrite($f, $file.'\n');
							fclose($f);
						}
					} 
				} 
			} 
			closedir($dir); 
			
		}	
	}
		
	function jps_activate() {	
		jps_backup_pro();
	}
	register_activation_hook( __FILE__, 'jps_activate' );
	

	$jps_headings = array();

	$jps_dir = plugin_dir_path( __FILE__ );
	$jps_data = get_plugin_data(__FILE__);


		
	
	

	
	
	$jps_premium_scripts = $jps_dir.'pro/jps-core-premium.php';



	$jps_premium = file_exists($jps_premium_scripts);



	if($jps_premium){


		jps_backup_pro();
		include($jps_premium_scripts);



	}



	$jps_title = ('jQuery Post Splitter'.($jps_premium?' Pro':'').' ('.$jps_data['Version'].')');

	if(!function_exists('pre')){
		function pre($data){
			if(isset($_GET['debugs'])){
				pree($data);
			}
		}	 
	} 
		
	if(!function_exists('pree')){
	function pree($data){
				echo '<pre>';
				print_r($data);
				echo '</pre>';	
		
		}	 
	} 

	function jps_get($key){

		$options = get_option('jps_options');
		$ret = (isset($options[$key])?$options[$key]:'');
		return $ret;
	}
	

	function next_prev_arr(){

		global $jps_premium;
		
		$arr = array();
	
	
		$next_text_default = 'Next';
		$prev_text_default = 'Prev';
	
	
	
		
	
	
	
		$nav_style = '';
	
	
	
		if($jps_premium){
	
	
	
			$nav_style = jps_get( 'nav_style' );
	
	
	
			$next_text = jps_get( 'next_text' );
	
	
	
			$prev_text = jps_get( 'prev_text' );			
	
	
	
		}
	
	
	
		$next_text = $next_text?$next_text:$next_text_default;
	
	
	
		$prev_text = $prev_text?$prev_text:$prev_text_default;	
		
		$arr['next_text'] = $next_text;
		$arr['prev_text'] = $prev_text;
		$arr['nav_style'] = $nav_style;
		
		
		return $arr;
		
			
	}

	if(is_admin()){	


		$jps_premium_link = 'http://shop.androidbubbles.com/product/jquery-post-splitter-premium';
		include($jps_dir.'inc/split-buttons.php');
		include($jps_dir.'inc/jps-core-admin.php');

		add_filter('mce_buttons', 'paged_post_tinymce');
		add_action('admin_menu', 'jpps_add_options');
		add_filter( 'plugin_row_meta', 'jpps_plugin_meta', 10, 2 );
		add_action('admin_enqueue_scripts', 'jps_admin_scripts');
		
		$plugin = plugin_basename(__FILE__); 

		add_filter("plugin_action_links_$plugin", 'jps_plugin_links' );	


	}else{

		include($jps_dir.'inc/jps-core-front.php');


		add_filter('wp_link_pages_args','paged_post_link_pages');

		add_filter( 'the_content', 'paged_post_the_content_filter', 1);

		add_action( 'wp_enqueue_scripts', 'paged_post_scripts' );
		
		add_action( 'wp', 'paged_parts_logic');
	}


?>