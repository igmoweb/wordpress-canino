<?php 
if(comments_open())
{
	?>
<div class="comment_form_container<?php echo ($top_margin!='none' ? ' ' . $top_margin : ''); ?>">
	<h4 class="box_header">
		<?php _e("Leave a Comment", 'pressroom'); ?>
	</h4>
	<?php
	if(get_option('comment_registration') && !is_user_logged_in())
	{
	?>
	<p class="padding_top_30"><?php echo sprintf(__("You must be <a href='%s'>logged in</a> to post a comment."), wp_login_url(get_permalink())); ?></p>
	<?php
	}
	else
	{
	?>
	<p class="padding_top_30"><?php _e("Your email address will not be published. Required fields are marked with *", 'pressroom'); ?></p>
	<form class="comment_form margin_top_15" id="comment_form" method="post" action="#">
		<fieldset class="vc_col-sm-4 wpb_column vc_column_container">
			<div class="block">
				<input class="text_input" name="name" type="text" value="<?php echo __('Your Name *', 'pressroom'); ?>" placeholder="<?php echo __('Your Name *', 'pressroom'); ?>">
			</div>
		</fieldset>
		<fieldset class="vc_col-sm-4 wpb_column vc_column_container">
			<div class="block">
				<input class="text_input" name="email" type="text" value="<?php echo __('Your Email *', 'pressroom'); ?>" placeholder="<?php echo __('Your Email *', 'pressroom'); ?>">
			</div>
		</fieldset>
		<fieldset class="vc_col-sm-4 wpb_column vc_column_container">
			<div class="block">
				<input class="text_input" name="website" type="text" value="<?php echo __('Website', 'pressroom'); ?>" placeholder="<?php echo __('Website', 'pressroom'); ?>">
			</div>
		</fieldset>
		<fieldset>
			<div class="block">
				<textarea class="margin_top_10" name="message" placeholder="<?php echo __('Comment *', 'pressroom'); ?>"><?php echo __('Comment *', 'pressroom'); ?></textarea>
			</div>
		</fieldset>
		<fieldset>
			<input type="submit" value="<?php echo __('POST COMMENT', 'pressroom'); ?>" class="more active">
			<a href="#cancel" id="cancel_comment" title="<?php echo __('Cancel reply', 'pressroom'); ?>"><?php echo __('Cancel reply', 'pressroom'); ?></a>
			<input type="hidden" name="action" value="theme_comment_form">
			<input type="hidden" name="comment_parent_id" value="0">
			<input type="hidden" name="paged" value="1">
			<input type="hidden" name="prevent_scroll" value="0">
		</fieldset>
	<?php
	}
	global $post;
	?>
		<fieldset>
			<input type="hidden" name="post_id" value="<?php echo esc_attr(get_the_ID()); ?>">
			<input type="hidden" name="post_type" value="<?php echo esc_attr($post->post_type); ?>">
		</fieldset>
	</form>
</div>
<?php
}
?>