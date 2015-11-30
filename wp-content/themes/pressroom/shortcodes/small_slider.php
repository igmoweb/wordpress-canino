<?php
function pr_theme_small_slider_shortcode($atts)
{
	global $themename;
	extract(shortcode_atts(array(
		"id" => "small_slider",
		"items_per_page" => -1,
		"ids" => "",
		"category" => "",
		"post_format" => "",
		"order_by" => "title,menu_order",
		"order" => "ASC",
		"show_post_icon" => 1,
		"show_post_categories" => 1,
		"show_post_date" => 1,
		"control_boxes" => 1,
		"autoplay" => 0,
		"interval" => 5000,
		"pause_on_hover" => 1,
		"only_on_mobile" => 0,
		"top_margin" => "none"
	), $atts));
	
	$ids = explode(",", $ids);
	if($ids[0]=="-" || $ids[0]=="")
	{
		unset($ids[0]);
		$ids = array_values($ids);
	}
	$category = explode(",", $category);
	if($category[0]=="-" || $category[0]=="")
	{
		unset($category[0]);
		$category = array_values($category);
	}
	$post_format = explode(",", $post_format);
	if($post_format[0]=="-" || $post_format[0]=="")
	{
		unset($post_format[0]);
		$post_format = array_values($post_format);
	}
	$args = array( 
		'include' => $ids,
		'post_type' => 'post',
		'posts_per_page' => $items_per_page,
		'post_status' => 'publish',
		'category' => implode(",", $category),
		'orderby' => ($order_by=="views" ? 'meta_value_num' : implode(" ", explode(",", $order_by))), 
		'order' => $order
	);
	if($items_per_page==-1)
		$args['nopaging'] = true;
	if($order_by=="views")
		$args['meta_key'] = 'post_views_count';
	if(count($post_format))
	{
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => $post_format
			)
		);
	}
	$posts_list = get_posts($args);
	
	$output = "";
	if((int)$only_on_mobile)
		$output .= '<div class="slider_mobile_view' . ($top_margin!="none" ? ' ' . $top_margin : '') . '">';
	$output .= '<ul class="small_slider ' . $id . ' id-' . $id . ' autoplay-' . $autoplay . ' interval-' . $interval . ' pause_on_hover-' . $pause_on_hover . /*((int)$ontouch ? ' ontouch' : '') . ((int)$onmouse ? ' onmouse' : '') .*/ (!(int)$only_on_mobile && $top_margin!="none" ? ' ' . $top_margin : '') . '">';
	$category_filter_array = $category;
	foreach($posts_list as $post) 
	{
		$output .= '<li class="slide"><a href="' . get_permalink($post->ID) . '" title="' . esc_attr($post->post_title) . '">';		
		if((int)$show_post_icon)
		{
			$is_review = get_post_meta($post->ID, $themename. "_is_review", true);
			$post_format = get_post_format($post->ID);
			require_once(locate_template("shortcodes/class/Post.php"));	
			$output .= (($is_review=="percentage" || $is_review=="points") && $post_format!="video" && $post_format!="gallery" ? '<span class="icon"><span>' . get_post_meta($post->ID, $themename . "_review_average", true) . ($is_review=="percentage" ? '%' : '') . '</span></span>' : '') . ($post_format=="video" || $post_format=="gallery" ? '<span class="icon ' . $post_format . '"></span>' : '');
		}
		$output .= 	get_the_post_thumbnail($post->ID, "small-slider-thumb", array("alt" => get_the_title(), "title" => "")) . '</a>';
		$output .= '<div class="slider_content_box">';
		if((int)$show_post_categories || (int)$show_post_date)
			$output .= '<ul class="post_details simple">';
		if((int)$show_post_categories)
		{
			$post_categories = wp_get_post_categories($post->ID);
			if(count($post_categories))
			{
				$output .= '<li class="category">';
				$primary_category = get_post_meta($post->ID, $themename. "_primary_category", true);
				if(isset($primary_category) && $primary_category!="-" && $primary_category!="")
				{
					$primary_category_object = get_category($primary_category);
					if(is_object($primary_category_object))
					{
						$additional_categories = array();
						if(count($category_filter_array))
						{
							$found = false;
							$additional_categories = array();
							foreach((array)$category_filter_array as $category_filter)
							{
								if($category_filter==$primary_category_object->slug)
								{
									$found = true;
									$additional_categories = array();
									break;
								}
								else
									$additional_categories[] = $category_filter;
							}
						}
						$output .= '<a class="category-' . $primary_category_object->term_id . '" href="' . get_category_link($primary_category) . '" ';
						if(empty($primary_category_object->description))
							$output .= 'title="' . sprintf(__('View all posts filed under %s', 'pressroom'), $primary_category_object->name) . '"';
						else
							$output .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $primary_category_object->description, $primary_category_object))) . '"';
						$output .= '>' . $primary_category_object->name . '</a>';
						if(count($additional_categories))
						{
							foreach($post_categories as $key=>$post_category)
							{
								$category = get_category($post_category);
								if(in_array($category->slug, $additional_categories))
								{
									$output .= ', <a class="category-' . $category->term_id . '" href="' . get_category_link($category->term_id) . '" ';
									if(empty($category->description))
										$output .= 'title="' . sprintf(__('View all posts filed under %s', 'pressroom'), $category->name) . '"';
									else
										$output .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
									$output .= '>' . $category->name . '</a>';
								}
							}
						}
					}
				}
				else
				{
					foreach($post_categories as $key=>$post_category)
					{	
						$category = get_category($post_category);
						$output .= '<a class="category-' . $category->term_id . '" href="' . get_category_link($category->term_id) . '" ';
						if(empty($category->description))
							$output .= 'title="' . sprintf(__('View all posts filed under %s', 'pressroom'), $category->name) . '"';
						else
							$output .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
						$output .= '>' . $category->name . '</a>' . ($post_category != end($post_categories) ? ', ' : '');
					}
				}
				$output .= '</li>';
			}
		}
		if((int)$show_post_date)
			$output .= '	<li class="date">' . date_i18n(get_option('date_format'), strtotime($post->post_date)) . '</li>';
		if((int)$show_post_categories || (int)$show_post_date)
			$output .= '</ul>';
		$output .= '<h2><a href="' . get_permalink($post->ID) . '" title="' . esc_attr($post->post_title) . '">' . $post->post_title . '</a></h2>
			<p class="clearfix">' . $post->post_excerpt . '</p>
		</div></li>';
	}
	$output .= '</ul>';
	if((int)$control_boxes)
		$output .= '<div id="' . $id . '" class="slider_posts_list_container small"></div>';
	if((int)$only_on_mobile)
		$output .= '</div>';
	return $output;
}
add_shortcode("small_slider", "pr_theme_small_slider_shortcode");

//visual composer
function pr_theme_small_slider_vc_init()
{
	$params = array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Id", 'pressroom'),
			"param_name" => "id",
			"value" => "slider",
			"description" => __("Please provide unique id for each slider on the same page/post", 'pressroom')
		)
	);
	
	//get posts list
	global $pressroom_posts_array;

	//get posts categories list
	$posts_categories = get_terms("category");
	$posts_categories_array = array();
	$posts_categories_array[__("All", 'pressroom')] = "-";
	foreach($posts_categories as $posts_category)
		$posts_categories_array[$posts_category->slug] =  $posts_category->term_id;
		
	//get post formats
	$post_formats_array = array();
	$post_formats_array[__("All", 'pressroom')] = "-";
	if(current_theme_supports('post-formats')) 
	{
		$post_formats = get_theme_support('post-formats');
		
		if(is_array($post_formats[0]))
		{
			foreach($post_formats[0] as $post_format)
				$post_formats_array[$post_format] =  "post-format-" . $post_format;
		}
	}
	
	$params = array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Id", 'pressroom'),
			"param_name" => "id",
			"value" => "small_slider",
			"description" => __("Please provide unique id for each slider on the same page/post", 'pressroom')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Post count", 'pressroom'),
			"param_name" => "items_per_page",
			"value" => -1,
			"description" => __("Set -1 to display all.", 'pressroom')
		),
		array(
			"type" => (count($pressroom_posts_array) ? "dropdownmulti" : "textfield"),
			"class" => "",
			"heading" => __("Display selected", 'pressroom'),
			"param_name" => "ids",
			"value" => (count($pressroom_posts_array) ? $pressroom_posts_array : ''),
			"description" => (count($pressroom_posts_array) ? '' : __("Please provide post ids separated with commas, to display only selected posts", 'pressroom'))
		),
		array(
			"type" => "dropdownmulti",
			"class" => "",
			"heading" => __("Display from Category", 'pressroom'),
			"param_name" => "category",
			"value" => $posts_categories_array
		),
		array(
			"type" => "dropdownmulti",
			"class" => "",
			"heading" => __("Display by post format", 'pressroom'),
			"param_name" => "post_format",
			"value" => $post_formats_array
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order by", 'pressroom'),
			"param_name" => "order_by",
			"value" => array(__("Title, menu order", 'pressroom') => "title,menu_order", __("Menu order", 'pressroom') => "menu_order", __("Date", 'pressroom') => "date", __("Post views", 'pressroom') => "views", __("Comment count", 'pressroom') => "comment_count", __("Random", 'pressroom') => "rand")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order", 'pressroom'),
			"param_name" => "order",
			"value" => array(__("ascending", 'pressroom') => "ASC", __("descending", 'pressroom') => "DESC")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show post format icon on featured image", 'pressroom'),
			"param_name" => "show_post_icon",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show post categories", 'pressroom'),
			"param_name" => "show_post_categories",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show post date", 'pressroom'),
			"param_name" => "show_post_date",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Display control boxes under slider", 'pressroom'),
			"param_name" => "control_boxes",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Autoplay", 'pressroom'),
			"param_name" => "autoplay",
			"value" => array(__("No", 'pressroom') => 0, __("Yes", 'pressroom') => 1),
			"dependency" => Array('element' => "control_boxes", 'value' => '0')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Slide interval", 'pressroom'),
			"param_name" => "interval",
			"value" => 5000,
			"dependency" => Array('element' => "autoplay", 'value' => '1')
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
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Dsiplay slider only on mobile views/resolutions", 'pressroom'),
			"param_name" => "only_on_mobile",
			"value" => array(__("No", 'pressroom') => 0, __("Yes", 'pressroom') => 1)
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
		"name" => __("Small Slider", 'pressroom'),
		"base" => "small_slider",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-small-slider",
		"category" => __('Pressroom', 'pressroom'),
		"params" => $params
	));
}
add_action("init", "pr_theme_small_slider_vc_init");
?>
