<?php
//slider
function pr_theme_slider($atts)
{
	//global $theme_options;
	global $themename;
	extract(shortcode_atts(array(
		"id" => "slider",
		"image_size" => "default",
		"items_per_page" => -1,
		"ids" => "",
		"category" => "",
		"order_by" => "title,menu_order",
		"order" => "ASC",
		"show_post_categories" => 1,
		"show_post_date" => 1,
		"control_boxes" => 1,
		"autoplay" => 0,
		"interval" => 5000,
		"pause_on_hover" => 1,
		/*"scroll" => 1,
		"effect" => "scroll",
		"easing" => "swing",
		"duration" => 500,*/
		"top_margin" => "none"
	), $atts));
	//$images = $slider_images;
	
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
	$posts_list = get_posts($args);
	if(is_rtl())
	{
		$posts_list = array_reverse($posts_list);
	}
	
	$output = '<ul class="slider ' . $id . ' id-' . $id . ' autoplay-' . $autoplay . ' interval-' . $interval . ' pause_on_hover-' . $pause_on_hover /*. ((int)$ontouch ? ' ontouch' : '') . ((int)$onmouse ? ' onmouse' : '')*/ . ($top_margin!="none" ? ' ' . $top_margin : '') . '">';
	/*$images = explode(',', $images);
	$i=0;
	foreach($images as $attach_id)
	{
		$attachment = get_posts(array('p' => $attach_id, 'post_type' => 'attachment'));
		$output .= '<li class="slide"><img src="' . $attachment[0]->guid . '" alt="img">&nbsp;</li>';
		$i++;
	}*/
	$category_filter_array = $category;
	foreach($posts_list as $post) 
	{
		$output .= '<li class="slide">' . get_the_post_thumbnail($post->ID, ($image_size!="default" ? $image_size : "slider-thumb"), array("alt" => get_the_title(), "title" => ""));
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
		$output .= '<div class="slider_posts_list_container"></div>';
	return $output;
}
add_shortcode("slider", "pr_theme_slider");

//visual composer
function pr_theme_slider_vc_init()
{
	/*class WPBakeryShortCode_Slider extends WPBakeryShortCode {
		public function content( $atts, $content = null ) {
			return theme_slider($atts);
		}
	   public function singleParamHtmlHolder($param, $value) {
		   global $themename;
			$output = '';
			// Compatibility fixes
			$old_names = array('yellow_message', 'blue_message', 'green_message', 'button_green', 'button_grey', 'button_yellow', 'button_blue', 'button_red', 'button_orange');
			$new_names = array('alert-block', 'alert-info', 'alert-success', 'btn-success', 'btn', 'btn-info', 'btn-primary', 'btn-danger', 'btn-warning');
			$value = str_ireplace($old_names, $new_names, $value);
			//$value = __($value, "js_composer");
			//
			$param_name = isset($param['param_name']) ? $param['param_name'] : '';
			$type = isset($param['type']) ? $param['type'] : '';
			$class = isset($param['class']) ? $param['class'] : '';

			if ( isset($param['holder']) == true && $param['holder'] !== 'hidden' ) {
				$output .= '<'.$param['holder'].' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '">'.$value.'</'.$param['holder'].'>';
			}
			if($param_name == 'slider_images') {
				$images_ids = empty($value) ? array() : explode(',', trim($value));
				$output .= '<ul class="attachment-thumbnails'.( empty($images_ids) ? ' image-exists' : '' ).'" data-name="' . $param_name . '">';
				foreach($images_ids as $image) {
					$img = wpb_getImageBySize(array( 'attach_id' => (int)$image, 'thumb_size' => $themename . '-small-thumb' ));
					$output .= ( $img ? '<li>'.$img['thumbnail'].'</li>' : '<li><img width="150" height="150" test="'.$image.'" src="' . WPBakeryVisualComposer::getInstance()->assetURL('vc/blank.gif') . '" class="attachment-thumbnail" alt="" title="" /></li>');
				}
				$output .= '</ul>';
				$output .= '<a href="#" class="column_edit_trigger' . ( !empty($images_ids) ? ' image-exists' : '' ) . '">' . __( 'Add images', 'js_composer' ) . '</a>';

			}
			return $output;
		}
	}*/
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
	$image_sizes_array[__("Full size (originally uploaded)", 'pressroom')] = "full";
	$params = array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Id", 'pressroom'),
			"param_name" => "id",
			"value" => "slider",
			"description" => __("Please provide unique id for each slider on the same page/post", 'pressroom')
		)/*,
		array(
			"type" => "attach_images",
			"class" => "",
			"heading" => __("Images", 'pressroom'),
			"param_name" => "slider_images",
			"value" => ""
		)*/
	);
	/*for($i=0; $i<30; $i++)
	{
		$params[] = array(
			"type" => "textfield",
			"heading" => __("Image title", 'pressroom') . " " . ($i+1),
			"param_name" => "image_title" . $i,
			"value" => "",
			"dependency" => Array('element' => "images", 'not_empty' => true)
		);
		$params[] = array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Image subtitle", 'pressroom') . " " . ($i+1),
			"param_name" => "image_subtitle" . $i,
			"value" => "",
			"dependency" => Array('element' => "images", 'not_empty' => true)
		);
		$params[] = array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Image url", 'pressroom') . " " . ($i+1),
			"param_name" => "image_url" . $i,
			"value" => "",
			"dependency" => Array('element' => "images", 'not_empty' => true)
		);
	}*/
	//get posts list
	global $pressroom_posts_array;

	//get posts categories list
	$posts_categories = get_terms("category");
	$posts_categories_array = array();
	$posts_categories_array[__("All", 'pressroom')] = "-";
	foreach($posts_categories as $posts_category)
		$posts_categories_array[$posts_category->slug] =  $posts_category->term_id;
	
	$params = array_merge($params, array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Image size", 'pressroom'),
			"param_name" => "image_size",
			"value" => $image_sizes_array
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
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Order by", 'pressroom'),
			"param_name" => "order_by",
			"value" => array(__("Title, menu order", 'pressroom') => "title,menu_order", __("Menu order", 'pressroom') => "menu_order", __("Date", 'pressroom') => "date",  __("Post views", 'pressroom') => "views", __("Comment count", 'pressroom') => "comment_count", __("Random", 'pressroom') => "rand")
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
			"heading" => __("Order", 'pressroom'),
			"param_name" => "order",
			"value" => array(__("ascending", 'pressroom') => "ASC", __("descending", 'pressroom') => "DESC")
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
		/*array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Scroll", 'pressroom'),
			"param_name" => "scroll",
			"value" => 1,
			"description" => __("Number of items to scroll in one step", 'pressroom')
		),*/
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
			"value" => 750
		),*/
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none", __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section")
		)
	));
	wpb_map( array(
		"name" => __("Slider", 'pressroom'),
		"base" => "slider",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-slider",
		"category" => __('Pressroom', 'pressroom'),
		"params" => $params
	));
}
add_action("init", "pr_theme_slider_vc_init");
?>
