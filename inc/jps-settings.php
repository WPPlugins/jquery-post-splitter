<?php global $wpdb; 


if ( 
    ! isset( $_POST['jps_patch_field'] ) 
    || ! wp_verify_nonce( $_POST['jps_patch_field'], 'jps_patch' ) 
) {

   //print 'Sorry, your nonce did not verify.';
   //exit;

} else {

   // process form data
   $q = "SELECT ID, post_content FROM $wpdb->posts WHERE post_content LIKE '%<!--nextpage-->%' AND post_type IN ('post', 'page')";
	$fix_required = $wpdb->get_results($q);
	if(!empty($fix_required)){
		foreach($fix_required as $ids){
			$post_content = $ids->post_content;
			$post_content = str_replace('<!--nextpage-->', '<!--nextpart-->', $post_content);
			//$uq = "UPDATE $wpdb->posts SET post_content='$post_content' WHERE ID=$ids->ID LIMIT 1";
			//$wpdb->query($uq);
			  $my_post = array(
				  'ID'           => $ids->ID,
				  'post_content' => $post_content,
			  );
			  wp_update_post( $my_post );			
		}
	}
   
}

$q = "SELECT COUNT(*) AS nextpage FROM $wpdb->posts WHERE post_content LIKE '%<!--nextpage-->%' AND post_type IN ('post', 'page')";
$fix_required = $wpdb->get_row($q);
$fix_required = $fix_required->nextpage;

?>
        


	<div class="wrap">



		<h2><?php _e( $jps_title.' Options', 'jpps_trans_domain' ); ?></h2>

<?php if(!$jps_premium): ?>
<a title="Click here to download pro version" style="background-color: #25bcf0;    color: #fff !important;    padding: 2px 30px;    cursor: pointer;    text-decoration: none;    font-weight: bold;    right: 0;    position: absolute;    top: 0;    box-shadow: 1px 1px #ddd;" href="http://shop.androidbubbles.com/download/" target="_blank">Already a Pro Member?</a>
<?php endif; ?>


<?php 
$this_url = str_replace( '%7E', '~', $_SERVER['REQUEST_URI'] );
if($fix_required>0): ?>
<div class="jps-patch-alert">
<form action="<?php echo $this_url; ?>" method="post">
<?php wp_nonce_field( 'jps_patch', 'jps_patch_field' ); ?>
You're using <strong>&lt;!--nextpage--&gt;</strong> instead of <strong>&lt;!--nextpart--&gt;</strong> in <?php echo $fix_required; ?> posts and/or pages. Do you want to implement the patch now? It will convert nextpage to nextpart and this plugin will work fine for these posts and pages as well.<br />
<input class="button button-secondary" name="jps-patch" type="submit" value="Click here to Apply Patch" />
</form>
</div>
<?php endif; ?>

		<form name="jpps_img_options" method="post" action="<?php echo $this_url; ?>">



			<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">







			<table class="form-table jps_settings_table">



				<tbody>



                



              	  <tr valign="top">



						<th scope="row">



							<label for="nav_implementation">Implementation:</label>



						</th>



						<td>



							<?php jps_nav_method(); ?>



                            



							<?php jps_go_premium(); ?>



						</td>



					</tr>







					<tr valign="top">



						<th scope="row">



							<label for="nav_position">Slider Navigation Position:</label>



						</th>



						<td>



							<select name="jps_options[nav_position]">



								<option value="top" <?php echo (jps_get('nav_position') == "top") ? 'selected="selected"' : ''; ?> >Top</option>



								<option value="bottom" <?php echo (jps_get('nav_position') == "bottom") ? 'selected="selected"' : ''; ?> >Bottom</option>



								<option value="both" <?php echo (jps_get('nav_position') == "both") ? 'selected="selected"' : ''; ?> >Both</option>



							</select>



						</td>



					</tr>



                    



<?php if($jps_premium): ?>                    



<?php jps_nav_styles(); ?>



<?php endif; ?>                                        







					<tr valign="top">



						<th scope="row">



							<label for="count_position">Slider Count (e.g. "2 of 4") Position:</label>



						</th>



						<td>



							<select name="jps_options[count_position]">



								<option value="top" <?php echo (jps_get('count_position') == "top") ? 'selected="selected"' : ''; ?> >Top</option>



								<option value="bottom" <?php echo (jps_get('count_position') == "bottom") ? 'selected="selected"' : ''; ?> >Bottom</option>



								<option value="both" <?php echo (jps_get('count_position') == "both") ? 'selected="selected"' : ''; ?> >Both</option>



								<option value="none" <?php echo (jps_get('count_position') == "none") ? 'selected="selected"' : ''; ?> >Do Not Display</option>



							</select>



						</td>



					</tr>





<?php if($jps_premium): ?>  

<?php if(function_exists('jps_headings')): ?>
<tr valign="top"><th scope="row"><label for="jps_headings_display">Display Post Headings:</label>
</th><td>
<input name="jps_options[jps_headings_display]" type="checkbox" value="1" <?php checked( '1', jps_get('headings_display') ); ?> /> It will display post sub-heading instead of Prev/Next.<br />
<small>&lt;h2&gt;&lt;/h2&gt; will be considered as sub-heading inside your content.</small></td></tr>
<?php endif; ?>
<?php if(function_exists('jps_leftnav')): ?>
<tr valign="top"><th scope="row"><label for="jps_bullets_display">Display Left Navigation:</label>
</th><td>
<input name="jps_options[jps_bullets_display]" type="checkbox" value="1" <?php checked( '1', jps_get('bullets_display') ); ?> /> It will display post sub-heading in bullets.</td></tr>
<?php endif; ?>
<?php endif; ?> 
					<tr valign="top">

						<th scope="row">
                        <a class="jps_additional_link">+ Additional Settings</a>
                        <a class="jps_additional_link_revert">- Hide Settings</a>
                        </th>
                        <td>
                        </td>
					</tr>

					<tr valign="top" class="jps_additional">



						<th scope="row">



							<label for="style_sheet">Use Style Sheet?</label>



						</th>



						<td>



								<input name="jps_options[style_sheet]" type="checkbox" value="1" <?php checked( '1', jps_get('style_sheet') ); ?> /> If unchecked, no styles will be added.



						</td>



					</tr>



<tr valign="top" class="jps_additional">

						<th scope="row">


							<label for="post_titles">Post titles as navigation?</label>


						</th>

						<td>

								<input name="jps_options[post_titles]" type="checkbox" value="1" <?php checked( '1', jps_get('post_titles') ); ?> id="post_titles" /> Want to use heading tag &lt;h2&gt; as titles to navigate instead of next, previous?



						</td>
					</tr>



					<tr valign="top" class="jps_additional">



						<th scope="row">



							<label for="show_all_link">Display link to <em>View Full Post</em>?</label>



						</th>



						<td>



								<input name="jps_options[show_all_link]" type="checkbox" value="1" <?php checked( '1', jps_get('show_all_link') ); ?> /> If unchecked, the <em>View Full Post</em> link will not be displayed.



						</td>



					</tr>

<?php if($jps_premium): ?>  

				<tr valign="top" class="jps_additional">



						<th scope="row">



							<label for="show_all_first">SEO Trick:</label>



						</th>



						<td>



								<input name="jps_options[show_all_first]" type="checkbox" value="1" <?php checked( '1', jps_get('show_all_first') ); ?> /> Display full content on first page as hidden? 


						</td>



					</tr>

<?php endif; ?>

					<tr valign="top" class="jps_additional">



						<th scope="row">



							<label for="loop_slides">Loop slides?</label>



						</th>



						<td>



								<input name="jps_options[loop_slides]" type="checkbox" value="1" <?php checked( '1', jps_get('loop_slides') ); ?> /> Creates an infinite loop of the slides.



						</td>



					</tr>




<tr valign="top" class="jps_additional">



						<th scope="row">



							<label for="br_status">Insert &lt;br /&gt; with each return key?</label>



						</th>



						<td>



								<input name="jps_options[br_status]" type="checkbox" value="1" <?php checked( '1', jps_get('br_status') ); ?> /> Insert line break for each "enter key".



						</td>



				  </tr>


					<tr valign="top" class="jps_row jquery ajax">



						<th scope="row">



							<label for="scroll_up">Scroll to top of page after slide load? (jQuery/Ajax)</label>



						</th>



						<td>



								<input name="jps_options[scroll_up]" type="checkbox" value="1" <?php checked( '1', jps_get('scroll_up') ); ?> /> Scrolls up to the top of the page after each slide loads.



						</td>



					</tr>







				</tbody>



			</table>







			<p>



				<input type="submit" class="button button-primary" value="Save Settings">



			</p>







		</form>
        
        
        
<div class="jps_shortcodes">
<p>Want to combine different pages/sub-pages or posts into one? Use shortcodes with page/post ID as follows.</p>
<pre>[JPS_CHUNK id="62" type="title"]</pre>
<pre>[JPS_CHUNK id="62" type="content"]</pre>
<pre>[JPS_CHUNK id="62" type="excerpt"]</pre>
<p>Instructions: Replace id="62" with page/post IDs you want to use as a chunk.</p>
<p>Note: Shortcodes are included in premium version.</p>
</div>        
</div>
<script type="text/javascript" language="javascript">
	function jps_replaceAll(str, find, replace) {
	  return str.replace(new RegExp(find, 'g'), replace);
	}
	jQuery(document).ready(function($){
		
		var implementation = 'select[name="jps_options[nav_implementation]"]';
		$(implementation).change(function(){
			var obj = $(implementation).find('option[value="'+$(this).val()+'"]');

			if(obj.length>0){
				
				var val = jps_replaceAll($(this).val().toLowerCase(), ' ', '_');
				if(val!=''){
				
					var main = '.jps_row';
					var selector = main+'.'+val;
					
					if($(main).length>0){
						$(main).hide();				
					}
					if($(selector).length>0 && !$(selector).is(':visible'))
					$(selector).show();
				}
			}
			
		});
		
		if($(implementation).length>0)
		$(implementation).trigger('change');
		
		$('.jps_additional_link').click(function(){
			$(this).hide();
			$('.jps_additional_link_revert').show();
			$('.jps_additional').slideDown();
		});
		$('.jps_additional_link_revert').click(function(){
			$(this).hide();
			$('.jps_additional_link').show();
			$('.jps_additional').hide();
		});		
		$('.jps_premium_link').fadeIn();
		
	});
</script>                
<style type="text/css">
.woocommerce-message{ display:none; }
</style>