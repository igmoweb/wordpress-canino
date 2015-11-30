<?php
function pr_theme_authors_carousel_shortcode($atts)
{
	global $themename;
	extract(shortcode_atts(array(
		"id" => "carousel",
		"items_per_page" => 4,
		"ids" => "",
		"category" => "",
		"order_by" => "display_name",
		"order" => "ASC",
		"visible" => 3,
		"post_details_layout" => "simple",
		"count_number" => 0,
		"show_social_icons" => 1,
		"show_twitter" => 1,
		"show_facebook" => 1,
		"show_linkedin" => 1,
		"show_skype" => 1,
		"show_googleplus" => 1,
		"show_instagram" => 1,
		"show_description" => 1,
		"profile_button" => 0,
		"featured_image_size" => "default",
		"features_images_loop" => 1,
		"autoplay" => 0,
		"pause_on_hover" => 1,
		"scroll" => 1,
		"effect" => "scroll",
		"easing" => "swing",
		"duration" => 500,
		"ontouch" => 0,
		"onmouse" => 0,
		"top_margin" => "none"
	), $atts));
	
	$ids = explode(",", $ids);
	if($ids[0]=="-" || $ids[0]=="")
	{
		unset($ids[0]);
		$ids = array_values($ids);
	}
	$args = array(
		'orderby' => $order_by, 
		'order' => $order, 
		'number' => $items_per_page,
		'include' => $ids,
		'who' => 'authors'
	);
	$authors_list = get_users($args);
	$output = '';
	if(count($authors_list))
		$output .= '<div class="horizontal_carousel_container authors_carousel_container' . ($top_margin!="none" ? ' ' . $top_margin : '') . '"><ul class="horizontal_carousel visible-' . (int)$visible . ' autoplay-' . (int)$autoplay . ' pause_on_hover-' . (int)$pause_on_hover . ' scroll-' . (int)$scroll . '">';
	foreach($authors_list as $author) 
	{
		$output .= '<li class="single-author">
			<a href="' . get_author_posts_url($author->ID) . '" title="' . esc_attr($author->display_name) . '">
				' . get_avatar($author->ID, 330) . '
			</a>
			<h6>' . strtoupper($author->roles[0]) . '</h6>
			<h4><a href="' . get_author_posts_url($author->ID) . '" title="' . esc_attr($author->display_name) . '">' . $author->display_name . '</a></h4>';
			$description = get_the_author_meta("description", $author->ID);
			if($description!="" && (int)$show_description)
				$output .= '<p>' . $description . '</p>';
			if((int)$show_social_icons && ((int)$show_twitter || (int)$show_facebook || (int)$show_linkedin || (int)$show_skype || (int)$show_googleplus || (int)$show_instagram))
			{
				if((int)$show_twitter)
					$twitter = get_the_author_meta("twitter", $author->ID);
				if((int)$show_facebook)
					$facebook = get_the_author_meta("facebook", $author->ID);
				if((int)$show_linkedin)
					$linkedin = get_the_author_meta("linkedin", $author->ID);
				if((int)$show_skype)
					$skype = get_the_author_meta("skype", $author->ID);
				if((int)$show_googleplus)
					$googleplus = get_the_author_meta("googleplus", $author->ID);
				if((int)$show_instagram)
					$instagram = get_the_author_meta("instagram", $author->ID);
				if($twitter!="" || $facebook!="" || $linkedin!="" || $skype!="" || $googleplus!="" || $instagram!="")
				{
					$output .= '<ul class="social_icons margin_top_10 clearfix">';
					if($twitter!="")
						$output .= '<li><a target="_blank" title="" href="' . esc_url($twitter) . '" class="social_icon twitter">&nbsp;</a></li>';
					if($facebook!="")
						$output .= '<li><a target="_blank" title="" href="' . esc_url($facebook) . '" class="social_icon facebook">&nbsp;</a></li>';
					if($linkedin!="")
						$output .= '<li><a target="_blank" title="" href="' . esc_url($linkedin) . '" class="social_icon linkedin">&nbsp;</a></li>';
					if($skype!="")
						$output .= '<li><a target="_blank" title="" href="' . esc_url($skype) . '" class="social_icon skype">&nbsp;</a></li>';
					if($googleplus!="")
						$output .= '<li><a target="_blank" title="" href="' . esc_url($googleplus) . '" class="social_icon googleplus">&nbsp;</a></li>';
					if($instagram!="")
						$output .= '<li><a target="_blank" title="" href="' . esc_url($instagram) . '" class="social_icon instagram">&nbsp;</a></li>';
					$output .= '</ul>';
				}
			}
			if((int)$profile_button)
				$output .= '<a title="' . __('Profile', 'pressroom') . '" href="' . get_author_posts_url($author->ID) . '" class="read_more"><span class="arrow"></span><span>' . __('PROFILE', 'pressroom') . '</span></a>';
		$output .= '</li>';
	}
	
	if(count($authors_list))
		$output .= '</ul></div>';
	return $output;
}
add_shortcode("pr_authors_carousel", "pr_theme_authors_carousel_shortcode");

//visual composer
function pr_theme_authors_carousel_vc_init()
{
	//get authors list
	$authors_list = get_users(array(
		'who' => 'authors'
	));
	$authors_array = array();
	$authors_array[__("All", 'pressroom')] = "-";
	foreach($authors_list as $author)
		$authors_array[$author->display_name . " (id:" . $author->ID . ")"] = $author->ID;
	$params = array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Id", 'pressroom'),
			"param_name" => "id",
			"value" => "carousel",
			"description" => __("Please provide unique id for each carousel on the same page/post", 'pressroom')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Count", 'pressroom'),
			"param_name" => "items_per_page",
			"value" => 5,
			"description" => __("Set 0 to display all.", 'pressroom')
		),
		array(
			"type" => "dropdownmulti",
			"class" => "",
			"heading" => __("Display selected", 'pressroom'),
			"param_name" => "ids",
			"value" => $authors_array
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order by", 'pressroom'),
			"param_name" => "order_by",
			"value" => array(__("Display name", 'pressroom') => "display_name", __("Post count", 'pressroom') => "post_count", __("Registered date", 'pressroom') => "registered")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order", 'pressroom'),
			"param_name" => "order",
			"value" => array( __("descending", 'pressroom') => "DESC", __("ascending", 'pressroom') => "ASC")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Visible items", 'pressroom'),
			"param_name" => "visible",
			"value" => 4,
			"description" => __("Number of visible items in carousel", 'pressroom')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show social icons", 'pressroom'),
			"param_name" => "show_social_icons",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show twitter icon", 'pressroom'),
			"param_name" => "show_twitter",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0),
			"dependency" => Array('element' => "show_social_icons", 'value' => '1')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show facebook icon", 'pressroom'),
			"param_name" => "show_facebook",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0),
			"dependency" => Array('element' => "show_social_icons", 'value' => '1')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show linkedin icon", 'pressroom'),
			"param_name" => "show_linkedin",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0),
			"dependency" => Array('element' => "show_social_icons", 'value' => '1')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show skype icon", 'pressroom'),
			"param_name" => "show_skype",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0),
			"dependency" => Array('element' => "show_social_icons", 'value' => '1')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Google Plus icon", 'pressroom'),
			"param_name" => "show_googleplus",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0),
			"dependency" => Array('element' => "show_social_icons", 'value' => '1')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Instagram icon", 'pressroom'),
			"param_name" => "show_instagram",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0),
			"dependency" => Array('element' => "show_social_icons", 'value' => '1')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show count number next to post title", 'pressroom'),
			"param_name" => "count_number",
			"value" => array( __("No", 'pressroom') => 0, __("Yes", 'pressroom') => 1)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show comments number box next to post title", 'pressroom'),
			"param_name" => "show_comments_box",
			"value" => array( __("No", 'pressroom') => 0, __("Yes", 'pressroom') => 1)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show description", 'pressroom'),
			"param_name" => "show_description",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Profile button", 'pressroom'),
			"param_name" => "profile_button",
			"value" => array(__("No", 'pressroom') => 0, __("Yes", 'pressroom') => 1)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Autoplay", 'pressroom'),
			"param_name" => "autoplay",
			"value" => array(__("No", 'pressroom') => 0, __("Yes", 'pressroom') => 1)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Pause on hover", 'pressroom'),
			"param_name" => "pause_on_hover",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0),
			"dependency" => Array('element' => "autoplay", 'value' => '1')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Scroll", 'pressroom'),
			"param_name" => "scroll",
			"value" => 1,
			"description" => __("Number of items to scroll in one step", 'pressroom')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none", __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section")
		)
	);
	wpb_map( array(
		"name" => __("Authors Carousel", 'pressroom'),
		"base" => "pr_authors_carousel",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-authors-carousel",
		"category" => __('Pressroom', 'pressroom'),
		"params" => $params
	));
}
add_action("init", "pr_theme_authors_carousel_vc_init");
?>
