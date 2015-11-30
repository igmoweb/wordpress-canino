<?php
class pr_scrolling_recent_posts_widget extends WP_Widget 
{
	/** constructor */
    function pr_scrolling_recent_posts_widget() 
	{
		global $themename;
		$widget_options = array(
			'classname' => 'pr_scrolling_recent_posts_widget',
			'description' => 'Displays scrolling recent posts list'
		);
        parent::WP_Widget('pressroom_scrolling_recent_posts', __('Scrolling Recent Posts', 'pressroom'), $widget_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
		global $themename;
        extract($args);

		//these are our widget options
		$title = $instance['title'];
		$count = $instance['count'];
		$type = $instance['type'];
		$ids = $instance['ids'];
		$category = $instance['category'];
		$format = $instance['format'];
		$show_post_icon = $instance['show_post_icon'];
		$order_by = $instance['order_by'];
		$order = $instance['order'];
		$visible = $instance['visible'];
		$autoplay = $instance['autoplay'];
		$pause_on_hover = $instance['pause_on_hover'];
		$scroll = $instance['scroll'];
		$featured_image_size = $instance['featured_image_size'];
		$top_margin = $instance['top_margin'];

		if(is_array($ids) && ($ids[0]=="-" || $ids[0]==""))
		{
			unset($ids[0]);
			$ids = array_values($ids);
		}
		if(is_array($category) && ($category[0]=="-" || $category[0]==""))
		{
			unset($category[0]);
			$category = array_values($category);
		}
		if(is_array($format) && ($format[0]=="-" || $format[0]==""))
		{
			unset($format[0]);
			$format = array_values($format);
		}
		$args = array( 
			'include' => $ids,
			'post_type' => 'post',
			'posts_per_page' => $count,
			//'nopaging' => true,
			'post_status' => 'publish',
			'category_name' => implode(",", (array)$category),
			'orderby' => ($order_by=="views" ? 'meta_value_num' : implode(" ", explode(",", $order_by))), 
			'order' => $order
		);
		if($order_by=="views")
			$args['meta_key'] = 'post_views_count';
		if(count($format))
		{
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => $format
				)
			);
		}
		$posts_list = get_posts($args);
		
		echo $before_widget;
		?>
		<?php
		if($title) 
		{
			echo $before_title . apply_filters("widget_title", $title) . $after_title;
		}
		$output = '';
		if(count($posts_list))
			$output .= '<div class="' . $type . '_carousel_container' . ($top_margin!="none" ? ' ' . $top_margin : '') . '"><ul class="blog' . ($type=="vertical" ? ' small' : '') . ' ' . ($type=="big horizontal" ? 'horizontal' : $type) . '_carousel visible-' . (int)$visible . ' autoplay-' . (int)$autoplay . ' pause_on_hover-' . (int)$pause_on_hover . ' scroll-' . (int)$scroll . '">';
		$i=0;
		$category_filter_array = $category;
		foreach($posts_list as $post) 
		{
			$output .= '<li class="post">
				<a href="' . get_permalink($post->ID) . '" title="' . esc_attr($post->post_title) . '" class="post_image">';
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
				$output .= '<h5>' . (isset($count_number) && (int)$count_number ? '<span class="number">' . ($i+1) . '.</span>' : '') . '<a href="' . get_permalink($post->ID) . '" title="' . esc_attr($post->post_title) . '">' . $post->post_title . '</a></h5>
				<ul class="post_details simple">';
				$categories = get_the_category($post->ID);
				if(count($categories))
				{
					$primary_category = get_post_meta($post->ID, $themename. "_primary_category", true);
					$category_container_class = "category";
					if(isset($primary_category) && $primary_category!="-" && $primary_category!="")
					{
						$primary_category_object = get_category($primary_category);
						$category_container_class .= ' container-category-' . $primary_category_object->term_id;
					}
					else if(count($categories)==1)
						$category_container_class .= ' container-category-' . $categories[0]->term_id;
					$output .= '<li class="' . esc_attr($category_container_class) . '">';
					if(isset($primary_category) && $primary_category!="-" && $primary_category!="")
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
				$output .= '<li class="date">' . date_i18n(get_option('date_format'), strtotime($post->post_date)) . '</li>
				</ul>';
				if($type=="vertical")
					$output .= '</div>';
			$output .= '</li>';
			$i++;
		}
		
		if(count($posts_list))
			$output .= '</ul></div>';
		echo $output;
        echo $after_widget;
    }
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = strip_tags($new_instance['count']);
		$instance['type'] = strip_tags($new_instance['type']);
		$instance['ids'] = (is_array($new_instance['ids']) ? $new_instance['ids'] : explode(",", $new_instance['ids']));
		$instance['category'] = $new_instance['category'];
		$instance['format'] = $new_instance['format'];
		$instance['show_post_icon'] = $new_instance['show_post_icon'];
		$instance['order_by'] = strip_tags($new_instance['order_by']);
		$instance['order'] = strip_tags($new_instance['order']);
		$instance['visible'] = strip_tags($new_instance['visible']);
		$instance['autoplay'] = strip_tags($new_instance['autoplay']);
		$instance['pause_on_hover'] = strip_tags($new_instance['pause_on_hover']);
		$instance['scroll'] = strip_tags($new_instance['scroll']);
		$instance['featured_image_size'] = strip_tags($new_instance['featured_image_size']);
		$instance['top_margin'] = strip_tags($new_instance['top_margin']);
		
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{	
		global $themename;
		$title = (isset($instance['title']) ? esc_attr($instance['title']) : '');
		$count = (isset($instance['count']) ? esc_attr($instance['count']) : '');
		$type = (isset($instance['type']) ? esc_attr($instance['type']) : '');
		$ids = (isset($instance['ids']) ? (is_array($instance['ids']) ? $instance['ids'] : explode(",", $instance['ids'])) : '');
		$category = (isset($instance['category']) ? $instance['category'] : '');
		$format = (isset($instance['format']) ? $instance['format'] : '');
		$show_post_icon = (isset($instance['show_post_icon']) ? $instance['show_post_icon'] : '');
		$order_by = (isset($instance['order_by']) ? esc_attr($instance['order_by']) : '');
		$order = (isset($instance['order']) ? esc_attr($instance['order']) : '');
		$visible = (isset($instance['visible']) ? esc_attr($instance['visible']) : '');
		$autoplay = (isset($instance['autoplay']) ? esc_attr($instance['autoplay']) : '');
		$pause_on_hover = (isset($instance['pause_on_hover']) ? esc_attr($instance['pause_on_hover']) : '');
		$scroll = (isset($instance['scroll']) ? esc_attr($instance['scroll']) : '');
		$featured_image_size = (isset($instance['featured_image_size']) ? esc_attr($instance['featured_image_size']) : '');
		$top_margin = (isset($instance['top_margin']) ? esc_attr($instance['top_margin']) : '');
		
		//get posts list
		$count_posts = wp_count_posts();
		$posts_list = array();
		if($count_posts->publish<100)
		{
			$posts_list = get_posts(array(
				'posts_per_page' => -1,
				'nopaging' => true,
				'orderby' => 'title',
				'order' => 'ASC',
				'post_type' => 'post'
			));
		}

		//get categories
		$post_categories = get_terms("category");
		
		//get post formats
		if(current_theme_supports('post-formats')) 
			$post_formats = get_theme_support('post-formats');
		
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
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Count', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('type') . $i; ?>"><?php _e('Type', 'pressroom'); ?></label><br>
			<select id="<?php echo $this->get_field_id('type') . $i; ?>" name="<?php echo $this->get_field_name('type'); ?>">
				<option value="horizontal"<?php echo ($type=="horizontal" ? ' selected="selected"' : ''); ?>><?php _e('horizontal', 'pressroom'); ?></option>
				<option value="big horizontal"<?php echo ($type=="big horizontal" ? ' selected="selected"' : ''); ?>><?php _e('horizontal big', 'pressroom'); ?></option>
				<option value="vertical"<?php echo ($type=="vertical" ? ' selected="selected"' : ''); ?>><?php _e('vertical', 'pressroom'); ?></option>
			</select>
		</p>
		<?php if(count($posts_list)): ?>
		<p>
			<label for="<?php echo $this->get_field_id('ids') . $i; ?>"><?php _e('Display selected', 'pressroom'); ?></label><br>
			<select id="<?php echo $this->get_field_id('ids') . $i; ?>" name="<?php echo $this->get_field_name('ids'); ?>[]" multiple="multiple">
				<option value="-"<?php echo (!isset($ids) || (is_array($ids) && in_array("-", $ids)) ? ' selected="selected"' : '');?>><?php _e("All", 'pressroom'); ?></option>
				<?php
				foreach($posts_list as $post)
				{
				?>
					<option <?php echo (is_array($ids) && in_array($post->ID, $ids) ? ' selected="selected"':'');?> value='<?php echo $post->ID;?>'><?php echo $post->post_title . " (id:" . $post->ID . ")"; ?></option>
				<?php
				}
				?>
			</select>
		</p>
		<?php else: ?>
		<p>
			<label for="<?php echo $this->get_field_id('ids'); ?>"><?php _e('Display selected', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('ids'); ?>" name="<?php echo $this->get_field_name('ids'); ?>" type="text" value="<?php echo esc_attr(implode(",", $ids)); ?>" />
			<span class="description"><?php _e("Selected posts ids separated with commas", 'pressroom');?></span>
		</p>
		<?php endif; ?>
		<p>
			<label for="<?php echo $this->get_field_id('category') . $i; ?>"><?php _e('Display from Category', 'pressroom'); ?></label><br>
			<select id="<?php echo $this->get_field_id('category') . $i; ?>" name="<?php echo $this->get_field_name('category'); ?>[]" multiple="multiple">
				<option value="-"<?php echo ($category=="" || (is_array($category) && in_array("-", $category)) ? ' selected="selected"' : '');?>><?php _e("All", 'pressroom'); ?></option>
				<?php
				foreach($post_categories as $post_category)
				{
				?>
					<option <?php echo (is_array($category) && in_array($post_category->slug, $category) ? ' selected="selected"':'');?> value='<?php echo $post_category->slug;?>'><?php echo $post_category->name; ?></option>
				<?php
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('format') . $i; ?>"><?php _e('Display by post format', 'pressroom'); ?></label><br>
			<select id="<?php echo $this->get_field_id('format') . $i; ?>" name="<?php echo $this->get_field_name('format'); ?>[]" multiple="multiple">
				<option value="-"<?php echo ($format=="" || (is_array($format) && in_array("-", $format)) ? ' selected="selected"' : '');?>><?php _e("All", 'pressroom'); ?></option>
				<?php
				foreach($post_formats[0] as $post_format)
				{
				?>
					<option <?php echo (is_array($format) && in_array("post-format-" . $post_format, $format) ? ' selected="selected"':'');?> value='<?php echo "post-format-" . $post_format;?>'><?php echo $post_format; ?></option>
				<?php
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('show_post_icon'); ?>"><?php _e('Show post format icon on featured image', 'pressroom'); ?></label>
			<select id="<?php echo $this->get_field_id('show_post_icon'); ?>" name="<?php echo $this->get_field_name('show_post_icon'); ?>">
				<option value="1"<?php echo (!isset($show_post_icon) || (int)$show_post_icon==1 ? ' selected="selected"' : ''); ?>><?php _e('yes', 'pressroom'); ?></option>
				<option value="0"<?php echo (isset($show_post_icon) && (int)$show_post_icon==0 ? ' selected="selected"' : ''); ?>><?php _e('no', 'pressroom'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('order_by') . $i; ?>"><?php _e('Order by', 'pressroom'); ?></label><br>
			<select id="<?php echo $this->get_field_id('order_by') . $i; ?>" name="<?php echo $this->get_field_name('order_by'); ?>">
				<option value="title,menu_order"<?php echo ($order_by=="title,menu_order" ? ' selected="selected"' : ''); ?>><?php _e('Title, menu order', 'pressroom'); ?></option>
				<option value="menu_order"<?php echo ($order_by=="menu_order" ? ' selected="selected"' : ''); ?>><?php _e('Menu order', 'pressroom'); ?></option>
				<option value="date"<?php echo ($order_by=="date" ? ' selected="selected"' : ''); ?>><?php _e('Date', 'pressroom'); ?></option>
				<option value="views"<?php echo ($order_by=="views" ? ' selected="selected"' : ''); ?>><?php _e('Post views', 'pressroom'); ?></option>
				<option value="comment_count"<?php echo ($order_by=="comment_count" ? ' selected="selected"' : ''); ?>><?php _e('Comment count', 'pressroom'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('order') . $i; ?>"><?php _e('Order', 'pressroom'); ?></label><br>
			<select id="<?php echo $this->get_field_id('order') . $i; ?>" name="<?php echo $this->get_field_name('order'); ?>">
				<option value="DESC"<?php echo ($order=="DESC" ? ' selected="selected"' : ''); ?>><?php _e('descending', 'pressroom'); ?></option>
				<option value="ASC"<?php echo ($order=="ASC" ? ' selected="selected"' : ''); ?>><?php _e('ascending', 'pressroom'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('visible'); ?>"><?php _e('Visible', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('visible'); ?>" name="<?php echo $this->get_field_name('visible'); ?>" type="text" value="<?php echo (isset($visible) && (int)$visible>0 ? esc_attr($visible) : 3); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e('Autoplay', 'pressroom'); ?></label>
			<select id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>">
				<option value="1"<?php echo (!isset($autoplay) || (int)$autoplay==1 ? ' selected="selected"' : ''); ?>><?php _e('yes', 'pressroom'); ?></option>
				<option value="0"<?php echo (isset($autoplay) && (int)$autoplay==0 ? ' selected="selected"' : ''); ?>><?php _e('no', 'pressroom'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('pause_on_hover'); ?>"><?php _e('Pause on hover', 'pressroom'); ?></label>
			<select id="<?php echo $this->get_field_id('pause_on_hover'); ?>" name="<?php echo $this->get_field_name('pause_on_hover'); ?>">
				<option value="1"<?php echo (!isset($pause_on_hover) || (int)$pause_on_hover==1 ? ' selected="selected"' : ''); ?>><?php _e('yes', 'pressroom'); ?></option>
				<option value="0"<?php echo (isset($pause_on_hover) && (int)$pause_on_hover==0 ? ' selected="selected"' : ''); ?>><?php _e('no', 'pressroom'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('scroll'); ?>"><?php _e('Scroll', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('scroll'); ?>" name="<?php echo $this->get_field_name('scroll'); ?>" type="text" value="<?php echo ((int)$scroll ? (int)$scroll : 1); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('featured_image_size') . $i; ?>"><?php _e('Featured image size', 'pressroom'); ?></label><br>
			<select id="<?php echo $this->get_field_id('featured_image_size') . $i; ?>" name="<?php echo $this->get_field_name('featured_image_size'); ?>">
				<?php
				foreach($image_sizes_array as $key=>$s)
				{
				?>
					<option <?php echo ($featured_image_size==$s ? ' selected="selected"':'');?> value='<?php echo $s;?>'><?php echo $key; ?></option>
				<?php
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('top_margin') . $i; ?>"><?php _e('Top margin', 'pressroom'); ?></label><br>
			<select id="<?php echo $this->get_field_id('top_margin') . $i; ?>" name="<?php echo $this->get_field_name('top_margin'); ?>">
				<option value="none"<?php echo ($top_margin=="none" ? ' selected="selected"' : ''); ?>><?php _e('None', 'pressroom'); ?></option>
				<option value="page_margin_top"<?php echo ($top_margin=="page_margin_top" ? ' selected="selected"' : ''); ?>><?php _e('Page (small)', 'pressroom'); ?></option>
				<option value="page_margin_top_section"<?php echo ($top_margin=="page_margin_top_section" ? ' selected="selected"' : ''); ?>><?php _e('Section (large)', 'pressroom'); ?></option>
			</select>
		</p>
		<?php
	}
}
//register widget
add_action('widgets_init', create_function('', 'return register_widget("pr_scrolling_recent_posts_widget");'));
?>