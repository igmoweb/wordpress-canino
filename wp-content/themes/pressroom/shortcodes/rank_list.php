<?php
function pr_theme_rank_list_shortcode($atts)
{
	global $themename;
	extract(shortcode_atts(array(
		"type" => "most_read",
		"items_per_page" => 4,
		"ids" => "",
		"category" => "",
		"featured_image_size" => "default",
		"show_post_icon" => 1,
		"show_post_categories" => 1,
		"show_post_date" => 1,
		"top_margin" => "page_margin_top"
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
	$args = array( 
		'include' => $ids,
		'post_type' => 'post',
		'posts_per_page' => $items_per_page,
		//'nopaging' => true,
		'post_status' => 'publish',
		'category' => implode(",", $category),
		'orderby' => ($type=="views" ? 'meta_value_num' : implode(" ", explode(",", $type)))
	);
	if($type=="views")
		$args['meta_key'] = 'post_views_count';
	$posts_list = get_posts($args);
	$output = '';
	if(count($posts_list))
		$output .= '<ul class="blog rating clearfix' . ($top_margin!="none" ? ' ' . $top_margin : '') . '">';
	$i=0;
	$category_filter_array = $category;
	foreach($posts_list as $post) 
	{
		if(($type=="views" && getPostViews($post->ID)>0) || ($type=="comment_count" && get_comments_number($post->ID)>0))
		{
			$output .= '<li class="post">';
			if($i==0)
			{
				$output .= '<a href="' . get_permalink($post->ID) . '" title="' . esc_attr($post->post_title) . '">';
				if((int)$show_post_icon)
				{
					$is_review = get_post_meta($post->ID, $themename. "_is_review", true);
					$post_format = get_post_format($post->ID);
					require_once(locate_template("shortcodes/class/Post.php"));	
					$output .= (($is_review=="percentage" || $is_review=="points") && $post_format!="video" && $post_format!="gallery" ? '<span class="icon"><span>' . get_post_meta($post->ID, $themename . "_review_average", true) . ($is_review=="percentage" ? '%' : '') . '</span></span>' : '') . ($post_format=="video" || $post_format=="gallery" ? '<span class="icon ' . $post_format . ($type=='vertical' ? ' small' : '') . '"></span>' : '');
				}
				$output .= get_the_post_thumbnail($post->ID, ($featured_image_size!="default" ? $featured_image_size : "blog-post-thumb-medium") , array("alt" => get_the_title(), "title" => "")) .
				'</a>';
			}
			$output .= '<div class="post_content">
				<span class="number animated_element" data-value="' . ($type=="views" ? getPostViews($post->ID) : get_comments_number($post->ID)) . '"></span>
				<h5><a href="' . get_permalink($post->ID) . '" title="' . esc_attr($post->post_title) . '">' . $post->post_title . '</a></h5>';
				if((int)$show_post_categories || (int)$show_post_date)
				{
				$output .= '<ul class="post_details simple">';
				if((int)$show_post_categories)
				{
					$categories = get_the_category($post->ID);
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
				if((int)$show_post_date)
					$output .= '<li class="date">' . date_i18n(get_option('date_format'), strtotime($post->post_date)) . '</li>';
				$output .= '</ul>';
				}
				$output .= '</div>';
			$output .= '</li>';
		}
		$i++;
	}
	
	if(count($posts_list))
		$output .= '</ul>';
	return $output;
}
add_shortcode("pr_rank_list", "pr_theme_rank_list_shortcode");

//visual composer
function pr_theme_rank_list_vc_init()
{
	//get posts list
	global $pressroom_posts_array;

	//get categories
	$post_categories = get_terms("category");
	$post_categories_array = array();
	$post_categories_array[__("All", 'pressroom')] = "-";
	foreach($post_categories as $post_category)
		$post_categories_array[$post_category->name] =  $post_category->slug;
	
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
			"value" => array(__("Most read", 'pressroom') => "views", __("Most commented", 'pressroom') => "comment_count")
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
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Featured image size", 'pressroom'),
			"param_name" => "featured_image_size",
			"value" => $image_sizes_array
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
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("Page (small)", 'pressroom') => "page_margin_top", __("None", 'pressroom') => "none", __("Section (large)", 'pressroom') => "page_margin_top_section")
		)
	);
	wpb_map( array(
		"name" => __("Rank List", 'pressroom'),
		"base" => "pr_rank_list",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-rank-list",
		"category" => __('Pressroom', 'pressroom'),
		"params" => $params
	));
}
add_action("init", "pr_theme_rank_list_vc_init");
?>
