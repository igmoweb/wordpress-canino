<!--custom style-->
<style type="text/css">
	<?php
	$main_color = (isset($_COOKIE['pr_main_color']) ? $_COOKIE['pr_main_color'] : $theme_options['main_color']);
	if($theme_options["site_background_color"]!=""): ?>
	body
	{
		background-color: #<?php echo $theme_options["site_background_color"]; ?>;
	}
	<?php endif;
	if($main_color!=""): ?>
	p a,
	table a,
	.about_subtitle,
	.header h1,
	.header h1 a,
	.blog  ul.post_details.simple li.category,
	.blog  ul.post_details.simple li.category a,
	.post.single .post_details a,
	.review_summary .number,
	.announcement .expose,
	#cancel_comment,
	.more.highlight,
	.more.active:hover
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce-cart .woocommerce .wc-proceed-to-checkout a.checkout-button:hover,
	.woocommerce .widget_price_filter .price_slider_amount .button:hover,
	.woocommerce .widget_product_search form input[type='submit']:hover,
	.woocommerce div.product form.cart .button.single_add_to_cart_button:hover,
	.woocommerce #review_form #respond .form-submit input:hover,
	.woocommerce #payment #place_order:hover,
	.woocommerce .cart input.button:hover,
	.woocommerce .button.wc-forward:hover,
	.woocommerce .posted_in a,
	.woocommerce-message a,
	.woocommerce-info a,
	.woocommerce-error a,
	.woocommerce-review-link,
	.woocommerce-checkout #payment .payment_method_paypal .about_paypal
	<?php
	endif;
	?>
	{
		color: #<?php echo $main_color; ?>;
	}
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	.woocommerce a.remove
	{
		color: #<?php echo $main_color; ?> !important;
	}
	<?php
	endif;
	?>
	.more:hover
	{
		color: #FFF;
	}
	.menu_container .ubermenu .ubermenu-nav li:hover, .menu_container .ubermenu .ubermenu-nav li.ubermenu-active, .menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item, .menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-parent, .menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor,
	.menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children:hover,
	.style_2.menu_container .ubermenu .ubermenu-nav li:hover, .style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item,
	.style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-active,
	.style_2.menu_container .ubermenu .ubermenu-nav li:hover a, .style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item a,
	.style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children:hover a,
	.style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-parent, .style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor,
	.style_3.menu_container .ubermenu .ubermenu-nav li:hover, .style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item,
	.style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-active,
	.style_3.menu_container .ubermenu .ubermenu-nav li:hover a, .style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item a,
	.style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children:hover a,
	.style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-parent, .style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor,
	.style_5.menu_container .ubermenu .ubermenu-nav li:hover, .style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item,
	.style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-active,
	.style_5.menu_container .ubermenu .ubermenu-nav li:hover a, .style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item a,
	.style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children:hover a,
	.style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-parent, .style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor,
	.style_10.menu_container .ubermenu .ubermenu-nav li:hover, .style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item,
	.style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-active,
	.style_10.menu_container .ubermenu .ubermenu-nav li:hover a, .style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item a,
	.style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children:hover a,
	.style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-parent, .style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor,
	.style_3.menu_container,
	.style_3.menu_container .ubermenu .ubermenu-nav li,
	.style_4.menu_container .ubermenu .ubermenu-nav li:hover, .style_4.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item,
	.style_4.menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children:hover,
	.style_4.menu_container .ubermenu .ubermenu-nav li:hover a, .style_4.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item a,
	.style_4.menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children:hover a,
	.style_4.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-parent, .style_4.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor
	{
		border-top-color: #<?php echo $main_color; ?>;
	}
	.style_4.menu_container,
	.style_4.menu_container .ubermenu .ubermenu-nav li
	{
		background-color: #F0F0F0;
		border-color: #F0F0F0;
	}
	.style_2.menu_container .ubermenu .ubermenu-nav li:hover, .style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item,
	.style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-active,
	.style_2.menu_container .ubermenu .ubermenu-nav li:hover a, .style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item a,
	.style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children:hover a,
	.style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-parent, .style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor,
	.style_3.menu_container .ubermenu .ubermenu-nav li:hover, .style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item,
	.style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-active,
	.style_3.menu_container .ubermenu .ubermenu-nav li:hover a, .style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item a,
	.style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children:hover a,
	.style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-parent, .style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor,
	.style_5.menu_container .ubermenu .ubermenu-nav li:hover, .style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item,
	.style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-active,
	.style_5.menu_container .ubermenu .ubermenu-nav li:hover a, .style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item a,
	.style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children:hover a,
	.style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-parent, .style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor,
	.style_10.menu_container .ubermenu .ubermenu-nav li:hover, .style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item,
	.style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-active,
	.style_10.menu_container .ubermenu .ubermenu-nav li:hover a, .style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item a,
	.style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children:hover a,
	.style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-parent, .style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor
	{
		border-bottom-color: #<?php echo $main_color; ?>;
	}
	.box_header,
	.widgettitle,
	.mobile-menu-switch,
	.widget_categories a:hover,
	.widget_tag_cloud a:hover,
	.taxonomies a:hover,
	.review_summary .number,
	.tabs.small .tabs_navigation li a:hover,
	.tabs.small .tabs_navigation li a.selected,
	.tabs.small .tabs_navigation li.ui-tabs-active a,
	.accordion .ui-accordion-header.ui-state-active,
	.more.highlight,
	.more.active:hover,
	.more.active,
	.more:hover
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce .product-categories li a:hover,
	.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
	.woocommerce div.product .woocommerce-tabs ul.tabs li a.selected,
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
	.woocommerce-cart .woocommerce .wc-proceed-to-checkout a.checkout-button:hover,
	.woocommerce .widget_price_filter .price_slider_amount .button:hover,
	.woocommerce .widget_product_search form input[type='submit']:hover,
	.woocommerce div.product form.cart .button.single_add_to_cart_button:hover,
	.woocommerce #review_form #respond .form-submit input:hover,
	.woocommerce #payment #place_order:hover,
	.woocommerce .cart input.button:hover,
	.woocommerce #respond input#submit:hover, 
	.woocommerce a.button:hover, 
	.woocommerce button.button:hover, 
	.woocommerce input.button:hover,
	.woocommerce #respond input#submit.alt:hover, 
	.woocommerce a.button.alt:hover, 
	.woocommerce button.button.alt:hover, 
	.woocommerce input.button.alt:hover,
	.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
	.woocommerce .widget_price_filter .price_slider_amount .button,
	.woocommerce .widget_product_search form input[type='submit'],
	.woocommerce div.product form.cart .button.single_add_to_cart_button,
	.woocommerce #review_form #respond .form-submit input,
	.woocommerce #payment #place_order,
	.woocommerce .cart input.button,
	.woocommerce .cart .coupon input.button:hover,
	.woocommerce .button.wc-forward,
	.woocommerce .button.wc-forward:hover,
	.woocommerce .comment-reply-title,
	.woocommerce .related.products h2,
	.woocommerce-account .woocommerce h2,
	.woocommerce-checkout .woocommerce h2,
	.woocommerce-account .title h3,
	.woocommerce-checkout .title h3,
	.woocommerce .woocommerce-error, .woocommerce .woocommerce-info, .woocommerce .woocommerce-message,
	.woocommerce .quantity .plus:hover,
	.woocommerce .quantity .minus:hover,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-handle
	<?php
	endif;
	?>
	{
		border-color: #<?php echo $main_color; ?>;
	}
	.post .comments_number:hover .arrow_comments,
	.footer .post .comments_number:hover .arrow_comments,
	.tabs_navigation li.ui-tabs-active span
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active span
	<?php
	endif;
	?>
	{
		border-color: #<?php echo $main_color; ?> transparent;
	}
	.mobile_menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item>a,
	.mobile_menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor ul li.ubermenu-current-menu-item a,
	.mobile_menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor ul li.ubermenu-current-menu-parent ul li.ubermenu-current-menu-item a,
	.mobile_menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor a,
	.mobile_menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor ul li.ubermenu-current-menu-parent a,
	.mobile_menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor ul li.ubermenu-current-menu-parent ul li.ubermenu-current-menu-parent a,
	.mobile-menu-switch .line,
	.mobile-menu-switch:hover,
	<?php
	if((isset($_COOKIE['pr_color_skin']) && $_COOKIE['pr_color_skin']=="dark") || (!isset($_COOKIE['pr_color_skin']) && $theme_options["color_scheme"]=="dark")):
	?>
	.slider_posts_list_container a.slider_control,
	<?php
	endif;
	?>
	.slider_navigation .slider_control a:hover,
	a.slider_control:hover,
	.slider_posts_list .slider_posts_list_bar,
	.vc_row  .wpb_column .blog .post .with_number .comments_number:hover,
	.footer .post .comments_number:hover,
	.post_details li.category,
	.dropcap .dropcap_label.active,
	.widget_categories a:hover,
	.widget_tag_cloud a:hover,
	.taxonomies a:hover,
	.value_container .value_bar,
	.pagination li a:hover,
	.pagination li.selected a,
	.pagination li.selected span,
	.tabs_navigation li a:hover,
	.tabs_navigation li a.selected,
	.tabs_navigation li.ui-tabs-active a,
	.accordion .ui-accordion-header.ui-state-active,
	.icon.fullscreen:hover,
	.more.active,
	.more:hover,
	.gallery_popup .slider_navigation .slider_control a:hover,
	.style_2.menu_container .ubermenu .ubermenu-nav a:hover,
	.style_3.menu_container .ubermenu .ubermenu-nav a:hover,
	.style_2.menu_container .ubermenu .ubermenu-nav li:hover, .style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item,
	.style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-active,
	.style_2.menu_container .ubermenu .ubermenu-nav li:hover a, .style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item a,
	.style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children:hover a,
	.style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-parent, .style_2.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor,
	.style_3.menu_container .ubermenu .ubermenu-nav li:hover, .style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item,
	.style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-active,
	.style_3.menu_container .ubermenu .ubermenu-nav li:hover a, .style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item a,
	.style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children:hover a,
	.style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-parent, .style_3.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor,
	.style_5.menu_container .ubermenu .ubermenu-nav li:hover, .style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item,
	.style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-active,
	.style_5.menu_container .ubermenu .ubermenu-nav li:hover a, .style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item a,
	.style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children:hover a,
	.style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-parent, .style_5.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor,
	.style_10.menu_container .ubermenu .ubermenu-nav li:hover, .style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item,
	.style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-active,
	.style_10.menu_container .ubermenu .ubermenu-nav li:hover a, .style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item a,
	.style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children:hover a,
	.style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-parent, .style_10.menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor,
	.style_5.menu_container .ubermenu .ubermenu-nav a:hover,
	.style_10.menu_container .ubermenu .ubermenu-nav a:hover
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce .product-categories li a:hover,
	.woocommerce .woocommerce-pagination ul.page-numbers li a:hover,
	.woocommerce .woocommerce-pagination ul.page-numbers li a.current,
	.woocommerce .woocommerce-pagination ul.page-numbers li span.current,
	.woocommerce #respond input#submit:hover, 
	.woocommerce a.button:hover, 
	.woocommerce button.button:hover, 
	.woocommerce input.button:hover,
	.woocommerce #respond input#submit.alt:hover, 
	.woocommerce a.button.alt:hover, 
	.woocommerce button.button.alt:hover, 
	.woocommerce input.button.alt:hover,
	.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
	.woocommerce .widget_price_filter .price_slider_amount .button,
	.woocommerce .widget_product_search form input[type='submit'],
	.woocommerce div.product form.cart .button.single_add_to_cart_button,
	.woocommerce #review_form #respond .form-submit input,
	.woocommerce #payment #place_order,
	.woocommerce .cart input.button,
	.woocommerce .cart .coupon input.button:hover,
	.woocommerce .button.wc-forward,
	.woocommerce span.onsale,
	.woocommerce .quantity .plus:hover,
	.woocommerce .quantity .minus:hover,
	.woocommerce a.remove:hover,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
	.cart_items_number,
	.woocommerce mark
	<?php
	endif;
	?>
	{
		background-color: #<?php echo $main_color; ?>;
	}
	.style_5.menu_container,
	.style_5.menu_container .ubermenu .ubermenu-nav li,
	.style_7.menu_container,
	.style_7.menu_container .ubermenu .ubermenu-nav li,
	.style_9.menu_container,
	.style_9.menu_container .ubermenu .ubermenu-nav li
	{
		background-color: #363B40;
		border-color: #363B40;
	}
	.read_more .arrow
	{
		background: #<?php echo $main_color; ?> url("<?php echo get_template_directory_uri(); ?>/images/icons/navigation/call_to_action_arrow.png") no-repeat;
	}
	.accordion .ui-accordion-header:hover .ui-accordion-header-icon
	{
		background: #<?php echo $main_color; ?> url("<?php echo get_template_directory_uri(); ?>/images/icons/navigation/accordion_arrow_down_hover.png") no-repeat 0 0;
	}
	<?php endif;
	if($theme_options["primary_font_custom"]!="" || $theme_options["primary_font"]!=""):
		if($theme_options["primary_font_custom"]!="")
			$primary_font = $theme_options["primary_font_custom"];
		else
		{
			$primary_font_explode = explode(":", $theme_options["primary_font"]);
			$primary_font = $primary_font_explode[0];
		}
	?>
	blockquote,
	label,
	h1, h2, h3, h4, h5, h6,
	.about_title,
	.about_subtitle,
	.menu_container .ubermenu .ubermenu-nav li a, .menu_container .ubermenu-nav li a:visited,
	.site_container .menu_container .ubermenu .ubermenu-nav li ul li a,
	.site_container .menu_container .ubermenu .ubermenu-nav li.ubermenu-active ul li a,
	.site_container .menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-item ul li a,
	.site_container .menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-parent ul li a,
	.site_container .menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor ul li a,
	.site_container .menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-parent.ubermenu-item-has-children ul li a, 
	.site_container .menu_container .ubermenu .ubermenu-nav li.ubermenu-current-menu-ancestor.ubermenu-item-has-children ul li a,
	.site_container .menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children ul li a,
	.site_container .menu_container .ubermenu .ubermenu-nav li.ubermenu-item-has-children:hover ul li a,
	.site_container .menu_container .ubermenu .ubermenu-nav li:hover ul li a,
	.mobile_menu_container .ubermenu .ubermenu-nav li.ubermenu-item a,
	.tabs_navigation li a,
	.scroll_top
	{
		font-family: '<?php echo $primary_font; ?>';
	}
	<?php endif;
	if($theme_options["secondary_font_custom"]!="" || $theme_options["secondary_font"]!=""):
		if($theme_options["secondary_font_custom"]!="")
			$secondary_font = $theme_options["secondary_font_custom"];
		else
		{
			$secondary_font_explode = explode(":", $theme_options["secondary_font"]);
			$secondary_font = $secondary_font_explode[0];
		}
	?>
	.header h1,
	.header .placeholder,
	span.number,
	span.odometer.number,
	.review_summary .number,
	.icon span,
	.gallery_popup .header h1,
	.gallery_popup .header h1 a,
	.gallery_popup .slider_info
	{
		font-family: '<?php echo $secondary_font; ?>';
	}
	<?php endif;
	if($theme_options["text_font_custom"]!="" || $theme_options["text_font"]!=""):
		if($theme_options["text_font_custom"]!="")
			$text_font = $theme_options["text_font_custom"];
		else
		{
			$text_font_explode = explode(":", $theme_options["text_font"]);
			$text_font = $text_font_explode[0];
		}
	?>
	body,
	input, textarea,
	.vc_row  .wpb_column .blog .post .with_number a.comments_number,
	.post_details li,
	.site_container .menu_container .ubermenu .ubermenu-custom-content .blog  ul.post_details.simple li.category a,
	.site_container .menu_container .ubermenu .ubermenu-custom-content .blog .post li.category,
	.site_container .menu_container .ubermenu .ubermenu-custom-content .blog .post li.category a,
	.widget_categories a,
	.widget_tag_cloud a,
	.taxonomies a,
	.value_container .value_bar .number,
	.ui-tooltip-error .ui-tooltip-content,
	.ui-tooltip-success .ui-tooltip-content,
	.more,
	.more[type="submit"],
	.copyright_row, 
	.copyright_row h6
	{
		font-family: '<?php echo $text_font; ?>';
	}
	<?php endif;
	$post_categories = get_categories();
	foreach($post_categories as $post_category)
	{
		$term_id = $post_category->term_id;
		$term_meta = get_option( "taxonomy_$term_id");
		$category_color = $term_meta['color'] ? $term_meta['color'] : '';
		if($category_color!="")
		{
		?>
		body ul.post_details.simple li.category .category-<?php echo $term_id?>,
		body .footer ul.post_details.simple li.category .category-<?php echo $term_id?>
		{
			color: #<?php echo $category_color;?>;
		}
		.post_details.simple li.category.container-category-<?php echo $term_id?>
		{
			background-color: transparent;
		}
		.post_details li.category.container-category-<?php echo $term_id?>
		{
			background-color: #<?php echo $category_color;?>;
		}
		<?php
		}
	}
	?>
</style>