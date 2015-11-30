<?php
class pr_scrolling_posts_widget extends WP_Widget 
{
	/** constructor */
    function pr_scrolling_posts_widget() 
	{
		global $themename;
		$widget_options = array(
			'classname' => 'pr_scrolling_posts_widget',
			'description' => 'Displays scrolling posts list'
		);
        parent::WP_Widget('pressroom_scrolling_posts', __('Scrolling Posts', 'pressroom'), $widget_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
		global $themename;
        extract($args);

		//these are our widget options
		$count = $instance['count'];
		$ids = $instance['ids'];
		$category = $instance['category'];
		$format = $instance['format'];
		$label = $instance['label'];
		$order_by = $instance['order_by'];
		$order = $instance['order'];

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
		if(isset($title) && $title!="") 
		{
			echo $before_title . apply_filters("widget_title", $title) . $after_title;
		}
		$output = '';
		if(count($posts_list))
		{
			$output .= '<div class="latest_news_scrolling_list_container"><ul>';
			if(isset($label) && $label!="")
			{
				$output .= '<li class="category">' . $label . '</li>';
			}
			else if(count($category))
			{
				$output .= '<li class="category">';
				foreach($category as $post_category)
				{
					$current_category = get_category_by_slug($post_category);
					$output .= '<a href="' . esc_url(get_category_link($current_category)) . '" title="' . esc_attr($current_category->name) . '">' . $current_category->name . '</a>' . ($post_category!=end($category) ? ', ' : '');
				}
				$output .= '</li>';
			}
			if(is_rtl())
			{
				$output .= '<li class="right"><a href="#"></a></li><li class="left"><a href="#"></a></li><li class="posts"><ul class="latest_news_scrolling_list">';
			}
			else
			{
				$output .= '<li class="left"><a href="#"></a></li><li class="right"><a href="#"></a></li><li class="posts"><ul class="latest_news_scrolling_list">';
			}
			$dates = '<li class="date">';
			$i = 0;
			foreach($posts_list as $post) 
			{
				$output .= '<li><a href="' . get_permalink($post->ID) . '" title="' . esc_attr($post->post_title) . '">' . $post->post_title . '</a></li>';
				$dates .= '<abbr title="' . date("c", strtotime($post->post_date)) . '" class="timeago' . ($i==0 ? ' current' : '') . '">' . date("c", strtotime($post->post_date)) . '</abbr>';
				$i++;
			}
			$dates .= '</li>';
			$output .= '</ul></li>' . $dates . '</ul></div>';
		}
		echo $output;
        echo $after_widget;
    }
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['count'] = strip_tags($new_instance['count']);
		$instance['ids'] = (is_array($new_instance['ids']) ? $new_instance['ids'] : explode(",", $new_instance['ids']));
		$instance['category'] = $new_instance['category'];
		$instance['format'] = $new_instance['format'];
		$instance['label'] = strip_tags($new_instance['label']);
		$instance['order_by'] = strip_tags($new_instance['order_by']);
		$instance['order'] = strip_tags($new_instance['order']);
		
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{	
		global $themename;
		$count = (isset($instance['count']) ? esc_attr($instance['count']) : '');
		$ids = (isset($instance['ids']) ? (is_array($instance['ids']) ? $instance['ids'] : explode(",", $instance['ids'])) : '');
		$category = (isset($instance['category']) ? $instance['category'] : '');
		$format = (isset($instance['format']) ? $instance['format'] : '');
		$label = (isset($instance['label']) ? esc_attr($instance['label']) : '');
		$order_by = (isset($instance['order_by']) ? esc_attr($instance['order_by']) : '');
		$order = (isset($instance['order']) ? esc_attr($instance['order']) : '');
		
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
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Count', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" />
		</p>
		<?php if(count($posts_list)): ?>
		<p>
			<label for="<?php echo $this->get_field_id('ids'); ?>"><?php _e('Display selected', 'pressroom'); ?></label><br>
			<select id="<?php echo $this->get_field_id('ids'); ?>" name="<?php echo $this->get_field_name('ids'); ?>[]" multiple="multiple">
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
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Display from Category', 'pressroom'); ?></label><br>
			<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>[]" multiple="multiple">
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
			<label for="<?php echo $this->get_field_id('format'); ?>"><?php _e('Display by post format', 'pressroom'); ?></label><br>
			<select id="<?php echo $this->get_field_id('format'); ?>" name="<?php echo $this->get_field_name('format'); ?>[]" multiple="multiple">
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
			<label for="<?php echo $this->get_field_id('label'); ?>"><?php _e('Label', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('label'); ?>" name="<?php echo $this->get_field_name('label'); ?>" type="text" value="<?php echo esc_attr($label); ?>" />
			<span class="description"><?php _e("Leave empty for default label", 'pressroom');?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('order_by'); ?>"><?php _e('Order by', 'pressroom'); ?></label><br>
			<select id="<?php echo $this->get_field_id('order_by'); ?>" name="<?php echo $this->get_field_name('order_by'); ?>">
				<option value="title,menu_order"<?php echo ($order_by=="title,menu_order" ? ' selected="selected"' : ''); ?>><?php _e('Title, menu order', 'pressroom'); ?></option>
				<option value="menu_order"<?php echo ($order_by=="menu_order" ? ' selected="selected"' : ''); ?>><?php _e('Menu order', 'pressroom'); ?></option>
				<option value="date"<?php echo ($order_by=="date" ? ' selected="selected"' : ''); ?>><?php _e('Date', 'pressroom'); ?></option>
				<option value="views"<?php echo ($order_by=="views" ? ' selected="selected"' : ''); ?>><?php _e('Post views', 'pressroom'); ?></option>
				<option value="comment_count"<?php echo ($order_by=="comment_count" ? ' selected="selected"' : ''); ?>><?php _e('Comment count', 'pressroom'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', 'pressroom'); ?></label><br>
			<select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
				<option value="DESC"<?php echo ($order=="DESC" ? ' selected="selected"' : ''); ?>><?php _e('descending', 'pressroom'); ?></option>
				<option value="ASC"<?php echo ($order=="ASC" ? ' selected="selected"' : ''); ?>><?php _e('ascending', 'pressroom'); ?></option>
			</select>
		</p>
		<?php
	}
}
//register widget
add_action('widgets_init', create_function('', 'return register_widget("pr_scrolling_posts_widget");'));
?>