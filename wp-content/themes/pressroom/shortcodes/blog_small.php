<?php
//blog
function pr_theme_blog_small($atts, $content)
{
	global $themename;
	extract(shortcode_atts(array(
		"pr_pagination" => 0,
		"items_per_page" => 4,
		"offset" => 0,
		"featured_image_size" => "default",
		"ids" => "",
		"category" => "",
		"post_format" => "",
		"author" => "",
		"order_by" => "title menu_order",
		"order" => "DESC",
		"show_post_title" => 1,
		"show_post_excerpt" => 1,
		"read_more" => 1,
		"show_post_icon" => 1,
		"show_post_categories" => 1,
		"show_post_author" => 0,
		"show_post_date" => 1,
		"post_details_layout" => "simple",
		"show_post_comments_box" => 1,
		"is_search_results" => 0,
		"top_margin" => "none",
		"el_class" => ""
	), $atts));
	
	$featured_image_size = str_replace("pr_", "", $featured_image_size);
	
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
	$author = explode(",", $author);
	if($author[0]=="-" || $author[0]=="")
	{
		unset($author[0]);
		$author = array_values($author);
	}
	
	global $paged;
	$paged = (get_query_var((is_front_page() && !is_home() ? 'page' : 'paged'))) ? get_query_var((is_front_page() && !is_home() ? 'page' : 'paged')) : 1;
	if(in_array("current", (array)$author))
	{
		$author = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
		$author = array($author->ID);
	}
	$args = array( 
		'post__in' => $ids,
		'post_type' => 'post',
		'post_status' => 'publish',
		'paged' => $paged,
		'posts_per_page' => $items_per_page,
		'offset' => (!(int)$pr_pagination ? (int)$offset : 0),
		'cat' => (get_query_var('cat')!="" ? get_query_var('cat') : ''),
		'category_name' => (get_query_var('cat')=="" ? implode(",", $category) : ''),
		'tag' => get_query_var('tag'),
		'author__in' => $author,
		'orderby' => ($order_by=="views" ? 'meta_value_num' : implode(" ", explode(",", $order_by))), 
		'order' => $order
	);
	if($order_by=="views")
		$args['meta_key'] = 'post_views_count';
	if((int)$is_search_results)
		$args['s'] = get_query_var('s');
	if(!is_single())
	{
		$args['monthnum'] = get_query_var('monthnum');
		$args['day'] = get_query_var('day');
		$args['year'] = get_query_var('year');
		$args['w'] = get_query_var('week');
	}
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
	if(get_query_var('cat')!="")
	{
		$tmpCategory = get_category(get_query_var('cat'));
		$category = array($tmpCategory->slug);
	}
	query_posts($args);
	global $wp_query;
	$post_count = $wp_query->post_count;
	
	$output = '';
	if(have_posts())
	{
		$output .= '<div class="vc_row wpb_row vc_row-fluid">';
		$i = 0;
		require_once("class/Post.php");	
		while (have_posts()) : the_post();
			$post = new Pr_Post("small", "", get_post_meta(get_the_ID(), $themename. "_is_review", true), get_post_format(get_the_ID()), $featured_image_size, (int)$show_post_icon, (int)$show_post_date, (int)$show_post_categories, (int)$show_post_excerpt, (int)$show_post_author, $post_details_layout, "", $category, $i, $themename);
			if($i==0)
				$output .= '<ul class="blog clearfix small' . ($top_margin!="none" ? ' ' . $top_margin : '') . ($el_class!="" ? ' ' . $el_class : '') . '">';
			$output .= $post->getLiCssClass();
			$output .= $post->getThumbnail("blog-post-thumb");
			$output .= '<div class="post_content">';
			if((int)$show_post_title)
			{
				$comments_count = get_comments_number();
				$output .= '<h5 class="clearfix' . ((int)$show_post_comments_box ? ' with_number' : '') . (!(int)$show_post_date && !(int)$show_post_categories ? ' margin_bottom_0' : '') . '"><a href="' . get_permalink() . '" title="' . esc_attr(get_the_title()) . '">' . get_the_title() . '</a>' . ((int)$show_post_comments_box ? '<a href="' . get_comments_link() . '" title="' . $comments_count . ' ' . ($comments_count==1 ? __('comment', 'pressroom') : __('comments', 'pressroom')) . '" class="comments_number">' . $comments_count . '<span class="arrow_comments"></span></a>' : '') . '</h5>';
			}
			$output .= $post->getPostDetails();
			if((int)$read_more)
				$output .= '<a title="' . __('READ MORE', 'pressroom') . '" href="' . get_permalink() . '" class="read_more"><span class="arrow"></span><span>' . __('READ MORE', 'pressroom') . '</span></a>';
			$output .= '</div></li>';
			$i++;
		endwhile;
		$output .= '</ul></div>';
	}
	else if(is_search())
	{
		$output .= '<div class="vc_row wpb_row vc_row-fluid">' . sprintf(__('No results found for %s', 'pressroom'), get_query_var('s')) . '</div>';
	}
	
	if($pr_pagination)
	{
		require_once(locate_template("pagination.php"));
		$output .= kriesi_pagination(false, '', 2, false, false, '', 'page_margin_top');
	}
	//Reset Query
	wp_reset_query();
	return $output;
}
add_shortcode("blog_small", "pr_theme_blog_small");

//visual composer
function pr_theme_blog_small_vc_init()
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
		
	//get authors list
	$authors_list = get_users(array(
		'who' => 'authors'
	));
	$authors_array = array();
	$authors_array[__("All", 'pressroom')] = "-";
	$authors_array[__("Current author (applies on author single page)", 'pressroom')] = "current";
	foreach($authors_list as $author)
		$authors_array[$author->display_name . " (id:" . $author->ID . ")"] = $author->ID;
	
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
		$image_sizes_array[$s . " (" . $width . "x" . $height . ")"] = "pr_" . $s;
	}
	wpb_map( array(
		"name" => __("Blog Small", 'pressroom'),
		"base" => "blog_small",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-blog",
		"category" => __('Pressroom', 'pressroom'),
		"params" => array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Pagination", 'pressroom'),
				"param_name" => "pr_pagination",
				"value" => array(__("No", 'pressroom') => 0, __("Yes", 'pressroom') => 1)
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Items per page/Post count", 'pressroom'),
				"param_name" => "items_per_page",
				"value" => 4,
				"description" => __("Items per page if pagination is set to 'yes' or post count otherwise. Set -1 to display all.", 'pressroom')
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Offset", 'pressroom'),
				"param_name" => "offset",
				"value" => 0,
				"description" => __("Number of post to displace or pass over.", 'pressroom'),
				"dependency" => Array('element' => "pr_pagination", 'value' => "0")
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
				"type" => "dropdownmulti",
				"class" => "",
				"heading" => __("Display by author", 'pressroom'),
				"param_name" => "author",
				"value" => $authors_array
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
				"value" => array( __("descending", 'pressroom') => "DESC", __("ascending", 'pressroom') => "ASC")
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show post title", 'pressroom'),
				"param_name" => "show_post_title",
				"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show post excerpt", 'pressroom'),
				"param_name" => "show_post_excerpt",
				"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Read more button", 'pressroom'),
				"param_name" => "read_more",
				"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
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
				"heading" => __("Show post author", 'pressroom'),
				"param_name" => "show_post_author",
				"value" => array(__("No", 'pressroom') => 0, __("Yes", 'pressroom') => 1)
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
				"heading" => __("Post details layout", 'pressroom'),
				"param_name" => "post_details_layout",
				"value" => array(__("Simple", 'pressroom') => 'simple', __("Default", 'pressroom') => 'default')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show comments number box", 'pressroom'),
				"param_name" => "show_post_comments_box",
				"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Top margin", 'pressroom'),
				"param_name" => "top_margin",
				"value" => array(__("None", 'pressroom') => "none", __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section")
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
			)
		)
	));
}
add_action("init", "pr_theme_blog_small_vc_init");
?>
