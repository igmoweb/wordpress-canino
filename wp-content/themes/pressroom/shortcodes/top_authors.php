<?php
function pr_theme_top_authors_shortcode($atts)
{
	global $themename;
	extract(shortcode_atts(array(
		"items_per_page" => 4,
		"ids" => "",
		"top_margin" => "page_margin_top"
	), $atts));
	
	$ids = explode(",", $ids);
	if($ids[0]=="-" || $ids[0]=="")
	{
		unset($ids[0]);
		$ids = array_values($ids);
	}
	$args = array(
		'orderby'       => 'post_count', 
		'order'         => 'DESC', 
		'number'        => $items_per_page,
		'include'       => $ids,
		'who' => 'authors'
	);
	$authors_list = get_users($args);
	
	$output = '';
	if(count($authors_list))
		$output .= '<ul class="authors rating clearfix">';
	foreach($authors_list as $author)
	{
		if(count_user_posts($author->ID))
			$output .= '<li class="single-author">
				<a class="thumb" href="' . get_author_posts_url($author->ID) . '" title="' . esc_attr($author->display_name) . '">' . get_avatar($author->ID, 100) . '<span class="number animated_element" data-value="' . count_user_posts($author->ID) . '"></span></a>
				<div class="details">
					<h5><a href="' . get_author_posts_url($author->ID) . '" title="' . esc_attr($author->display_name) . '">' . $author->display_name . '</a></h5>
					<h6>' . ($author->roles[0]!="" ? strtoupper($author->roles[0]) : '&nbsp;') . '</h6>
				</div>
			</li>';
	}
	if(count($authors_list))
		$output .= '</ul>';
	return $output;
}
add_shortcode("pr_top_authors", "pr_theme_top_authors_shortcode");

//visual composer
function pr_theme_top_authors_vc_init()
{
	//get posts list
	$authors_list = get_users(array(
		'who' => 'authors'
	));
	$authors_array = array();
	$authors_array[__("All", 'pressroom')] = "-";
	foreach($authors_list as $author)
		$authors_array[$author->display_name . " (id:" . $author->ID . ")"] = $author->ID;
	
	$params = array(
		array(
			"type" => "dropdownmulti",
			"class" => "",
			"heading" => __("Display selected", 'pressroom'),
			"param_name" => "ids",
			"value" => $authors_array
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Authors count", 'pressroom'),
			"param_name" => "items_per_page",
			"value" => 4,
			"description" => __("Set 0 to display all.", 'pressroom')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("Page (small)", 'pressroom') => "page_margin_top", __("None", 'pressroom') => "none", __("Section (large)", 'pressroom') => "page_margin_top_section")
		)
	);
	wpb_map( array(
		"name" => __("Top authors", 'pressroom'),
		"base" => "pr_top_authors",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-top-authors",
		"category" => __('Pressroom', 'pressroom'),
		"params" => $params
	));
}
add_action("init", "pr_theme_top_authors_vc_init");
?>
