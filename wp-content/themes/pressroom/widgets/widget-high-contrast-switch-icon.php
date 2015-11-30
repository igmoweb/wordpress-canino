<?php
class pr_high_contrast_switch_icon_widget extends WP_Widget 
{
	/** constructor */
    function pr_high_contrast_switch_icon_widget() 
	{
		global $themename;
		$widget_options = array(
			'classname' => 'pr_high_contrast_switch_icon_widget',
			'description' => 'Displays Shop Cart Icon'
		);
        parent::WP_Widget('pressroom_high_contrast_switch_icon', __('High contrast switch icon', 'pressroom'), $widget_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
        extract($args);

		//these are our widget options
		$icon_style = $instance["icon_style"];

		echo $before_widget;
		?>
		<a href="#" class="high_contrast_switch_icon <?php echo (isset($_COOKIE['pr_social_icons']) && $_COOKIE['pr_social_icons']!="" ? $_COOKIE['pr_social_icons'] : esc_attr($icon_style));?>">&nbsp;</a>
		<?php
        echo $after_widget;
    }
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['icon_style'] = strip_tags($new_instance['icon_style']);
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{
		$icon_style = (isset($instance["icon_style"]) ? esc_attr($instance["icon_style"]) : '');
		?>
		<p>
			<label for="<?php echo $this->get_field_id('icon_style'); ?>"><?php _e('Icon style', 'pressroom'); ?></label>
			<select id="<?php echo $this->get_field_id('icon_style'); ?>" name="<?php echo $this->get_field_name('icon_style'); ?>">
				<option value="dark"<?php echo ($icon_style=="dark" ? ' selected="selected"' : ''); ?>><?php _e('dark', 'pressroom'); ?></option>
				<option value="light"<?php echo ($icon_style=="light" ? ' selected="selected"' : ''); ?>><?php _e('light', 'pressroom'); ?></option>
			</select>
		</p>
		<?php
	}
}
//register widget
add_action('widgets_init', create_function('', 'return register_widget("pr_high_contrast_switch_icon_widget");'));
?>