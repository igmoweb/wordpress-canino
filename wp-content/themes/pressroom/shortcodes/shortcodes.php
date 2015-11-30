<?php
global $pressroom_posts_array;
$pressroom_posts_array = array();
$count_posts = wp_count_posts();
if($count_posts->publish<100)
{
	$pressroom_posts_list = get_posts(array(
		'posts_per_page' => -1,
		'nopaging' => true,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_type' => 'post'
	));
	$pressroom_posts_array[__("All", 'pressroom')] = "-";
	foreach($pressroom_posts_list as $post)
		$pressroom_posts_array[$post->post_title . " (id:" . $post->ID . ")"] = $post->ID;
}

global $pressroom_pages_array;
$pressroom_pages_array = array();
$count_pages = wp_count_posts('page');
if($count_pages->publish<100)
{
	$pages_list = get_posts(array(
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_type' => 'page'
	));
	$pressroom_pages_array = array();
	$pressroom_pages_array[__("none", 'pressroom')] = "-";
	foreach($pages_list as $single_page)
		$pressroom_pages_array[$single_page->post_title . " (id:" . $single_page->ID . ")"] = $single_page->ID;
}

//slider
require_once(locate_template("shortcodes/slider.php"));
//blog 1 column
require_once(locate_template("shortcodes/blog_1_column.php"));
//blog 2 columns
require_once(locate_template("shortcodes/blog_2_columns.php"));
//blog 3 columns
require_once(locate_template("shortcodes/blog_3_columns.php"));
//blog big
require_once(locate_template("shortcodes/blog_big.php"));
//blog medium
require_once(locate_template("shortcodes/blog_medium.php"));
//blog small
require_once(locate_template("shortcodes/blog_small.php"));
//post
require_once(locate_template("shortcodes/single-post.php"));
//comments
require_once(locate_template("shortcodes/comments.php"));
//items_list
require_once(locate_template("shortcodes/items_list.php"));
//columns
require_once(locate_template("shortcodes/columns.php"));
//map
require_once(locate_template("shortcodes/map.php"));
//accordion
//require_once("accordion.php");
//nested tabs
//require_once("nested_tabs.php");
//post carousel
require_once(locate_template("shortcodes/post_carousel.php"));
//rank list
require_once(locate_template("shortcodes/rank_list.php"));
//authors list
require_once(locate_template("shortcodes/authors_list.php"));
//author single
require_once(locate_template("shortcodes/single-author.php"));
//top authors
require_once(locate_template("shortcodes/top_authors.php"));
//authors carousel
require_once(locate_template("shortcodes/authors_carousel.php"));
//about box
require_once(locate_template("shortcodes/about_box.php"));
//featured item
require_once(locate_template("shortcodes/featured_item.php"));
//post grid
require_once(locate_template("shortcodes/post_grid.php"));
//small slider
require_once(locate_template("shortcodes/small_slider.php"));
//announcement box
require_once(locate_template("shortcodes/announcement_box.php"));
//pricing table
if(is_plugin_active('css3_web_pricing_tables_grids/css3_web_pricing_tables_grids.php'))
	require_once(locate_template("shortcodes/pricing_table.php"));
//search box
require_once(locate_template("shortcodes/search_box.php"));

//row
vc_map( array(
	'name' => __( 'Row', 'js_composer' ),
	'base' => 'vc_row',
	'is_container' => true,
	'icon' => 'icon-wpb-row',
	'show_settings_on_create' => false,
	'category' => __( 'Content', 'js_composer' ),
	'description' => __( 'Place content elements inside the row', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Font Color', 'js_composer' ),
			'param_name' => 'font_color',
			'description' => __( 'Select font color', 'js_composer' ),
			'edit_field_class' => 'vc_col-md-6 vc_column'
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type", 'pressroom'),
			"param_name" => "type",
			"value" => array(__("Default", 'pressroom') => "",  __("Full width", 'pressroom') => "full_width", __("Blog grid container", 'pressroom') => "blog_grid"),
			"description" => __("Select row type", "pressroom")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none",  __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section"),
			"description" => __("Select top margin value for your row", "pressroom")
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'js_composer' ),
			'param_name' => 'css',
			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'group' => __( 'Design options', 'js_composer' )
		)
	),
	'js_view' => 'VcRowView'
) );

//column
$column_width_list = array(
	__('1 column - 1/12', 'js_composer') => '1/12',
	__('2 columns - 1/6', 'js_composer') => '1/6',
	__('3 columns - 1/4', 'js_composer') => '1/4',
	__('4 columns - 1/3', 'js_composer') => '1/3',
	__('5 columns - 5/12', 'js_composer') => '5/12',
	__('6 columns - 1/2', 'js_composer') => '1/2',
	__('7 columns - 7/12', 'js_composer') => '7/12',
	__('8 columns - 2/3', 'js_composer') => '2/3',
	__('9 columns - 3/4', 'js_composer') => '3/4',
	__('10 columns - 5/6', 'js_composer') => '5/6',
	__('11 columns - 11/12', 'js_composer') => '11/12',
	__('12 columns - 1/1', 'js_composer') => '1/1'
);
vc_map( array(
	'name' => __( 'Column', 'js_composer' ),
	'base' => 'vc_column',
	'is_container' => true,
	//"as_parent" => array('except' => 'vc_row'),
	'content_element' => false,
	'params' => array(
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Font Color', 'js_composer' ),
			'param_name' => 'font_color',
			'description' => __( 'Select font color', 'js_composer' ),
			'edit_field_class' => 'vc_col-md-6 vc_column'
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Column type", 'pressroom'),
			"param_name" => "type",
			"value" => array(__("Default", 'pressroom') => "",  __("Smart (sticky)", 'pressroom') => "pr_smart_column"),
			"dependency" => Array('element' => "width", 'value' => array_map('strval', array_values((array_slice($column_width_list, 0, -1)))))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none",  __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section"),
			"description" => __("Select top margin value for your column", "pressroom")
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'js_composer' ),
			'param_name' => 'css',
			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'group' => __( 'Design options', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Width', 'js_composer' ),
			'param_name' => 'width',
			'value' => $column_width_list,
			'group' => __( 'Width & Responsiveness', 'js_composer' ),
			'description' => __( 'Select column width.', 'js_composer' ),
			'std' => '1/1'
		),
		array(
			'type' => 'column_offset',
			'heading' => __('Responsiveness', 'js_composer'),
			'param_name' => 'offset',
			'group' => __( 'Width & Responsiveness', 'js_composer' ),
			'description' => __('Adjust column for different screen sizes. Control width, offset and visibility settings.', 'js_composer')
		)
	),
	'js_view' => 'VcColumnView'
) );

//separator
function pr_theme_vc_separator_pr($atts)
{
	extract(shortcode_atts(array(
		"style" => "default",
		"el_class" => "",
		"top_margin" => "none"
	), $atts));
	if($style=="default")
		$output = '<hr class="divider' . ($top_margin!="none" ? ' ' . $top_margin : '') . ($el_class!="" ? ' ' . $el_class : '') . '">';
	else
		$output = '<div class="divider_block clearfix' . ($top_margin!="none" ? ' ' . $top_margin : '') . ($el_class!="" ? ' ' . $el_class : '') . '"><hr class="divider first"><hr class="divider subheader_arrow"><hr class="divider last"></div>';
	return $output;
}
add_shortcode("vc_separator_pr", "pr_theme_vc_separator_pr");
/* Separator (Divider)
---------------------------------------------------------- */
vc_map( array(
	'name' => __( 'Separator', 'js_composer' ),
	'base' => 'vc_separator_pr',
	'icon' => 'icon-wpb-ui-separator',
	'show_settings_on_create' => true,
	'category' => __( 'Content', 'js_composer' ),
	'description' => __( 'Horizontal separator line', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style', 'js_composer' ),
			'param_name' => 'style',
			'value' => array(__("Default", 'pressroom') => "default", __("With gap", 'pressroom') => "gap"),
			'description' => __( 'Separator style.', 'js_composer' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none", __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section")
		)
	)
) );

//box_header
function pr_theme_box_header($atts)
{
	extract(shortcode_atts(array(
		"title" => "Sample Header",
		"type" => "h4",
		"class" => "",
		"bottom_border" => 1,
		"top_margin" => "none"
	), $atts));
	if(strpos($title, "{CUR_AUTHOR}")!==false)
	{
		$author = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
		$title = str_replace("{CUR_AUTHOR}", $author->display_name, $title);
	}
	return '<' . $type . ' class="box_header' . ($class!="" ? ' ' . $class : '') . ($top_margin!="none" ? ' ' . $top_margin : '') . '">' . do_shortcode($title) . '</' . $type . '>';
}
add_shortcode("box_header", "pr_theme_box_header");
//visual composer
wpb_map( array(
	"name" => __("Box header", 'pressroom'),
	"base" => "box_header",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-box-header",
	"category" => __('Pressroom', 'pressroom'),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title", 'pressroom'),
			"param_name" => "title",
			"value" => "Sample Header"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type", 'pressroom'),
			"param_name" => "type",
			"value" => array(__("H4", 'pressroom') => "h4",  __("H1", 'pressroom') => "h1", __("H2", 'pressroom') => "h2", __("H3", 'pressroom') => "h3", __("H5", 'pressroom') => "h5")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Bottom border", 'pressroom'),
			"param_name" => "bottom_border",
			"value" => array(__("yes", 'pressroom') => 1,  __("no", 'pressroom') => 0)
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Extra class name", 'pressroom'),
			"param_name" => "class",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none", __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section")
		)
	)
));

//dropcap
function pr_theme_dropcap($atts, $content)
{
	extract(shortcode_atts(array(
		"id" => "",
		"label" => "1",
		"label_background_color" => "",
		"custom_label_background_color" => "",
		"label_color" => "",
		"content_text_color" => "",
		"class" => "",
		"top_margin" => "none"
	), $atts));
	
	$label_background_color = ($custom_label_background_color!="" ? $custom_label_background_color : $label_background_color);
	return ($content_text_color!="" && $id!="" ? '<style type="text/css">#' . $id . ' p{color:' . $content_text_color . ';}</style>': '') . '<div' . ($id!="" ? ' id="' . $id . '"' : '') . ' class="dropcap' . ($top_margin!="none" ? ' ' . $top_margin : '') . ($class!="" ? ' '. $class : '') . '"><div class="dropcap_label"' . ($label_background_color!="" ? ' style="background-color:' . $label_background_color . ';"' : '') . '><h3' . ($label_color!="" ? ' style="color:' . $label_color . ';"' : '') . '>' . $label . '</h3></div>' . wpb_js_remove_wpautop($content) . '</div>';
}
add_shortcode("dropcap", "pr_theme_dropcap");
//visual composer
$mc_colors_arr = array(__("Dark blue", "js_composer") => "#3156a3", __("Blue", "js_composer") => "#0384ce", __("Light blue", "js_composer") => "#42b3e5", __("Black", "js_composer") => "#000000", __("Gray", "js_composer") => "#AAAAAA", __("Dark gray", "js_composer") => "#444444", __("Light gray", "js_composer") => "#CCCCCC", __("Green", "js_composer") => "#43a140", __("Dark green", "js_composer") => "#008238", __("Light green", "js_composer") => "#7cba3d", __("Orange", "js_composer") => "#f17800", __("Dark orange", "js_composer") => "#cb451b", __("Light orange", "js_composer") => "#ffa800", __("Red", "js_composer") => "#db5237", __("Dark red", "js_composer") => "#c03427", __("Light red", "js_composer") => "#f37548", __("Turquoise", "js_composer") => "#0097b5", __("Dark turquoise", "js_composer") => "#006688", __("Light turquoise", "js_composer") => "#00b6cc", __("Violet", "js_composer") => "#6969b3", __("Dark violet", "js_composer") => "#3e4c94", __("Light violet", "js_composer") => "#9187c4", __("White", "js_composer") => "#FFFFFF", __("Yellow", "js_composer") => "#fec110");
wpb_map( array(
	"name" => __("Dropcap text", 'pressroom'),
	"base" => "dropcap",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-dropcap",
	"category" => __('Pressroom', 'pressroom'),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Id", 'pressroom'),
			"param_name" => "id",
			"value" => "",
			"description" => __("Please provide unique id for each dropcap on the same page/post if you would like to have custom content color for each one", 'pressroom')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Label", 'pressroom'),
			"param_name" => "label",
			"value" => "1"
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content", 'pressroom'),
			"param_name" => "content",
			"value" => ""
		),
		array(
            "type" => "dropdown",
            "heading" => __("Label background color", "pressroom"),
            "param_name" => "label_background_color",
            "value" => $mc_colors_arr,
            "description" => __("Button color.", "js_composer")
        ),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("or pick custom label background color", 'pressroom'),
			"param_name" => "custom_label_background_color",
			"value" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Label text color", 'pressroom'),
			"param_name" => "label_color",
			"value" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content text color", 'pressroom'),
			"param_name" => "content_text_color",
			"value" => "",
			"description" => __("If you would like to use 'Content text color', you need to fill 'Id' field", 'pressroom')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Extra class name", 'pressroom'),
			"param_name" => "class",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none", __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section")
		)
	)
));

//read more
function pr_theme_read_more_button($atts)
{
	extract(shortcode_atts(array(
		"url" => "blog",
		"title" => __("READ MORE", 'pressroom'),
		"top_margin" => "none"
	), $atts));
	return '<a class="more' . ($top_margin!="none" ? ' ' . $top_margin : '') . '" href="' . esc_url($url) . '" title="' . esc_attr($title) . '">' . $title . '</a>';
}
add_shortcode("read_more_button", "pr_theme_read_more_button");
//visual composer
wpb_map( array(
	"name" => __("Read more button", 'pressroom'),
	"base" => "read_more_button",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-ui-button",
	"category" => __('Pressroom', 'pressroom'),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title", 'pressroom'),
			"param_name" => "title",
			"value" => __("READ MORE", 'pressroom')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Url", 'pressroom'),
			"param_name" => "url",
			"value" => "blog"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none", __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section")
		)
	)
));

//scroll top
function pr_theme_scroll_top($atts, $content)
{
	extract(shortcode_atts(array(
		"title" => "Scroll to top",
		"label" => "Top"
	), $atts));
	
	return '<a class="scroll_top" href="#top" title="' . esc_attr($title) . '">' . esc_attr($label) . '</a>';
}
add_shortcode("scroll_top", "pr_theme_scroll_top");
?>