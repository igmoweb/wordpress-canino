<?php
//Adds a box to the main column on the Page edit screens
function pr_theme_add_custom_box() 
{
	global $themename;
    add_meta_box( 
        "page-custom-options",
        __("Options", 'pressroom'),
        "pr_theme_inner_custom_box",
        "page",
		"normal",
		"core"
    );
	add_meta_box( 
        "options",
        __("Options", 'pressroom'),
        "pr_theme_inner_custom_box_post",
        "post",
		"normal",
		"core"
    );
	add_meta_box( 
        "review",
        __("Review", 'pressroom'),
        "pr_theme_inner_custom_box_post_review",
        "post",
		"normal",
		"core"
    );
}
add_action("add_meta_boxes", "pr_theme_add_custom_box");
//backwards compatible (before WP 3.0)
//add_action("admin_init", "theme_add_custom_box", 1);

// Prints the box content
function pr_theme_inner_custom_box($post)
{
	global $themename;
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), $themename . "_noncename");
}

// Prints the box content post
function pr_theme_inner_custom_box_post($post)
{
	global $themename;
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), $themename . "_noncename");

	//The actual fields for data entry
	$primary_category = get_post_meta($post->ID, $themename. "_primary_category", true);
	$featured_caption = get_post_meta($post->ID, $themename. "_featured_caption", true);
	$featured_caption_author = get_post_meta($post->ID, $themename. "_featured_caption_author", true);
	$video_url = get_post_meta($post->ID, $themename. "_video_url", true);
	$post_url = get_post_meta($post->ID, $themename. "_post_url", true);
	$quote_text = get_post_meta($post->ID, $themename. "_quote_text", true);
	$quote_author = get_post_meta($post->ID, $themename. "_quote_author", true);
	$audio_url = get_post_meta($post->ID, $themename. "_audio_url", true);
	$attachment_ids = get_post_meta($post->ID, $themename. "_attachment_ids", true);
	$images = get_post_meta($post->ID, $themename. "_images", true);
	$images_titles = get_post_meta($post->ID, $themename. "_images_titles", true);
	$images_descriptions = get_post_meta($post->ID, $themename. "_images_descriptions", true);
	$videos = get_post_meta($post->ID, $themename. "_videos", true);
	$iframes = get_post_meta($post->ID, $themename. "_iframes", true);
	$icon_type = get_post_meta($post->ID, "social_icon_type", true);
	$icon_url = get_post_meta($post->ID, "social_icon_url", true);
	$icon_target = get_post_meta($post->ID, "social_icon_target", true);
	
	$icons = array(
		"blogger",
		"deviantart",
		"dribbble",
		"envato",
		"facebook",
		"flickr",
		"form",
		"forrst",
		"googleplus",
		"instagram",
		"linkedin",
		"mail",
		"myspace",
		"phone",
		"picasa",
		"pinterest",
		"rss",
		"skype",
		"soundcloud",
		"stumbleupon",
		"tumblr",
		"twitter",
		"vimeo",
		"xing",
		"youtube"
	);
	
	//get all categories
	$post_categories = get_terms("category");
	echo '
	<table>
		<tbody>
			<tr>
				<td>
					<label>' . __('Primary category', 'pressroom') . '</label>
				</td>
				<td>
					<select name="primary_category">
						<option value="-">' . __("None", 'pressroom') . '</option>';
					foreach($post_categories as $post_category)
						echo '<option value="' . $post_category->term_id . '"' . ($post_category->term_id==$primary_category ? ' selected="selected"' : '') . '>' . $post_category->name . '</option>';
	echo '			</select>
					<span class="description">' . __("Choose default category for display, when post have multiple categories.", 'pressroom') . '</span>
				</td>
			</tr>
			<tr>
				<td>
					<label>' . __('Post featured caption', 'pressroom') . '</label>
				</td>
				<td>
					<input class="regular-text" type="text" id="' . $themename . '_featured_caption" name="featured_caption" value="' . esc_attr($featured_caption) . '">
				</td>
			</tr>
			<tr>
				<td>
					<label>' . __('Post featured caption author', 'pressroom') . '</label>
				</td>
				<td>
					<input class="regular-text" type="text" id="' . $themename . '_featured_caption_author" name="featured_caption_author" value="' . esc_attr($featured_caption_author) . '">
				</td>
			</tr>
			<tr class="video_row">
				<td>
					<label>' . __('Post video url', 'pressroom') . '</label>
				</td>
				<td>
					<input class="regular-text" type="text" id="' . $themename . '_video_url" name="video_url" value="' . esc_attr($video_url) . '">
					<br>
					<span class="description">' . __('For Vimeo please use http://player.vimeo.com/video/%video_id%<br>For YouTube: http://youtube.com/embed/%video_id%', 'pressroom') . '</span>
				</td>
			</tr>
			<tr class="link_row">
				<td>
					<label>' . __('Post custom link', 'pressroom') . '</label>
				</td>
				<td>
					<input class="regular-text" type="text" id="' . $themename . '_post_url" name="post_url" value="' . esc_attr($post_url) . '">
				</td>
			</tr>
			<tr class="quote_row">
				<td>
					<label>' . __('Post quote text', 'pressroom') . '</label>
				</td>
				<td>
					<textarea id="' . $themename . '_quote_text" name="quote_text" cols="38" rows="4">' . $quote_text . '</textarea>
				</td>
			</tr>
			<tr class="quote_row">
				<td>
					<label>' . __('Post quote author', 'pressroom') . '</label>
				</td>
				<td>
					<input class="regular-text" type="text" id="' . $themename . '_quote_author" name="quote_author" value="' . esc_attr($quote_author) . '">
				</td>
			</tr>
			<tr class="audio_row">
				<td>
					<label>' . __('Post audio url', 'pressroom') . '</label>
				</td>
				<td>
					<input class="regular-text" type="text" id="' . $themename . '_audio_url" name="audio_url" value="' . esc_attr($audio_url) . '">
				</td>
			</tr>
		</tbody>
	</table>
	<div class="clearfix gallery_row">
		<table class="meta_box_options_left">
			<tr valign="top">
				<th colspan="2" scope="row" style="font-weight: bold;">
					' . __('Gallery images', 'pressroom') . '
				</th>
			</tr>';
			for($i=0; $i<(count($images)<3 ? 3 : count($images)); $i++)
			{
			echo '
			<tr class="repeated_row_id_2 repeated_row_' . ($i+1) . '">
				<td colspan="2">
					<table>
						<tr class="image_url_row">
							<td>
								<label>' . __('Image url', 'pressroom') . " " . ($i+1) . '</label>
							</td>
							<td>
								<input type="hidden" name="attachment_ids[]" id="' . $themename . '_attachment_id_' . ($i+1) . '" value="' . (isset($attachment_ids[$i]) ? esc_attr($attachment_ids[$i]) : '') . '" />
								<input class="regular-text" type="text" id="' . $themename . '_image_url_' . ($i+1) . '" name="images[]" value="' . (isset($images[$i]) ? esc_attr($images[$i]) : '') . '" />
								<input type="button" class="button" name="' . $themename . '_upload_button" id="' . $themename . '_image_url_button_' . ($i+1) . '" value="' . __('Browse', 'pressroom') . '" />
							</td>
						</tr>
						<tr class="image_title_row">
							<td>
								<label>' . __('Image title', 'pressroom') . " " . ($i+1) . '</label>
							</td>
							<td>
								<input class="regular-text" type="text" id="' . $themename . '_images_title_' . ($i+1) . '" name="images_titles[]" value="' . (isset($images_titles[$i]) ? esc_attr($images_titles[$i]) : '') . '" />
							</td>
						</tr>
						<tr class="image_description_row">
							<td>
								<label>' . __('Image description', 'pressroom') . " " . ($i+1) . '</label>
							</td>
							<td>
								<textarea id="' . $themename . '_images_description_' . ($i+1) . '" name="images_descriptions[]" rows="4">' . (isset($images_descriptions[$i]) ? $images_descriptions[$i] : '') . '</textarea>
							</td>
						</tr>
						<tr class="image_video_row">
							<td>
								<label>' . __('Video url', 'pressroom') . " " . ($i+1) . '</label>
							</td>
							<td>
								<input class="regular-text" type="text" id="' . $themename . '_video_' . ($i+1) . '" name="videos[]" value="' . (isset($videos[$i]) ? esc_attr($videos[$i]) : '') . '" />
							</td>
						</tr>
						<tr class="image_iframe_row">
							<td>
								<label>' . __('Iframe url', 'pressroom') . " " . ($i+1) . '</label>
							</td>
							<td>
								<input class="regular-text" type="text" id="' . $themename . '_iframe_' . ($i+1) . '" name="iframes[]" value="' . (isset($iframes[$i]) ? esc_attr($iframes[$i]) : '') . '" />
							</td>
						</tr>
					</table>
					<br />
				</td>
			</tr>';
			}
			echo '
			<tr>
				<td colspan="2">
					<input type="button" class="button ' . $themename . '_add_new_repeated_row" name="' . $themename . '_add_new_repeated_row" id="repeated_row_id_2" value="' . __('Add image', 'pressroom') . '" />
				</td>
			</tr>
		</table>
		<table class="meta_box_options_right">
			<tr valign="top">
				<th colspan="2" scope="row" style="font-weight: bold;">
					' . __('Gallery social icons', 'pressroom') . '
				</th>
			</tr>';
			for($i=0; $i<(count($icon_type)<4 ? 4 : count($icon_type)); $i++)
			{
			echo '
			<tr class="repeated_row_id_1 repeated_row_' . ($i+1) . '">
				<td colspan="2">
					<table>
						<tr>
							<td>
								<label>' . __('Icon type', 'pressroom') . " " . ($i+1) . ':</label>
							</td>
							<td>
								<select id="icon_type_' . ($i+1) . '" name="icon_type[]">
									<option value="">-</option>';
									for($j=0; $j<count($icons); $j++)
									{
									echo '<option value="' . esc_attr($icons[$j]) . '"' . (isset($icon_type[$i]) && $icons[$j]==$icon_type[$i] ? " selected='selected'" : "") . '>' . $icons[$j] . '</option>';
									}
							echo '</select>
							</td>
						</tr>
						<tr>
							<td>
								<label>' . __('Icon url', 'pressroom') . " " . ($i+1) . ':</label>
							</td>
							<td>
								<input type="text" class="regular-text" value="' . (isset($icon_url[$i]) ? esc_attr($icon_url[$i]) : '') . '" name="icon_url[]">
							</td>
						</tr>
						<tr>
							<td>
								<label>' . __('Icon target', 'pressroom') . " " . ($i+1) . ':</label>
							</td>
							<td>
								<select name="icon_target[]">
									<option value="same_window"' . (isset($icon_target[$i]) && $icon_target[$i]=="same_window" ? " selected='selected'" : "") . '>' . __('same window', 'pressroom') . '</option>
									<option value="new_window"' . (isset($icon_target[$i]) && $icon_target[$i]=="new_window" ? " selected='selected'" : "") . '>' . __('new window', 'pressroom') . '</option>
								</select>
							</td>
						</tr>
					</table>
					<br />
				</td>
			</tr>';
			}
			echo '
			<tr>
				<td colspan="2">
					<input type="button" class="button ' . $themename . '_add_new_repeated_row" name="' . $themename . '_add_new_repeated_row" id="repeated_row_id_1" value="' . __('Add icon', 'pressroom') . '" />
				</td>
			</tr>
		</table>
	</div>';
}

// Prints the box content post
function pr_theme_inner_custom_box_post_review($post)
{
	global $themename;
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), $themename . "_noncename");

	//The actual fields for data entry
	$is_review = get_post_meta($post->ID, $themename. "_is_review", true);
	$points_scale = get_post_meta($post->ID, $themename. "_points_scale", true);
	$review_label = get_post_meta($post->ID, $themename. "_review_label", true);
	$review_value = get_post_meta($post->ID, $themename. "_review_value", true);
	$review_title = get_post_meta($post->ID, $themename. "_review_title", true);
	$review_description = get_post_meta($post->ID, $themename. "_review_description", true);
	echo '
	<table>
		<tbody>
			<tr>
				<td>
					<label>' . __('Post is review?', 'pressroom') . '</label>
				</td>
			</tr>
			<tr>
				<td>
					<select id="is_review" name="is_review">
						<option value="no"' . ($is_review=="no" ? ' selected="selected"' : '') . '>' . __('no', 'pressroom') . '</option>
						<option value="percentage"' . ($is_review=="percentage" ? ' selected="selected"' : '') . '>' . __('percentage', 'pressroom') . '</option>
						<option value="points"' . ($is_review=="points" ? ' selected="selected"' : '') . '>' . __('points', 'pressroom') . '</option>
					</select>
				</td>
			</tr>
			<tr class="review_title"' . (isset($is_review) && $is_review!="no" && $is_review!="" ? ' style="display: table-row;"' : '') . '>
				<td>
					<label>' . __('Review title', 'pressroom') . '</label>
				</td>
				<td>
					<input class="regular-text" type="text" id="' . $themename . '_review_title" name="review_title" value="' . esc_attr($review_title) . '">
				</td>
			</tr>
			<tr class="review_description"' . (isset($is_review) && $is_review!="no" && $is_review!="" ? ' style="display: table-row;"' : '') . '>
				<td>
					<label>' . __('Review description', 'pressroom') . '</label>
				</td>
				<td>
					<textarea id="' . $themename . '_review_description" name="review_description" cols="38" rows="4">' . $review_description . '</textarea>
				</td>
			</tr>
			<tr class="points_scale"' . (isset($is_review) && $is_review=="points" && $is_review!="" ? ' style="display: table-row;"' : '') . '>
				<td>
					<label>' . __('Points scale (max) value', 'pressroom') . '</label>
				</td>
				<td>
					<input class="regular-text" type="text" id="' . $themename . '_points_scale" name="points_scale" value="' . esc_attr($points_scale) . '">
				</td>
			</tr>';
			$review_details_count = count(array_values(array_filter((array)$review_label)));
			if($review_details_count==0)
				$review_details_count = 3;
			for($i=0; $i<$review_details_count; $i++)
			{
			echo '
			<tr class="repeated_row_review repeated_row_' . ($i+1) . '"' . (isset($is_review) && $is_review!="no" && $is_review!="" ? ' style="display: table-row;"' : '') . '>
				<td colspan="2">
					<table class="review_details">
						<tr>
							<td>
								<label>' . __('Label', 'pressroom') . '</label>
							</td>
							<td>
								<input class="regular-text" type="text" id="' . $themename . '_review_label_' . ($i+1) . '" name="review_label[]" value="' . (isset($review_label[$i]) ? esc_attr($review_label[$i]) : '') . '">
							</td>
							<td>
								<label>' . __('Value', 'pressroom') . '</label>
							</td>
							<td>
								<input class="regular-text" type="text" id="' . $themename . '_review_value_' . ($i+1) . '" name="review_value[]" value="' . (isset($review_value[$i]) ? esc_attr($review_value[$i]) : '') . '"><span class="percent_sign"' . ($is_review=="percentage" ? ' style="display: inline;"' : '') . '>%</span>
							</td>
						</tr>
					</table>
				</td>
			</tr>';
			}
			echo '
			<tr>
				<td>
					<input type="button" class="button ' . $themename . '_add_new_repeated_row" name="' . $themename . '_add_new_repeated_row" id="repeated_row_review" value="' . __('Add rating', 'pressroom') . '"' . ($is_review!="no" && $is_review!="" ? ' style="display: inline;"' : '') . '>
				</td>
			</tr>
		</tbody>
	</table>';
}

//When the post is saved, saves our custom data
function theme_save_postdata($post_id) 
{
	global $themename;
	// verify if this is an auto save routine. 
	// If it is our form has not been submitted, so we dont want to do anything
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
		return;

	//verify this came from the our screen and with proper authorization,
	//because save_post can be triggered at other times
	if((isset($_POST[$themename . '_noncename']) && !wp_verify_nonce($_POST[$themename . '_noncename'], plugin_basename( __FILE__ ))) || !isset($_POST[$themename . '_noncename']))
		return;


	// Check permissions
	if(!current_user_can('edit_post', $post_id))
		return;
		
	//OK, we're authenticated: we need to find and save the data
	update_post_meta($post_id, $themename . "_primary_category", (isset($_POST["primary_category"]) ? $_POST["primary_category"] : ''));
	update_post_meta($post_id, $themename . "_featured_caption", (isset($_POST["featured_caption"]) ? $_POST["featured_caption"] : ''));
	update_post_meta($post_id, $themename . "_featured_caption_author", (isset($_POST["featured_caption_author"]) ? $_POST["featured_caption_author"] : ''));
	update_post_meta($post_id, $themename . "_video_url", (isset($_POST["video_url"]) ? $_POST["video_url"] : ''));
	update_post_meta($post_id, $themename . "_post_url", (isset($_POST["post_url"]) ? $_POST["post_url"] : ''));
	update_post_meta($post_id, $themename . "_quote_text", (isset($_POST["quote_text"]) ? $_POST["quote_text"] : ''));
	update_post_meta($post_id, $themename . "_quote_author", (isset($_POST["quote_author"]) ? $_POST["quote_author"] : ''));
	update_post_meta($post_id, $themename . "_audio_url", (isset($_POST["audio_url"]) ? $_POST["audio_url"] : ''));
	$icon_type = (isset($_POST["icon_type"]) ? (array)$_POST["icon_type"] : array());
	while(end($icon_type)==="")
		array_pop($icon_type);
	update_post_meta($post_id, "social_icon_type", $icon_type);
	update_post_meta($post_id, "social_icon_url", (isset($_POST["icon_url"]) ? $_POST["icon_url"] : ''));
	update_post_meta($post_id, "social_icon_target", (isset($_POST["icon_target"]) ? $_POST["icon_target"] : ''));
	update_post_meta($post_id, $themename . "_attachment_ids", (isset($_POST["attachment_ids"]) ? $_POST["attachment_ids"] : ''));
	$images = (isset($_POST["images"]) ? (array)$_POST["images"] : array());
	while(end($images)==="")
		array_pop($images);
	update_post_meta($post_id, $themename . "_images", $images);
	update_post_meta($post_id, $themename . "_images_titles", (isset($_POST["images_titles"]) ? $_POST["images_titles"] : ''));
	update_post_meta($post_id, $themename . "_images_descriptions", (isset($_POST["images_descriptions"]) ? $_POST["images_descriptions"] : ''));
	update_post_meta($post_id, $themename . "_videos", (isset($_POST["videos"]) ? $_POST["videos"] : ''));
	update_post_meta($post_id, $themename . "_iframes", (isset($_POST["iframes"]) ? $_POST["iframes"] : ''));
	//review
	update_post_meta($post_id, $themename . "_is_review", (isset($_POST["is_review"]) ? $_POST["is_review"] : ''));
	update_post_meta($post_id, $themename . "_points_scale", (isset($_POST["points_scale"]) ? $_POST["points_scale"] : ''));
	update_post_meta($post_id, $themename . "_review_label", (isset($_POST["review_label"]) ? array_filter((array)$_POST["review_label"]) : array()));
	update_post_meta($post_id, $themename . "_review_value", (isset($_POST["review_value"]) ? array_filter((array)$_POST["review_value"]) : array()));
	update_post_meta($post_id, $themename . "_review_title", (isset($_POST["review_title"]) ? $_POST["review_title"] : ''));
	update_post_meta($post_id, $themename . "_review_description", (isset($_POST["review_description"]) ? $_POST["review_description"] : ''));
	//calculate review avg
	if(isset($_POST["is_review"]) && $_POST["is_review"]!="no")
	{
		require_once(locate_template("shortcodes/class/Post.php"));
		update_post_meta($post_id, $themename . "_review_average", Pr_Post::getReviewAverage($post_id, $_POST["is_review"], $themename));
	}
	//sidebars
	update_post_meta($post_id, "page_sidebar_header", (isset($_POST["page_sidebar_header"]) ? $_POST["page_sidebar_header"] : ''));
	update_post_meta($post_id, "page_sidebar_top", (isset($_POST["page_sidebar_top"]) ? $_POST["page_sidebar_top"] : ''));
	update_post_meta($post_id, "page_sidebar_right", (isset($_POST["page_sidebar_right"]) ? $_POST["page_sidebar_right"] : ''));
	update_post_meta($post_id, "page_sidebar_footer_top", (isset($_POST["page_sidebar_footer_top"]) ? $_POST["page_sidebar_footer_top"] : ''));
	update_post_meta($post_id, "page_sidebar_footer_bottom", (isset($_POST["page_sidebar_footer_bottom"]) ? $_POST["page_sidebar_footer_bottom"] : ''));
	update_post_meta($post_id, $themename . "_page_sidebars", array_values(array_filter(array(
		$_POST["page_sidebar_footer_top"],
		$_POST["page_sidebar_footer_bottom"]
	))));
}
add_action("save_post", "theme_save_postdata");
?>