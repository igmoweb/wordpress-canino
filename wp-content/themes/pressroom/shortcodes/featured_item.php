<?php
//post
function pr_theme_featured_item($atts, $content)
{
	extract(shortcode_atts(array(
		"icon" => "",
		"title" => "",
		"type" => "h3",
		"top_margin" => "none"
	), $atts));
	
	$output = "";
	if($top_margin!="none")
		$output .= '<div class="' . $top_margin . '">';
	$output .= '<div class="item_content clearfix">';
			if($icon!="none")
				$output .= '<span title="' . esc_attr($title) . '" class="features_icon ' . esc_attr($icon) . ' animated_element animation-scale"></span>';
			if($title!="" || $content!="")
			{
				$output .= '<div class="text">';
				if($title!="")
					$output .= '<' . $type . '>' . $title . '</' . $type . '>';
				if($content!="")
					$output .= '<p>' . $content . '</p>';
				$output .= '</div>';
			}
	$output .= '</div>';
	if($top_margin!="none")
		$output .= '</div>';
	return $output;
}
add_shortcode("featured_item", "pr_theme_featured_item");

//visual composer
function pr_theme_featured_item_vc_init()
{
	$icons = array(
		"none",
		"app",
		"calendar",
		"chart",
		"chat",
		"clock",
		"database",
		"document",
		"envelope",
		"faq",
		"graph",
		"image",
		"laptop",
		"magnifier",
		"mobile",
		"not_found",
		"pin",
		"printer",
		"quote",
		"screen",
		"speaker",
		"video"
	);
	$params = array(
		array(
			"type" => "dropdown",
			"heading" => __("Icon", 'pressroom'),
			"param_name" => "icon",
			"value" => $icons
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title", 'pressroom'),
			"param_name" => "title",
			"value" => ""
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Text", 'pressroom'),
			"param_name" => "content",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type", 'pressroom'),
			"param_name" => "type",
			"value" => array(__("H3", 'pressroom') => "h3",  __("H1", 'pressroom') => "h1", __("H2", 'pressroom') => "h2", __("H4", 'pressroom') => "h4", __("H5", 'pressroom') => "h5")
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
		"name" => __("Featured Item", 'pressroom'),
		"base" => "featured_item",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-featured-item",
		"category" => __('Pressroom', 'pressroom'),
		"params" => $params
	));
}
add_action("init", "pr_theme_featured_item_vc_init");
?>
