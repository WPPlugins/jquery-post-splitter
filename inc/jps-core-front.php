<?php


	function paged_parts_logic(){
		
		
		if((is_single() || is_page()) && function_exists('jps_premium_options') && jps_get( 'nav_implementation' )!='jQuery'){
			global $post;
			
			if(!empty($post) && isset($post->post_content))
			$post->post_content = str_replace('<!--nextpart-->', '<!--nextpage-->', $post->post_content);
		}
		
	}


function paged_post_the_content_filter($content) {

	

	if(!is_single() && !is_page())
	return $content;



	global $multipage, $numpages, $page, $post, $jps_premium;


	//pree($post);

	$post_nav_type = get_post_meta( get_the_ID(), 'jps_nav_type', true );
	
	//pree($post_nav_type);exit;


	if($post_nav_type!=''){

		$jpps_nav_implementation = $post_nav_type;

	}else{

		$jpps_nav_implementation = jps_get( 'nav_implementation' );	

	}

	

	//pree($jpps_nav_implementation);exit;

	



	$js = (($jpps_nav_implementation=='jQuery' || $jpps_nav_implementation=='' || !$jps_premium)?true:false);//($jps_premium?false:true)
	


	$page_refresh = ($jpps_nav_implementation=='Page Refresh' && $jps_premium);
	
	

	//pree($jps_premium);

	//Show Full Post If Full Post Option



	if(isset($_GET['jps']) && $_GET['jps'] == 'full_post'){



		global $post;



		$ppscontent .= wpautop($post->post_content);



		if(jps_get( 'show_all_link')){



			$ppscontent .=  '<p class="jps-fullpost-link"><a href="'.get_permalink().'" title="View as Slideshow">View as Slideshow</a></p>';



		}







	//Else Show Slideshow



	} elseif($js){



			$ppscontent = jps_free_options($content);



	}else {



		



		if(function_exists('jps_premium_options')){



			$ppscontent = jps_premium_options($content);



		}



		



	}



	// Returns the content.



	return $ppscontent;



}



function jps_header_scripts(){

	?>

    <style type="text/css">

	<?php if(!jps_get( 'show_all_link')){ ?>

	body .jps-fullpost-link{

		display:none;

	}

	<?php } ?>

	</style>

    <?php

}



add_action('wp_head', 'jps_header_scripts'); 
add_action('wp_footer', 'jps_footer_scripts'); 



function paged_post_link_pages($r) {



	global $jps_premium;



	$arr = next_prev_arr();
	$next_text = $arr['next_text'];
	$prev_text = $arr['prev_text'];
	$nav_style = $arr['nav_style'];


	



	$args = array(



		'before'			=> '',



		'after'				=> '',


		'link_before'	=> '',
		'link_afer'	=> '',
		'next_or_number'	=> 'next',



		'nextpagelink'		=> __('<span class="jps-next '.$nav_style.'">'.$next_text.'</span>'),



		'previouspagelink'	=> __('<span class="jps-prev '.$nav_style.'">'.$prev_text.'</span>'),



		'echo' => 0



	  );



	  return wp_parse_args($args, $r);







}







function paged_post_scripts() {



	if(is_single() || is_page() ){



		



		global $jps_premium;



		



		wp_enqueue_script('jquery');



		$post_nav_type = get_post_meta( get_the_ID(), 'jps_nav_type', true );



		if($post_nav_type!=''){

			$jpps_nav_implementation = $post_nav_type;

		}else{

			$jpps_nav_implementation = jps_get( 'nav_implementation' );	

		}



		$js = ($jpps_nav_implementation=='jQuery'?true:false);//($jps_premium?false:true)

		



		$page_refresh = ($jpps_nav_implementation=='Page Refresh');



		$ajax = ($jpps_nav_implementation=='Ajax');



		$jpps_options_array = array( 'scroll_up' => jps_get( 'scroll_up') );

		

		if($js){



			



			wp_enqueue_script('paged-post-jquery', plugins_url( 'js/paged-post-jquery.js', dirname(__FILE__)), 'jquery', '', true);



			wp_enqueue_style('paged-post-jquery', plugins_url( 'css/paged-post-jquery.css', dirname(__FILE__)));

			
			wp_localize_script( 'paged-post-jquery', 'jpps_options_object', $jpps_options_array );

			



		}elseif($jps_premium){



			if(function_exists('jps_premium_scripts')){



				jps_premium_scripts();

				wp_localize_script( 'jquery-post-splitter', 'jpps_options_object', $jpps_options_array );

			}



		}



		



		




		if(jps_get( 'style_sheet')){



				wp_enqueue_style('paged-post-style', plugins_url( 'css/paged-post.css?j='.date('Ymhi') , dirname(__FILE__)));



		}



		



	}



}



function jps_free_options($ppscontent){



		



		global $multipage, $numpages, $page, $jps_headings;



		$jps_headings_display = ((jps_get('headings_display') && function_exists('jps_headings'))?true:false);

		$jps_bullets_display = ((jps_get('bullets_display') && function_exists('jps_leftnav'))?true:false);


		$ppscontent_arr = array();



		if ( (is_single() || is_page()) ){



			



			global $post;



			$post_parts = explode('<!--nextpart-->', $ppscontent);

			//pre($post_parts);

			if(!empty($post_parts) && count($post_parts)>1){

			
				$arr = next_prev_arr();
				$next_text = $arr['next_text'];
				$prev_text = $arr['prev_text'];
				$nav_style = $arr['nav_style'];

				$page = 0; $numpages = count($post_parts);
				
				if(empty($jps_headings)){
	
					foreach($post_parts as $content){
						
						$get_heading = explode('</h2>', $content);
						
						if(!empty($get_heading) && count($get_heading)>1){
							$get_heading = current($get_heading);
							$get_heading = explode('<h2>', $get_heading);
							if(!empty($get_heading)){
								$heading = end($get_heading);
								//if(!in_array($heading, $jps_headings))
								$jps_headings[] = ($heading!=''?$heading:'Next');
							}
						}
						
					}
				
				}
				
				//pre($jps_headings);
				
				foreach($post_parts as $content){ $page++;



						



			



					$sliderclass = 'pagination-slider';



					$slidecount = ($numpages>1?'<span class="jps-slide-count"><span class="jps_cc">'.$page.'</span> <span class="jps_oo">of</span> <span class="jps_tt">'.$numpages.'</span></span>':'');



					if($page == $numpages){



						$slideclass = 'jps-last-slide';



					} elseif ($page == 1){



						$slideclass = 'jps-first-slide';



					} else{



						$slideclass = 'jps-middle-slide';



					}



			



					//What to Display For Content



					$ppscontent = '<div id="post-part-'.$page.'" class="jps-wrap-content jps-parent-div"><div class="jps-the-content '.$slideclass.'">';



			



					//Top Slider Navigation



					if((jps_get( 'nav_position' ) == 'top' || jps_get( 'nav_position' ) == '') || (jps_get( 'nav_position' ) == 'both')){



						



			

						$wp_link_pages = wp_link_pages();
						$wp_link_pages = ($wp_link_pages!=''?$wp_link_pages:jps_pages_links($page, $numpages));

						$ppscontent_nav = ($jps_headings_display?jps_headings($page, get_permalink($post->ID)):$wp_link_pages);
			

						$ppscontent .= (($numpages>1 && $ppscontent_nav!='')?'<nav class="jps-slider-nav jps-clearfix '.($jps_headings_display?'jps_heading_display':'').' '.$nav_style.'">'.$ppscontent_nav:'');
			



						// If Loop Option Selected, Loop back to Beginning



						if(jps_get( 'loop_slides')){



							if($page == $numpages && !$jps_headings_display){



								$ppscontent .= '<a class="jps-next-link"><span class="jps-next '.$nav_style.'">'.$next_text.'</span></a>';



							}



						}



			



						// Top Slide Counter



						if((jps_get( 'count_position' ) == 'top' || jps_get( 'count_position' ) == '') || (jps_get( 'count_position' ) == 'both')){



							$ppscontent .= $slidecount;



						}



			



						$ppscontent .= ($numpages>1?'</nav>':'');



					}



			



					//Top Slide Counter Without Top Nav



					if(((jps_get( 'count_position' ) == 'top') || (jps_get( 'count_position' ) == 'both')) && ((jps_get( 'nav_position' ) != 'top')&&(jps_get( 'nav_position' ) != 'both'))){



							$ppscontent .= $slidecount;



					}
			


					
					

					// Slide Content

					if($jps_bullets_display){
						
						$ppscontent .= ($numpages>1?'<div class="jps-content jps-clearfix">'.jps_leftnav($page).'<div class="content-extact">'.(jps_get( 'br_status')?nl2br($content):$content).'</div></div>':'');
					
					}else{
						
						$ppscontent .= ($numpages>1?'<div class="jps-content jps-clearfix">'.(jps_get( 'br_status')?nl2br($content):$content).'</div>':'');
						
					}



			



					// Bottom Slider Navigation



					if((jps_get( 'nav_position' ) == 'bottom')||(jps_get( 'nav_position' ) == 'both')){



						

						$wp_link_pages = wp_link_pages();
						$wp_link_pages = ($wp_link_pages!=''?$wp_link_pages:jps_pages_links($page, $numpages));

						$ppscontent_nav = ($jps_headings_display?jps_headings($page, get_permalink($post->ID)):$wp_link_pages);
						

						$ppscontent_nav = ($jps_headings_display?jps_headings($page, get_permalink($post->ID)):$wp_link_pages);

 
						$ppscontent .= (($numpages>1 && $ppscontent_nav!='')?'<nav class="jps-slider-nav jps-bottom-nav jps-clearfix '.($jps_headings_display?'jps_heading_display':'').' '.$nav_style.'">'.$ppscontent_nav:'');
			



						// If Loop Option Selected, Loop back to Beginning



						if(jps_get( 'loop_slides')){



							if($page == $numpages && !$jps_headings_display){



								$ppscontent .= '<a class="jps-next-link"><span class="jps-next '.$nav_style.'">'.$next_text.'</span></a>';



							}



						}



			



						// Bottom Slide Counter



						if((jps_get( 'count_position' ) == 'bottom')||(jps_get( 'count_position' ) == 'both')){



							$ppscontent .= $slidecount;



						}



			



						$ppscontent .= ($numpages>1?'</nav>':'');



					}



			



					// Bottom Slide Counter Without Bottom Nav



					if(((jps_get( 'count_position' ) == 'bottom')||(jps_get( 'count_position' ) == 'both')) && ((jps_get( 'nav_position' ) != 'bottom')&&(jps_get( 'nav_position' ) != 'both'))){



							$ppscontent .= $slidecount;



						}



			



					// End Slider Div



					$ppscontent .= ($numpages>1?'</div></div>':'');



			



					// Show Full Post Link



					if(jps_get( 'show_all_link')){



						$ppscontent .=  '<p class="jps-fullpost-link vf-'.$page.' '.($page==1?'':'hide').'"><a href="'.add_query_arg( 'jps', 'full_post', get_permalink() ).'" title="View Full Post">View Full Post</a></p>';



					}



			



				// Else It Isn't Pagintated, Don't Show Slider



				



				$ppscontent_arr[] = $ppscontent;



				}



				return implode(' ', $ppscontent_arr);

			}else{ 

				//return nl2br($post->post_content);

				if(is_single() || is_page())

				return (jps_get( 'br_status')?nl2br($post->post_content):$post->post_content);

				else

				return $ppscontent;

			}



			//exit;



			



		}		



		



}
	function jps_pages_links($start, $end){
		$ret = '';

		$arr = next_prev_arr();
		$next_text = $arr['next_text'];
		$prev_text = $arr['prev_text'];
		$nav_style = $arr['nav_style'];
				
		if($start>1)
		$ret .= '<a><span class="jps-prev '.$nav_style.'">'.$prev_text.'</span></a>';
		
		if($start!=$end)
		$ret .= '<a><span class="jps-next '.$nav_style.'">'.$next_text.'</span></a>';
		
		return $ret;
	}

	function jps_footer_scripts(){
		
		global $jps_headings;
		
		$next_prev_arr = next_prev_arr();
		//pree($next_prev_arr);
?>
	<script type="text/javascript" language="javascript">
		//<?php echo implode(', ', $jps_headings); ?>
		
	jQuery(document).ready(function($) {
		
		<?php if(!jps_get( 'loop_slides') && function_exists('epn_prev_post_link') && function_exists('epn_next_post_link')){ ?>
		if($(".jps-slider-nav").length>0){
			$.each($(".jps-slider-nav"), function(){
				
				if($(this).find("a").length==1){
					//$(this).prepend($(this).find('a').clone());
					//$(this).find('a').eq(0).css('visibility', 'hidden');
					if($(this).find('a > span').hasClass('jps-next'))
					$('<?php echo epn_prev_post_link(false, '<span class="'.$next_prev_arr['nav_style'].' jps-prev">'.$next_prev_arr['prev_text'].'</span>'); ?>').insertBefore($(this).find('a'));
					else
					$('<?php echo epn_next_post_link(false, '<span class="'.$next_prev_arr['nav_style'].' jps-next">'.$next_prev_arr['next_text'].'</span>'); ?>').insertAfter($(this).find('a'));
				}
			});
		}
		<?php } ?>
	});	
	</script>
<?php		
	}
	
	add_action('init', 'spnp_js');


	function spnp_js() {		
		if (!empty($_REQUEST['spnp-action']) && $_REQUEST['spnp-action'] == 'spnp-admin-js') {
			header('content-type: text/javascript');?>
            var wp, hasWpautop;
            ( function( tinymce ) {
tinymce.PluginManager.add( 'wordpress', function( editor ) {
	var wpAdvButton, style,
		DOM = tinymce.DOM,
		each = tinymce.each,
		__ = editor.editorManager.i18n.translate,
		$ = window.jQuery,
		wp = window.wp,
		hasWpautop = ( wp && wp.editor && wp.editor.autop && editor.getParam( 'wpautop', true ) );
});
});
            (function() {
           	
        	
	tinymce.create("tinymce.plugins.spnpnextpage", {
		init : function(ed, url) {			
			ed.addButton("jpsPPBtnBtn", {
                title: "<?php echo __('Insert Next Page Tag', 'jquery-post-splitter'); ?>",
				cmd: "cmd_jpsPPBtnBtn",
				onclick : function() {
                         ed.selection.setContent("<!--nextpart-->");
                    }
            });
			ed.addCommand( "cmd_jpsPPBtnBtn", function() {
				var selected_text = ed.selection.getContent();
				var return_text = "";
				return_text = "<!--nextpart-->";
				ed.execCommand("mceInsertContent", 0, return_text);
			});
						
			                    
            ed.on( 'BeforeSetContent', function( event ) {
                var title;
        
                if ( event.content ) {
                            
                    if ( event.content.indexOf( '<!--nextpart-->' ) !== -1 ) {
                        title = 'Page Splitter';
        
                        event.content = event.content.replace( /<!--nextpart-->/g,
                            '<img src="' + tinymce.Env.transparentSrc + '" data-wp-more="nextpart" class="wp-more-tag mce-wp-nextpart" ' +
                                'alt="" title="' + title + '" data-mce-resize="false" data-mce-placeholder="1" />' );
                    }
        
                    if ( event.load && event.format !== 'raw' && hasWpautop ) {
                        event.content = wp.editor.autop( event.content );
                    }
        
                    // Remove spaces from empty paragraphs.
                    // Avoid backtracking, can freeze the editor. See #35890.
                    // (This is also quite faster than using only one regex.)
                    event.content = event.content.replace( /<p>([^<>]+)<\/p>/gi, function( tag, text ) {
                        if ( /^(&nbsp;|\s|\u00a0|\ufeff)+$/i.test( text ) ) {
                            return '<p><br /></p>';
                        }
        
                        return tag;
                    });
                }
            });            
			// Replace image with tag
            ed.on( 'PostProcess', function( e ) {
                if ( e.get ) {
                    e.content = e.content.replace(/<img[^>]+>/g, function( image ) {
                        var match, moretext = '';
        
                        if ( image.indexOf( 'data-wp-more="nextpart"' ) !== -1 ) {
                            image = '<!--nextpart-->';
                        }
        
                        return image;
                    });
                }
            });	
            
            
		},
		getInfo : function() {
            return {
                longname: "jpsPPBtn",
                author: "Fahad Mahmood",
                authorurl: "https://profiles.wordpress.org/fahadmahmood/#content-plugins",
                infourl: "https://profiles.wordpress.org/fahadmahmood/",
                version: "2.3.5"
            };
        }
	});
	tinymce.PluginManager.add("spnpnextpage", tinymce.plugins.spnpnextpage);
})();<?php exit;
		}
	}	