<?php
//post
function pr_theme_about_box($atts, $content)
{
	extract(shortcode_atts(array(
		"title" => "",
		"subtitle" => "",
		"excerpt" => "",
		"text" => "",
		"icon" => "none",
		"top_margin" => "none"
	), $atts));
	
	$output = '<div class="clearfix' . ($top_margin!="none" ? ' ' . $top_margin : '') . ($icon!="none" ? ' item_content' : '') . '">';
	if($icon!="none")
		$output .= '<span class="features_icon ' . esc_attr($icon) . ' animated_element animation-scale"></span>';
	if($title!="")
		$output .= '<h1 class="about_title">' . $title . '</h1>';
	if($subtitle!="")
		$output .= '<h2 class="about_subtitle">' . $subtitle . '</h2>';
	if($excerpt!="")
		$output .= '<h3 class="page_margin_top">' . $excerpt . '</h3>';
	if($text!="")
		$output .= '<p class="text padding_top_0 page_margin_top">' . $text . '</p>';
	$output .= '</div>';
	return $output;
}
add_shortcode("about_box", "pr_theme_about_box");

//visual composer
function pr_theme_about_box_vc_init()
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
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title", 'pressroom'),
			"param_name" => "title",
			"value" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Subtitle", 'pressroom'),
			"param_name" => "subtitle",
			"value" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Excerpt", 'pressroom'),
			"param_name" => "excerpt",
			"value" => ""
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Text", 'pressroom'),
			"param_name" => "text",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => __("Icon", 'pressroom'),
			"param_name" => "icon",
			"value" => $icons
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
		"name" => __("About Box", 'pressroom'),
		"base" => "about_box",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-about-box",
		"category" => __('Pressroom', 'pressroom'),
		"params" => $params
	));
}
add_action("init", "pr_theme_about_box_vc_init");
?>
