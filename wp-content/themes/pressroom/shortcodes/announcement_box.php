<?php
function pr_theme_announcement_box_shortcode($atts)
{
	extract(shortcode_atts(array(
		"header" => "",
		"header_expose" => "",
		"button_label" => "",
		"button_url" => "#",
		"button_size" => "medium",
		"button_color" => "",
		"button_custom_color" => "",
		"button_hover_color" => "",
		"button_hover_custom_color" => "",
		"button_text_color" => "",
		"button_hover_text_color" => "",
		"top_margin" => "page_margin_top_section"
	), $atts));
	
	$button_color = ($button_custom_color!="" ? $button_custom_color : $button_color);
	$button_hover_color = ($button_hover_custom_color!="" ? $button_hover_custom_color : $button_hover_color);
	
	$output = '<div class="announcement clearfix' . ($top_margin!="none" ? ' ' . $top_margin : '') . '">
					<ul class="columns no_width">
						<li class="column_left column">
							<div class="vertical_align">
								<div class="vertical_align_cell">
									' . ($header!="" ? '<h2>' . $header . '</h2>' : '')	. ($header_expose!="" ? '<h2 class="expose">' . $header_expose . '</h2>' : '') . '
								</div>
							</div>
						</li>';
	if($button_label!="")
		$output .= '<li class="column_right column">
						<div class="vertical_align">
							<div class="vertical_align_cell">
								<a title="' . esc_attr($button_label) . '" href="' . esc_url($button_url) . '" class="more active' . ' ' . $button_size . '">' . $button_label . '</a>
							</div>
						</div>
					</li>';
	$output .= '</ul>
			</div>';
	//<a' . ($button_color!="" || $button_text_color!="" ? ' style="' . ($button_color!="" ? 'background-color:' . $button_color . ';border-color:' . $button_color . ';' : '') . ($button_text_color!="" ? 'color:' . $button_text_color . ';': '') . '"' : '') . ($button_hover_color!="" || $button_hover_text_color!="" ? ' onMouseOver="' . ($button_hover_color!="" ? 'this.style.backgroundColor=\''.$button_hover_color.'\';this.style.borderColor=\''.$button_hover_color.'\';' : '' ) . ($button_hover_text_color!="" ? 'this.style.color=\''.$button_hover_text_color.'\';' : '' ) . '" onMouseOut="' . ($button_hover_color!="" ? 'this.style.backgroundColor=\''.$button_color.'\';this.style.borderColor=\''.$button_color.'\';' : '' ) . ($button_hover_text_color!="" ? 'this.style.color=\''.$button_text_color.'\';' : '') . '"' : '') . ' title="' . esc_attr($button_label) . '" href="' . esc_attr($button_url) . '" class="more active' . ' ' . $button_size . ($animation!='' ? ' animated_element animation-' . $animation . ((int)$animation_duration>0 && (int)$animation_duration!=600 ? ' duration-' . (int)$animation_duration : '') . ((int)$animation_delay>0 ? ' delay-' . (int)$animation_delay : '') : '') . '">' . $button_label . '</a>
	return $output;
}
add_shortcode("announcement_box", "pr_theme_announcement_box_shortcode");
//visual composer
$pr_colors_arr = array(__("Red", "js_composer") => "#ed1c24", __("Dark red", "js_composer") => "#c03427", __("Light red", "js_composer") => "#f37548", __("Dark blue", "js_composer") => "#3156a3", __("Blue", "js_composer") => "#0384ce", __("Light blue", "js_composer") => "#42b3e5", __("Black", "js_composer") => "#000000", __("Gray", "js_composer") => "#AAAAAA", __("Dark gray", "js_composer") => "#444444", __("Light gray", "js_composer") => "#CCCCCC", __("Green", "js_composer") => "#43a140", __("Dark green", "js_composer") => "#008238", __("Light green", "js_composer") => "#7cba3d", __("Orange", "js_composer") => "#f17800", __("Dark orange", "js_composer") => "#cb451b", __("Light orange", "js_composer") => "#ffa800", __("Turquoise", "js_composer") => "#0097b5", __("Dark turquoise", "js_composer") => "#006688", __("Turquoise", "js_composer") => "#00b6cc", __("Light turquoise", "js_composer") => "#00b6cc", __("Violet", "js_composer") => "#6969b3", __("Dark violet", "js_composer") => "#3e4c94", __("Light violet", "js_composer") => "#9187c4", __("White", "js_composer") => "#FFFFFF", __("Yellow", "js_composer") => "#fec110");
wpb_map( array(
	"name" => __("Announcement box", 'pressroom'),
	"base" => "announcement_box",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-announcement-box",
	"category" => __('Pressroom', 'pressroom'),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Header", 'pressroom'),
			"param_name" => "header",
			"value" => ""
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Header expose", 'pressroom'),
			"param_name" => "header_expose",
			"value" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Button label", 'pressroom'),
			"param_name" => "button_label",
			"value" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Button url", 'pressroom'),
			"param_name" => "button_url",
			"value" => ""
		),
		/*array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Button color", 'pressroom'),
			"param_name" => "button_color",
			"value" => array(__("Dark blue", 'pressroom') => "blue", __("Blue", 'pressroom') => "dark_blue", __("Light", 'pressroom') => "light")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("or pick custom button color", 'pressroom'),
			"param_name" => "custom_button_color",
			"value" => ""
		),*/
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Button size", 'pressroom'),
			"param_name" => "button_size",
			"value" => array(__("Big", 'pressroom') => "big", __("Medium", 'pressroom') => "medium", __("Small", 'pressroom') => "")
		),
        array(
            "type" => "dropdown",
            "heading" => __("Button color", "js_composer"),
            "param_name" => "button_color",
            "value" => $pr_colors_arr
        ),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("or pick custom button color", 'pressroom'),
			"param_name" => "button_custom_color",
			"value" => ""
		),
		array(
            "type" => "dropdown",
            "heading" => __("Button hover Color", "js_composer"),
            "param_name" => "button_hover_color",
            "value" => $pr_colors_arr
        ),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("or pick custom button hover color", 'pressroom'),
			"param_name" => "button_hover_custom_color",
			"value" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Button text color", 'pressroom'),
			"param_name" => "button_text_color",
			"value" => "#FFFFFF"
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Button Hover text color", 'pressroom'),
			"param_name" => "button_hover_text_color",
			"value" => "#ED1C24"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("Section (large)", 'pressroom') => "page_margin_top_section", __("Page (small)", 'pressroom') => "page_margin_top", __("None", 'pressroom') => "none")
		)
	)
));
?>
