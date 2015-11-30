<?php
get_header();
global $post;
$post = get_post(get_option("woocommerce_shop_page_id"));
setup_postdata($post);
?>
<div class="theme_page relative">
	<div class="page_header vc_row wpb_row vc_row-fluid clearfix page_margin_top">
		<div class="page_header_left">
			<h1 class="page_title"><?php the_title(); ?></h1>
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
					<?php the_title(); ?>
				</li>
			</ul>
		</div>
	</div>
	<div class="clearfix">
		<div class="vc_row wpb_row vc_row-fluid">
			<div class="vc_col-sm-12 wpb_column vc_column_container">
				<div class="wpb_wrapper">
					<div class="divider_block clearfix"><hr class="divider first"><hr class="divider subheader_arrow"><hr class="divider last"></div>
				</div> 
			</div> 
		</div>
		<div class="vc_row wpb_row vc_row-fluid page_margin_top">
			<div class="vc_col-sm-8 wpb_column vc_column_container ">
				<div class="wpb_wrapper">
					<?php
					if(have_posts()):
						woocommerce_content();
					endif;
					?>
				</div> 
			</div>
			<div class="vc_col-sm-4 wpb_column vc_column_container">
				<div class="wpb_wrapper">
					<div class="wpb_widgetised_column wpb_content_element clearfix">
						<div class="wpb_wrapper">
							<?php dynamic_sidebar("sidebar-shop"); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
global $post;
$post = get_post(get_option("woocommerce_shop_page_id"));
setup_postdata($post);
get_footer(); 
?>