<?php
/*
Template Name: 404 page
*/
header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");
get_header();
?>
<div class="theme_page relative">
	<div class="page_header vc_row wpb_row vc_row-fluid clearfix page_margin_top">
		<?php
		/*get page with 404 page template set*/
		$not_found_template_page_array = get_pages(array(
			'post_type' => 'page',
			'post_status' => 'publish',
			'number' => 1,
			'meta_key' => '_wp_page_template',
			'meta_value' => '404.php'
		));
		$not_found_template_page = $not_found_template_page_array[0];
		?>
		<div class="page_header_left">
			<h1 class="page_title"><?php echo $not_found_template_page->post_title; ?></h1>
		</div>
		<div class="page_header_right">
			<ul class="bread_crumb">
				<li>
					<a href="<?php echo get_home_url(); ?>" title="<?php esc_attr_e('Home', 'pressroom'); ?>">
						<?php _e('Home', 'pressroom'); ?>
					</a>
				</li>
				<li class="separator icon_small_arrow right_gray">
					&nbsp;
				</li>
				<li>
					<?php echo $not_found_template_page->post_title; ?>
				</li>
			</ul>
		</div>
		<div class="clearfix">
			<?php
			echo wpb_js_remove_wpautop(apply_filters('the_content', $not_found_template_page->post_content));
			global $post;
			$post = $not_found_template_page;
			setup_postdata($post);
			?>
		</div>
	</div>
</div>
<?php
get_footer(); 
?>
