<?php
function pr_theme_post_carousel_shortcode($atts)
{
	global $themename;
	extract(shortcode_atts(array(
		"type" => "horizontal",
		"kind" => "default",
		"items_per_page" => 4,
		"offset" => 0,
		"ids" => "",
		"category" => "",
		"post_format" => "",
		"order_by" => "title,menu_order",
		"order" => "ASC",
		"header_style" => "5",
		"visible" => 3,
		"post_details_layout" => "simple",
		"count_number" => 0,
		"show_comments_box" => 0,
		"show_post_excerpt" => 0,
		"read_more" => 0,
		"featured_image_size" => "default",
		"features_images_loop" => 1,
		"show_post_icon" => 1,
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
		'offset' => (int)$offset,
		//'nopaging' => true,
		'post_status' => 'publish',
		'category_name' => implode(",", $category),
		'orderby' => ($order_by=="views" || $order_by=="rate" ? 'meta_value_num' : implode(" ", explode(",", $order_by))), 
		'order' => $order
	);
	if($order_by=="views")
		$args['meta_key'] = 'post_views_count';
	if($order_by=="rate")
		$args['meta_key'] = $themename . "_review_average";
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
	$output = '';
	if(count($posts_list))
		$output .= '<div class="' . $type . '_carousel_container clearfix' . ($type=="horizontal" && $kind!="default" ? ' ' . $kind : '') . ($top_margin!="none" ? ' ' . $top_margin : '') . '"><ul class="blog' . ($type=="vertical" ? ' small' : ($kind=="big" ? ' big' : '')) . ' ' . $type . '_carousel visible-' . (int)$visible . ' autoplay-' . (int)$autoplay . ' pause_on_hover-' . (int)$pause_on_hover . ' scroll-' . (int)$scroll . '">';
	$i=0;
	global $post;
	$currentPost = $post;
	$category_filter_array = $category;
	foreach($posts_list as $post) 
	{
		setup_postdata($post);
		$output .= '<li class="post">
			<a href="' . get_permalink($post->ID) . '" title="' . esc_attr($post->post_title) . '" class="post_image clearfix">';
			if((int)$show_post_icon)
			{
				$is_review = get_post_meta($post->ID, $themename. "_is_review", true);
				$post_format = get_post_format($post->ID);
				require_once(locate_template("shortcodes/class/Post.php"));	
				$output .= (($is_review=="percentage" || $is_review=="points") && $post_format!="video" && $post_format!="gallery" ? '<span class="icon' . ($type=='vertical' ? ' review small">' : '"><span>' . get_post_meta($post->ID, $themename . "_review_average", true) . ($is_review=="percentage" ? '%' : '') . '</span>') . '</span>' : '') . ($post_format=="video" || $post_format=="gallery" ? '<span class="icon ' . $post_format . ($type=='vertical' ? ' small' : '') . '"></span>' : '');
			}
		$output .= get_the_post_thumbnail($post->ID, ($featured_image_size!="default" ? $featured_image_size : $themename . "-small-thumb") , array("alt" => get_the_title(), "title" => "")) .
			'</a>';
			if($type=="vertical")
				$output .= '<div class="post_content">';
			if((int)$show_comments_box)
				$comments_count = get_comments_number();
			$output .= '<h' . $header_style . ((int)$show_comments_box ? ' class="with_number clearfix"' : '') . '>' . ((int)$count_number ? '<span class="number">' . ($i+1) . '.</span>' : '') . '<a href="' . get_permalink($post->ID) . '" title="' . esc_attr($post->post_title) . '">' . $post->post_title . '</a>' . ((int)$show_comments_box ? '<a href="' . get_comments_link() . '" title="' . $comments_count . ' ' . ($comments_count==1 ? __('comment', 'pressroom') : __('comments', 'pressroom')) . '" class="comments_number">' . $comments_count . '<span class="arrow_comments"></span></a>' : '') . '</h' . $header_style . '>
			<ul class="post_details' . ($post_details_layout=="simple" ? ' simple' : '') . '">';
			$categories = get_the_category($post->ID);
			if(count($categories))
			{
				$primary_category = get_post_meta($post->ID, $themename. "_primary_category", true);
				$category_container_class = "category";
				if(isset($primary_category) && $primary_category!="-" && $primary_category!="")
				{
					$primary_category_object = get_category($primary_category);
					if(is_object($primary_category_object))
						$category_container_class .= ' container-category-' . $primary_category_object->term_id;
				}
				else if(count($categories)==1)
					$category_container_class .= ' container-category-' . $categories[0]->term_id;
				$output .= '<li class="' . esc_attr($category_container_class) . '">';
				if(isset($primary_category) && $primary_category!="-" && $primary_category!="" && is_object($primary_category_object))
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
						foreach($categories as $key=>$category)
						{
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
				else
				{
					foreach($categories as $key=>$category)
					{
						$output .= '<a class="category-' . $category->term_id . '" href="' . get_category_link($category->term_id) . '" ';
						if(empty($category->description))
							$output .= 'title="' . sprintf(__('View all posts filed under %s', 'pressroom'), $category->name) . '"';
						else
							$output .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
						$output .= '>' . $category->name . '</a>' . ($category != end($categories) ? ', ' : '');
					}
				}
				$output .= '</li>';
			}
			$output .= '<li class="date">' . date_i18n(get_option('date_format'), strtotime($post->post_date))/* . ' ' . get_the_time(get_option('time_format'))*/ . '</li>
			</ul>';
			if((int)$show_post_excerpt)
				$output .= apply_filters('the_excerpt', get_the_excerpt());
			if((int)$read_more)
				$output .= '<a title="' . __('Read more', 'pressroom') . '" href="' . get_permalink($post->ID) . '" class="read_more"><span class="arrow"></span><span>' . __('Read more', 'pressroom') . '</span></a>';
			if($type=="vertical")
				$output .= '</div>';
		$output .= '</li>';
		$i++;
	}
	$post = $currentPost;
	
	if(count($posts_list))
		$output .= '</ul></div>';
	return $output;
}
add_shortcode("pr_post_carousel", "pr_theme_post_carousel_shortcode");

//visual composer
function pr_theme_post_carousel_vc_init()
{
	//get posts list
	global $pressroom_posts_array;

	//get categories
	$post_categories = get_terms("category");
	$post_categories_array = array();
	$post_categories_array[__("All", 'pressroom')] = "-";
	foreach($post_categories as $post_category)
		$post_categories_array[$post_category->name] =  $post_category->slug;
		
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
	
	//image sizes
	$image_sizes_array = array();
	$image_sizes_array[__("Default", 'pressroom')] = "default";
	global $_wp_additional_image_sizes;
	foreach(get_intermediate_image_sizes() as $s) 
	{
		if(isset($_wp_additional_image_sizes[$s])) 
		{
			$width = intval($_wp_additional_image_sizes[$s]['width']);
			$height = intval($_wp_additional_image_sizes[$s]['height']);
		}
		else
		{
			$width = get_option($s.'_size_w');
			$height = get_option($s.'_size_h');
		}
		$image_sizes_array[$s . " (" . $width . "x" . $height . ")"] = $s;
	}
	$params = array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type", 'pressroom'),
			"param_name" => "type",
			"value" => array(__("Horizontal", 'pressroom') => "horizontal", __("Vertical", 'pressroom') => "vertical")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Kind", 'pressroom'),
			"param_name" => "kind",
			"value" => array(__("Default", 'pressroom') => "default", __("Big", 'pressroom') => "big",  __("Small", 'pressroom') => "small"),
			"dependency" => Array('element' => "type", 'value' => 'horizontal')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Post count", 'pressroom'),
			"param_name" => "items_per_page",
			"value" => 4,
			"description" => __("Set -1 to display all.", 'pressroom')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Offset", 'pressroom'),
			"param_name" => "offset",
			"value" => 0,
			"description" => __("Number of post to displace or pass over.", 'pressroom')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Featured image size", 'pressroom'),
			"param_name" => "featured_image_size",
			"value" => $image_sizes_array
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
			"value" => $post_categories_array
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
			"value" => array(__("Title, menu order", 'pressroom') => "title,menu_order", __("Menu order", 'pressroom') => "menu_order", __("Date", 'pressroom') => "date", __("Post views", 'pressroom') => "views", __("Comment count", 'pressroom') => "comment_count", __("Rate", 'pressroom') => "rate", __("Random", 'pressroom') => "rand")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order", 'pressroom'),
			"param_name" => "order",
			"value" => array( __("descending", 'pressroom') => "DESC", __("ascending", 'pressroom') => "ASC")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Header style", 'pressroom'),
			"param_name" => "header_style",
			"value" => array( __("default", 'pressroom') => "5", __("big", 'pressroom') => "2")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Visible items", 'pressroom'),
			"param_name" => "visible",
			"value" => 3,
			"description" => __("Number of visible items in carousel", 'pressroom')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Post details layout", 'pressroom'),
			"param_name" => "post_details_layout",
			"value" => array( __("Simple", 'pressroom') => 'simple', __("Big", 'pressroom') => 'big')
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
			"heading" => __("Show post excerpt", 'pressroom'),
			"param_name" => "show_post_excerpt",
			"value" => array(__("No", 'pressroom') => 0, __("Yes", 'pressroom') => 1)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Read more button", 'pressroom'),
			"param_name" => "read_more",
			"value" => array(__("No", 'pressroom') => 0, __("Yes", 'pressroom') => 1)
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
		/*array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Effect", 'pressroom'),
			"param_name" => "effect",
			"value" => array(
				__("scroll", 'pressroom') => "scroll", 
				__("none", 'pressroom') => "none", 
				__("directscroll", 'pressroom') => "directscroll",
				__("fade", 'pressroom') => "_fade",
				__("crossfade", 'pressroom') => "crossfade",
				__("cover", 'pressroom') => "cover",
				__("uncover", 'pressroom') => "uncover"
			)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Sliding easing", 'pressroom'),
			"param_name" => "easing",
			"value" => array(
				__("swing", 'pressroom') => "swing", 
				__("linear", 'pressroom') => "linear", 
				__("easeInQuad", 'pressroom') => "easeInQuad",
				__("easeOutQuad", 'pressroom') => "easeOutQuad",
				__("easeInOutQuad", 'pressroom') => "easeInOutQuad",
				__("easeInCubic", 'pressroom') => "easeInCubic",
				__("easeOutCubic", 'pressroom') => "easeOutCubic",
				__("easeInOutCubic", 'pressroom') => "easeInOutCubic",
				__("easeInQuart", 'pressroom') => "easeInQuart",
				__("easeOutQuart", 'pressroom') => "easeOutQuart",
				__("easeInOutQuart", 'pressroom') => "easeInOutQuart",
				__("easeInSine", 'pressroom') => "easeInSine",
				__("easeOutSine", 'pressroom') => "easeOutSine",
				__("easeInOutSine", 'pressroom') => "easeInOutSine",
				__("easeInExpo", 'pressroom') => "easeInExpo",
				__("easeOutExpo", 'pressroom') => "easeOutExpo",
				__("easeInOutExpo", 'pressroom') => "easeInOutExpo",
				__("easeInQuint", 'pressroom') => "easeInQuint",
				__("easeOutQuint", 'pressroom') => "easeOutQuint",
				__("easeInOutQuint", 'pressroom') => "easeInOutQuint",
				__("easeInCirc", 'pressroom') => "easeInCirc",
				__("easeOutCirc", 'pressroom') => "easeOutCirc",
				__("easeInOutCirc", 'pressroom') => "easeInOutCirc",
				__("easeInElastic", 'pressroom') => "easeInElastic",
				__("easeOutElastic", 'pressroom') => "easeOutElastic",
				__("easeInOutElastic", 'pressroom') => "easeInOutElastic",
				__("easeInBack", 'pressroom') => "easeInBack",
				__("easeOutBack", 'pressroom') => "easeOutBack",
				__("easeInOutBack", 'pressroom') => "easeInOutBack",
				__("easeInBounce", 'pressroom') => "easeInBounce",
				__("easeOutBounce", 'pressroom') => "easeOutBounce",
				__("easeInOutBounce", 'pressroom') => "easeInOutBounce"
			)
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Sliding transition speed (ms)", 'pressroom'),
			"param_name" => "duration",
			"value" => 500
		),*/
		/*array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Slide on touch", 'pressroom'),
			"param_name" => "ontouch",
			"value" => array(__("No", 'pressroom') => 0, __("Yes", 'pressroom') => 1)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Slide on mouse", 'pressroom'),
			"param_name" => "onmouse",
			"value" => array(__("No", 'pressroom') => 0, __("Yes", 'pressroom') => 1)
		),*/
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none", __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section")
		)
	);
	wpb_map( array(
		"name" => __("Post Carousel", 'pressroom'),
		"base" => "pr_post_carousel",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-carousel",
		"category" => __('Pressroom', 'pressroom'),
		"params" => $params
	));
}
add_action("init", "pr_theme_post_carousel_vc_init");
?>
