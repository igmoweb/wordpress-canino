<?php
class pr_cart_icon_widget extends WP_Widget 
{
	/** constructor */
    function pr_cart_icon_widget() 
	{
		global $themename;
		$widget_options = array(
			'classname' => 'pr_cart_icon_widget',
			'description' => 'Displays Shop Cart Icon'
		);
        parent::WP_Widget('pressroom_cart_icon', __('Woocommerce Shop Cart Icon', 'pressroom'), $widget_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
        extract($args);

		//these are our widget options
		$icon_style = $instance["icon_style"];
		$cart_items_number = $instance["cart_items_number"];
		$icon_target = $instance["icon_target"];

		echo $before_widget;
		global $woocommerce;
		if(is_plugin_active('woocommerce/woocommerce.php'))
		{
			$cart_url = $woocommerce->cart->get_cart_url();
			?>
			<a <?php echo ($icon_target=="new_window" ? " target='_blank'" : ""); ?>href="<?php echo esc_url($cart_url);?>" class="cart_icon <?php echo (isset($_COOKIE['pr_social_icons']) && $_COOKIE['pr_social_icons']!="" ? $_COOKIE['pr_social_icons'] : esc_attr($icon_style));?>">&nbsp;<?php if($cart_items_number=="yes"): ?><span class="cart_items_number"<?php echo (!(int)$woocommerce->cart->cart_contents_count ? ' style="display: none;"' : ''); ?>><?php echo $woocommerce->cart->cart_contents_count; ?></span><?php endif;?></a>
			<?php
		}
        echo $after_widget;
    }
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['icon_style'] = strip_tags($new_instance['icon_style']);
		$instance['cart_items_number'] = strip_tags($new_instance['cart_items_number']);
		$instance['icon_target'] = $new_instance['icon_target'];
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{
		$icon_style = esc_attr($instance["icon_style"]);
		$cart_items_number = esc_attr($instance["cart_items_number"]);
		$icon_target = $instance["icon_target"];
		?>
		<p>
			<label for="<?php echo $this->get_field_id('icon_style'); ?>"><?php _e('Icon style', 'pressroom'); ?></label>
			<select id="<?php echo $this->get_field_id('icon_style'); ?>" name="<?php echo $this->get_field_name('icon_style'); ?>">
				<option value="dark"<?php echo ($icon_style=="dark" ? ' selected="selected"' : ''); ?>><?php _e('dark', 'pressroom'); ?></option>
				<option value="light"<?php echo ($icon_style=="light" ? ' selected="selected"' : ''); ?>><?php _e('light', 'pressroom'); ?></option>
				<option value="colors"<?php echo ($icon_style=="colors" ? ' selected="selected"' : ''); ?>><?php _e('colored', 'pressroom'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('cart_items_number') . $i; ?>"><?php _e('Show cart items number', 'pressroom'); ?></label>
			<select id="<?php echo $this->get_field_id('cart_items_number'); ?>" name="<?php echo $this->get_field_name('cart_items_number'); ?>">
				<option value="yes"<?php echo ($cart_items_number=="yes" ? ' selected="selected"' : ''); ?>><?php _e('yes', 'pressroom'); ?></option>
				<option value="no"<?php echo ($cart_items_number=="no" ? ' selected="selected"' : ''); ?>><?php _e('no', 'pressroom'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('icon_target'); ?>"><?php _e('Icon target', 'pressroom'); ?></label>
			<select name="<?php echo $this->get_field_name('icon_target'); ?>">
				<option value="same_window"<?php echo ($icon_target=="same_window" ? " selected='selected'" : ""); ?>><?php _e('same window', 'pressroom'); ?></option>
				<option value="new_window"<?php echo ($icon_target=="new_window" ? " selected='selected'" : ""); ?>><?php _e('new window', 'pressroom'); ?></option>
			</select>
		</p>
		<?php
	}
}
//register widget
add_action('widgets_init', create_function('', 'return register_widget("pr_cart_icon_widget");'));
?>