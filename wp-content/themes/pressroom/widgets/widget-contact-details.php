<?php
class pr_contact_details_widget extends WP_Widget 
{
	/** constructor */
    function pr_contact_details_widget() 
	{
		$widget_options = array(
			'classname' => 'pr_contact_details_widget',
			'description' => 'Displays Contact Details Box'
		);
		$control_options = array('width' => 665);
        parent::WP_Widget('pressroom_contact_details', __('Contact Details Box', 'pressroom'), $widget_options, $control_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
        extract($args);

		//these are our widget options
		$title = $instance['title'];
		$content = $instance['content'];
		$contact_details_left_header = $instance['contact_details_left_header'];
		$contact_details_left_line_1 = $instance['contact_details_left_line_1'];
		$contact_details_left_line_2 = $instance['contact_details_left_line_2'];
		$contact_details_left_line_3 = $instance['contact_details_left_line_3'];
		$contact_details_right_header = $instance['contact_details_right_header'];
		$contact_details_right_line_1 = $instance['contact_details_right_line_1'];
		$contact_details_right_line_2 = $instance['contact_details_right_line_2'];
		$contact_details_right_line_3 = $instance['contact_details_right_line_3'];
		$social_icons_header = $instance['social_icons_header'];
		$icon_type = $instance["icon_type"];
		$icon_style = $instance["icon_style"];
		$icon_value = $instance["icon_value"];
		$icon_target = $instance["icon_target"];

		echo $before_widget;
		if($title) 
		{
			echo $before_title . apply_filters("widget_title", $title) . $after_title;
		}
		if($content!='')
			echo '<p class="padding_top_bottom_25">' . do_shortcode(apply_filters("widget_text", $content)) . '</p>';
		if($contact_details_left_header!="" || $contact_details_left_line_1!="" || $contact_details_left_line_2!="" || $contact_details_left_line_3!="" || $contact_details_right_header!="" || $contact_details_right_line_1!="" || $contact_details_right_line_2!="" || $contact_details_right_line_3!=""):
		?>
		<div class="vc_row wpb_row vc_row-fluid">
			<?php if($contact_details_left_header!="" || $contact_details_left_line_1!="" || $contact_details_left_line_2!="" || $contact_details_left_line_3!=""):?>
			<div class="vc_col-sm-6 wpb_column vc_column_container">
				<?php 
				if($contact_details_left_header!="")
					echo "<h5>" . $contact_details_left_header . "</h5>"; 
				if($contact_details_left_line_1!="" || $contact_details_left_line_2!="" || $contact_details_left_line_3!=""):
				?>
				<p>
					<?php
					echo $contact_details_left_line_1;
					echo ($contact_details_left_line_1!="" ? "<br>" : "") . $contact_details_left_line_2;
					echo ($contact_details_left_line_1!="" || $contact_details_left_line_2!="" ? "<br>" : "") . $contact_details_left_line_3;
					?>
				</p>
				<?php
				endif;
				?>
			</div>
			<?php endif;
			if($contact_details_right_header!="" || $contact_details_right_line_1!="" || $contact_details_right_line_2!="" || $contact_details_right_line_3!=""):?>
			<div class="vc_col-sm-6 wpb_column vc_column_container">
				<?php 
				if($contact_details_right_header!="")
					echo "<h5>" . $contact_details_right_header . "</h5>";
				if($contact_details_right_line_1!="" || $contact_details_right_line_2!="" || $contact_details_right_line_3!=""):
				?>
				<p>
					<?php
					echo $contact_details_right_line_1;
					echo ($contact_details_right_line_1!="" ? "<br>" : "") . $contact_details_right_line_2;
					echo ($contact_details_right_line_1!="" || $contact_details_right_line_2!="" ? "<br>" : "") . $contact_details_right_line_3;
					?>
				</p>
				<?php
				endif;
				?>
			</div>
			<?php endif; ?>
		</div>
		<?php 
		endif;
		if($social_icons_header!="")
			echo str_replace("box_header", "box_header page_margin_top", $before_title) . apply_filters("widget_title", $social_icons_header) . $after_title;
		$arrayEmpty = true;
		for($i=0; $i<count($icon_type); $i++)
		{
			if($icon_type[$i]!="")
				$arrayEmpty = false;
		}
		if(!$arrayEmpty):
		?>
		<ul class="social_icons <?php echo esc_attr($icon_style); ?> page_margin_top clearfix">
			<?php
			for($i=0; $i<count($icon_type); $i++)
			{
				if($icon_type[$i]!=""):
			?>
			<li><a<?php echo ($icon_target[$i]=="new_window" ? " target='_blank'" : ""); ?> href="<?php echo esc_url($icon_value[$i]);?>" class="social_icon <?php echo esc_attr($icon_type[$i]);?>"></a></li>
			<?php
				endif;
			}
			?>
		</ul>
		<?php
		endif;
        echo $after_widget;
    }
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['animation'] = strip_tags($new_instance['animation']);
		$instance['content'] = $new_instance['content'];
		$instance['contact_details_left_header'] = $new_instance['contact_details_left_header'];
		$instance['contact_details_left_line_1'] = $new_instance['contact_details_left_line_1'];
		$instance['contact_details_left_line_2'] = $new_instance['contact_details_left_line_2'];
		$instance['contact_details_left_line_3'] = $new_instance['contact_details_left_line_3'];
		$instance['contact_details_right_header'] = $new_instance['contact_details_right_header'];
		$instance['contact_details_right_line_1'] = $new_instance['contact_details_right_line_1'];
		$instance['contact_details_right_line_2'] = $new_instance['contact_details_right_line_2'];
		$instance['contact_details_right_line_3'] = $new_instance['contact_details_right_line_3'];
		$instance['social_icons_header'] = $new_instance['social_icons_header'];
		$icon_type = (array)$new_instance['icon_type'];
		while(end($icon_type)==="")
			array_pop($icon_type);
		$instance['icon_type'] = $icon_type;
		$instance['icon_style'] = $new_instance['icon_style'];
		$instance['icon_value'] = $new_instance['icon_value'];
		$instance['icon_target'] = $new_instance['icon_target'];
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{	
		$title = esc_attr(isset($instance['title']) ? $instance['title'] : '');
		$animation = esc_attr(isset($instance['animation']) ? $instance['animation'] : '');
		$content = esc_attr(isset($instance['content']) ? $instance['content'] : '');
		$contact_details_left_header = esc_attr(isset($instance['contact_details_left_header']) ? $instance['contact_details_left_header'] : '');
		$contact_details_left_line_1 = esc_attr(isset($instance['contact_details_left_line_1']) ? $instance['contact_details_left_line_1'] : '');
		$contact_details_left_line_2 = esc_attr(isset($instance['contact_details_left_line_2']) ? $instance['contact_details_left_line_2'] : '');
		$contact_details_left_line_3 = esc_attr(isset($instance['contact_details_left_line_3']) ? $instance['contact_details_left_line_3'] : '');
		$contact_details_right_header = esc_attr(isset($instance['contact_details_right_header']) ? $instance['contact_details_right_header'] : '');
		$contact_details_right_line_1 = esc_attr(isset($instance['contact_details_right_line_1']) ? $instance['contact_details_right_line_1'] : '');
		$contact_details_right_line_2 = esc_attr(isset($instance['contact_details_right_line_2']) ? $instance['contact_details_right_line_2'] : '');
		$contact_details_right_line_3 = esc_attr(isset($instance['contact_details_right_line_3']) ? $instance['contact_details_right_line_3'] : '');
		$social_icons_header = esc_attr(isset($instance['social_icons_header']) ? $instance['social_icons_header'] : '');
		$icon_type = (isset($instance["icon_type"]) ? $instance["icon_type"] : '');
		$icon_style = (isset($instance["icon_style"]) ? $instance["icon_style"] : '');
		$icon_value = (isset($instance["icon_value"]) ?  $instance["icon_value"] : '');
		$icon_target = (isset($instance["icon_target"]) ? $instance["icon_target"] : '');
		$icons = array(
			"behance",
			"bing",
			"blogger",
			"deezer",
			"designfloat",
			"deviantart",
			"digg",
			"dribbble",
			"envato",
			"facebook",
			"flickr",
			"form",
			"forrst",
			"foursquare",
			"friendfeed",
			"googleplus",
			"instagram",
			"linkedin",
			"mail",
			"mobile",
			"myspace",
			"picasa",
			"pinterest",
			"reddit",
			"rss",
			"skype",
			"soundcloud",
			"spotify",
			"stumbleupon",
			"technorati",
			"tumblr",
			"twitter",
			"vimeo",
			"wykop",
			"xing",
			"youtube"
		);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('content'); ?>"><?php _e('Content', 'pressroom'); ?></label>
			<textarea rows="10" class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>"><?php echo $content; ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('contact_details_left_header'); ?>"><?php _e('Contact details left header', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('contact_details_left_header'); ?>" name="<?php echo $this->get_field_name('contact_details_left_header'); ?>" type="text" value="<?php echo esc_attr($contact_details_left_header); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('contact_details_left_line_1'); ?>"><?php _e('Contact details left line 1', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('contact_details_left_line_1'); ?>" name="<?php echo $this->get_field_name('contact_details_left_line_1'); ?>" type="text" value="<?php echo esc_attr($contact_details_left_line_1); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('contact_details_left_line_2'); ?>"><?php _e('Contact details left line 2', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('contact_details_left_line_2'); ?>" name="<?php echo $this->get_field_name('contact_details_left_line_2'); ?>" type="text" value="<?php echo esc_attr($contact_details_left_line_2); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('contact_details_left_line_3'); ?>"><?php _e('Contact details left line 3', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('contact_details_left_line_3'); ?>" name="<?php echo $this->get_field_name('contact_details_left_line_3'); ?>" type="text" value="<?php echo esc_attr($contact_details_left_line_3); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('contact_details_right_header'); ?>"><?php _e('Contact details right header', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('contact_details_right_header'); ?>" name="<?php echo $this->get_field_name('contact_details_right_header'); ?>" type="text" value="<?php echo esc_attr($contact_details_right_header); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('contact_details_right_line_1'); ?>"><?php _e('Contact details right line 1', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('contact_details_right_line_1'); ?>" name="<?php echo $this->get_field_name('contact_details_right_line_1'); ?>" type="text" value="<?php echo esc_attr($contact_details_right_line_1); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('contact_details_right_line_2'); ?>"><?php _e('Contact details right line 2', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('contact_details_right_line_2'); ?>" name="<?php echo $this->get_field_name('contact_details_right_line_2'); ?>" type="text" value="<?php echo esc_attr($contact_details_right_line_2); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('contact_details_right_line_3'); ?>"><?php _e('Contact details right line 3', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('contact_details_right_line_3'); ?>" name="<?php echo $this->get_field_name('contact_details_right_line_3'); ?>" type="text" value="<?php echo esc_attr($contact_details_right_line_3); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('social_icons_header'); ?>"><?php _e('Social icons header', 'pressroom'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('social_icons_header'); ?>" name="<?php echo $this->get_field_name('social_icons_header'); ?>" type="text" value="<?php echo esc_attr($social_icons_header); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('icon_style'); ?>"><?php _e('style', 'pressroom'); ?></label>
			<select id="<?php echo $this->get_field_id('icon_style'); ?>" name="<?php echo $this->get_field_name('icon_style'); ?>">
				<option value="dark"<?php echo ($icon_style=="dark" ? ' selected="selected"' : ''); ?>><?php _e('dark', 'pressroom'); ?></option>
				<option value="light"<?php echo ($icon_style=="light" ? ' selected="selected"' : ''); ?>><?php _e('light', 'pressroom'); ?></option>
				<option value="colors"<?php echo ($icon_style=="colors" ? ' selected="selected"' : ''); ?>><?php _e('colored', 'pressroom'); ?></option>
			</select>
		</p>
		<?php
		for($i=0; $i<(count($icon_type)<4 ? 4 : count($icon_type)); $i++)
		{
		?>
		<p>
			<label for="<?php echo $this->get_field_id('icon_type') . $i; ?>"><?php _e('Icon type', 'pressroom'); ?></label>
			<select id="<?php echo $this->get_field_id('icon_type') . $i; ?>" name="<?php echo $this->get_field_name('icon_type'); ?>[]">
				<option value="">-</option>
				<?php for($j=0; $j<count($icons); $j++)
				{
				?>
				<option value="<?php echo (isset($icons[$j]) ? esc_attr($icons[$j]) : ''); ?>"<?php echo (isset($icon_type[$i]) && $icons[$j]==$icon_type[$i] ? " selected='selected'" : "") ?>><?php echo $icons[$j]; ?></option>
				<?php
				}
				?>
			</select>
			<input style="width: 220px;" type="text" class="regular-text" value="<?php echo (isset($icon_value[$i]) ? esc_attr($icon_value[$i]) : ''); ?>" name="<?php echo $this->get_field_name('icon_value'); ?>[]">
			<select name="<?php echo $this->get_field_name('icon_target'); ?>[]">
				<option value="same_window"<?php echo (isset($icon_target[$i]) && $icon_target[$i]=="same_window" ? " selected='selected'" : ""); ?>>same window</option>
				<option value="new_window"<?php echo (isset($icon_target[$i]) && $icon_target[$i]=="new_window" ? " selected='selected'" : ""); ?>>new window</option>
			</select>
		</p>
		<?php
		}
		?>
		<p>
			<input type="button" class="button" name="<?php echo $this->get_field_name('add_new_button'); ?>" id="<?php echo $this->get_field_id('add_new_button'); ?>" value="<?php esc_attr_e('Add icon', 'pressroom'); ?>" />
		</p>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			$("#<?php echo $this->get_field_id('add_new_button'); ?>").click(function(){
				$(this).parent().before($(this).parent().prev().clone().wrap('<div>').parent().html());
				$(this).parent().prev().find("input").val('');
				$(this).parent().prev().find("select").each(function(){
					$(this).val($(this).children("option:first").val());
				});
			});
		});
		</script>
		<?php
	}
}
//register widget
add_action('widgets_init', create_function('', 'return register_widget("pr_contact_details_widget");'));
?>