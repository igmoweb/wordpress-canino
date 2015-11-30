<?php
class pr_social_icons_widget extends WP_Widget 
{
	/** constructor */
    function pr_social_icons_widget() 
	{
		global $themename;
		$widget_options = array(
			'classname' => 'pr_social_icons_widget',
			'description' => 'Displays Social Icons'
		);
		$control_options = array('width' => 625);
        parent::WP_Widget('pressroom_social_icons', __('Social Icons', 'pressroom'), $widget_options, $control_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
		global $themename;
        extract($args);

		//these are our widget options
		$icons_style = $instance["icons_style"];
		$icon_type = $instance["icon_type"];
		$icon_value = $instance["icon_value"];
		$icon_target = $instance["icon_target"];

		echo $before_widget;
		if(isset($title) && $title!="") 
		{
			echo $before_title . $title . $after_title;
		} 
		$arrayEmpty = true;
		for($i=0; $i<count($icon_type); $i++)
		{
			if($icon_type[$i]!="")
				$arrayEmpty = false;
		}
		if(!$arrayEmpty):
		?>
		<ul class="social_icons clearfix <?php echo (isset($_COOKIE['pr_social_icons']) && $_COOKIE['pr_social_icons']!="" ? $_COOKIE['pr_social_icons'] : esc_attr($icons_style));?>">
			<?php
			for($i=0; $i<count($icon_type); $i++)
			{
				if($icon_type[$i]!=""):
			?>
			<li><a <?php echo ($icon_target[$i]=="new_window" ? " target='_blank' " : ""); ?>href="<?php echo esc_url($icon_value[$i]);?>" class="social_icon <?php echo esc_attr($icon_type[$i]); ?>">&nbsp;</a></li>
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
		$instance['icons_style'] = strip_tags($new_instance['icons_style']);
		$icon_type = (array)$new_instance['icon_type'];
		while(end($icon_type)==="")
			array_pop($icon_type);
		$instance['icon_type'] = $icon_type;
		$instance['icon_value'] = $new_instance['icon_value'];
		$instance['icon_target'] = $new_instance['icon_target'];
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{	
		global $themename;
		$icons_style = (isset($instance["icons_style"]) ? esc_attr($instance["icons_style"]) : '');
		$icon_type = (isset($instance["icon_type"]) ? $instance["icon_type"] : '');
		$icon_value = (isset($instance["icon_value"]) ? $instance["icon_value"] : '');
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
			"spotify",
			"soundcloud",
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
		<label for="<?php echo $this->get_field_id('icons_style') . $i; ?>"><?php _e('Icons style', 'pressroom'); ?></label>
		<select id="<?php echo $this->get_field_id('icons_style'); ?>" name="<?php echo $this->get_field_name('icons_style'); ?>">
			<option value="dark"<?php echo ($icons_style=="dark" ? ' selected="selected"' : ''); ?>><?php _e('dark', 'pressroom'); ?></option>
			<option value="light"<?php echo ($icons_style=="light" ? ' selected="selected"' : ''); ?>><?php _e('light', 'pressroom'); ?></option>
			<option value="colors"<?php echo ($icons_style=="colors" ? ' selected="selected"' : ''); ?>><?php _e('colored', 'pressroom'); ?></option>
		</select>
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
				<option value="<?php echo esc_attr($icons[$j]); ?>"<?php echo (isset($icon_type[$i]) && $icons[$j]==$icon_type[$i] ? " selected='selected'" : "") ?>><?php echo $icons[$j]; ?></option>
				<?php
				}
				?>
			</select>
			<input style="width: 220px;" type="text" class="regular-text" value="<?php echo (isset($icon_value[$i]) ? esc_attr($icon_value[$i]) : ''); ?>" name="<?php echo $this->get_field_name('icon_value'); ?>[]">
			<select name="<?php echo $this->get_field_name('icon_target'); ?>[]">
				<option value="same_window"<?php echo (isset($icon_target[$i]) && $icon_target[$i]=="same_window" ? " selected='selected'" : ""); ?>><?php _e('same window', 'pressroom'); ?></option>
				<option value="new_window"<?php echo (isset($icon_target[$i]) && $icon_target[$i]=="new_window" ? " selected='selected'" : ""); ?>><?php _e('new window', 'pressroom'); ?></option>
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
add_action('widgets_init', create_function('', 'return register_widget("pr_social_icons_widget");'));
?>