<?php
function pr_theme_search_box_shortcode($atts)
{
	global $themename;
	extract(shortcode_atts(array(
		"show_box_header" => 1,
		"box_header_label" => "Search Results For '{SEARCH_TEXT}'",
		"placeholder" => "Search...",
		"submit_label" => "SEARCH",
		"top_margin" => "none"
	), $atts));
	
	$output = '<div class="vc_row wpb_row vc_row-fluid">';
	if((int)$show_box_header)
		$output .= '<h4 class="box_header' . ($top_margin!="none" ? ' ' . $top_margin : '') . '">' . str_replace("{SEARCH_TEXT}", (isset($_GET["s"]) ? $_GET["s"] : ""), $box_header_label) . '</h4>';
	$output .= '<form method="get" action="' . get_home_url() .'" class="search_form_page' . (!(int)$show_box_header && $top_margin!="none" ? ' ' . $top_margin : ((int)$show_box_header ? ' page_margin_top' : '')) . '">
		<input class="text_input" name="s" type="text" value="' . esc_attr((isset($_GET["s"]) ? $_GET["s"] : "")) . '" placeholder="' . esc_attr($placeholder) . '">
		<input type="submit" value="' . esc_attr($submit_label) . '" class="more active margin_top_10">
	</form></div>';
	return $output;
}
add_shortcode("pr_search_box", "pr_theme_search_box_shortcode");

//visual composer
function pr_theme_search_box_vc_init()
{
	$params = array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show box header", 'pressroom'),
			"param_name" => "show_box_header",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Box header label", 'pressroom'),
			"param_name" => "box_header_label",
			"value" => "Search Results For '{SEARCH_TEXT}'",
			"dependency" => Array('element' => "show_box_header", 'value' => '1')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Placeholder", 'pressroom'),
			"param_name" => "placeholder",
			"value" => "Search..."
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Submit label", 'pressroom'),
			"param_name" => "submit_label",
			"value" => "SEARCH"
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
		"name" => __("Search Box", 'pressroom'),
		"base" => "pr_search_box",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-search-box",
		"category" => __('Pressroom', 'pressroom'),
		"params" => $params
	));
}
add_action("init", "pr_theme_search_box_vc_init");
?>
