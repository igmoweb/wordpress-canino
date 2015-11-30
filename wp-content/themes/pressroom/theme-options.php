<?php
//admin menu
function pr_theme_admin_menu() 
{
	global $themename;
	add_theme_page(__('Theme Options', 'pressroom') ,__('Theme Options', 'pressroom'), 'edit_theme_options', 'ThemeOptions', $themename . "_options");
}
add_action("admin_menu", "pr_theme_admin_menu");

function pr_theme_stripslashes_deep($value)
{
	$value = is_array($value) ?
				array_map('stripslashes_deep', $value) :
				stripslashes($value);

	return $value;
}

function pressroom_save_options()
{
	global $themename;

	$theme_options = array(
		"logo_url" => $_POST["logo_url"],
		"logo_text" => $_POST["logo_text"],
		"footer_text" => $_POST["footer_text"],
		"sticky_menu" => (int)$_POST["sticky_menu"],
		"responsive" => (int)$_POST["responsive"],
		"layout" => $_POST["layout"],
		"layout_style" => $_POST["layout_style"],
		"layout_image_overlay" => (isset($_POST["layout_image_overlay"]) && $_POST["layout_image_overlay"]!="" ? $_POST["layout_image_overlay"] : "0"),
		"style_selector" => $_POST["style_selector"],
		"direction" => $_POST["direction"],
		"cf_admin_name" => $_POST["cf_admin_name"],
		"cf_admin_email" => $_POST["cf_admin_email"],
		"cf_smtp_host" => $_POST["cf_smtp_host"],
		"cf_smtp_username" => $_POST["cf_smtp_username"],
		"cf_smtp_password" => $_POST["cf_smtp_password"],
		"cf_smtp_port" => $_POST["cf_smtp_port"],
		"cf_smtp_secure" => $_POST["cf_smtp_secure"],
		"cf_email_subject" => $_POST["cf_email_subject"],
		"cf_template" => $_POST["cf_template"],
		"color_scheme" => $_POST["color_scheme"],
		"font_size_selector" => $_POST["font_size_selector"],
		"site_background_color" => $_POST["site_background_color"],
		"main_color" => $_POST["main_color"],
		"header_style" => $_POST["header_style"],
		"header_top_sidebar" => $_POST["header_top_sidebar"],
		"header_top_right_sidebar" => $_POST["header_top_right_sidebar"],
		"primary_font" => $_POST["primary_font"],
		"primary_font_custom" => $_POST["primary_font_custom"],
		"secondary_font" => $_POST["secondary_font"],
		"secondary_font_custom" => $_POST["secondary_font_custom"],
		"text_font" => $_POST["text_font"],
		"text_font_custom" => $_POST["text_font_custom"]
	);
	$theme_options["header_top_bar_container"] = "";
	$theme_options["header_container"] = "";
	$theme_options["menu_container"] = "";
	if($_POST["header_style"]=="style_1" && $_POST["color_scheme"]=="dark")
	{
		$theme_options["header_top_bar_container"] = "style_4";
		$theme_options["header_container"] = "style_2";
	}
	else if($_POST["header_style"]=="style_2")
	{
		if($_POST["color_scheme"]=="dark")
		{
			$theme_options["header_top_bar_container"] = "style_4";
			$theme_options["header_container"] = "style_2";
		}
		$theme_options["menu_container"] = "style_2";
	}
	else if($_POST["header_style"]=="style_3")
	{
		if($_POST["color_scheme"]=="dark")
		{
			$theme_options["header_top_bar_container"] = "style_4";
			$theme_options["header_container"] = "style_2";
		}
		else
			$theme_options["header_top_bar_container"] = "style_2 border";
		$theme_options["menu_container"] = "style_3";
	}
	else if($_POST["header_style"]=="style_4")
	{
		if($_POST["color_scheme"]=="dark")
		{
			$theme_options["header_top_bar_container"] = "style_4";
			$theme_options["header_container"] = "style_2 small";
		}
		else
			$theme_options["header_container"] = "small";
		$theme_options["menu_container"] = "style_4";
	}
	else if($_POST["header_style"]=="style_4")
	{
		if($_POST["color_scheme"]=="dark")
		{
			$theme_options["header_top_bar_container"] = "style_4";
			$theme_options["header_container"] = "style_2";
		}
		$theme_options["menu_container"] = "style_4";
	}
	else if($_POST["header_style"]=="style_5")
	{
		if($_POST["color_scheme"]=="dark")
		{
			$theme_options["header_top_bar_container"] = "style_4";
			$theme_options["header_container"] = "style_2";
		}
		else
			$theme_options["header_top_bar_container"] = "style_3";
		$theme_options["menu_container"] = "style_9";
	}
	else if($_POST["header_style"]=="style_6")
	{
		if($_POST["color_scheme"]=="dark")
		{
			$theme_options["header_top_bar_container"] = "style_4";
			$theme_options["header_container"] = "style_2";
		}
		else
			$theme_options["header_top_bar_container"] = "style_3";
		$theme_options["menu_container"] = "style_6";
	}
	else if($_POST["header_style"]=="style_7")
	{
		if($_POST["color_scheme"]=="dark")
		{
			$theme_options["header_top_bar_container"] = "style_4";
			$theme_options["header_container"] = "style_2 small";
		}
		else
		{
			$theme_options["header_top_bar_container"] = "style_2 border";
			$theme_options["header_container"] = "small";
		}
		$theme_options["menu_container"] = "style_7";
	}
	else if($_POST["header_style"]=="style_8")
	{
		if($_POST["color_scheme"]=="dark")
			$theme_options["header_top_bar_container"] = "style_4";
		else
			$theme_options["header_top_bar_container"] = "border";
		$theme_options["header_container"] = "style_2";
		$theme_options["menu_container"] = "style_8";
	}
	else if($_POST["header_style"]=="style_9")
	{
		if($_POST["color_scheme"]=="dark")
			$theme_options["header_top_bar_container"] = "style_4";
		else
			$theme_options["header_top_bar_container"] = "border";
		$theme_options["header_container"] = "style_2 small";
		$theme_options["menu_container"] = "style_7";
	}
	else if($_POST["header_style"]=="style_10")
	{
		if($_POST["color_scheme"]=="dark")
			$theme_options["header_top_bar_container"] = "style_4";
		else
			$theme_options["header_top_bar_container"] = "style_2";
		$theme_options["header_container"] = "style_2";
		$theme_options["menu_container"] = "style_9";
	}
	else if($_POST["header_style"]=="style_11")
	{
		if($_POST["color_scheme"]=="dark")
		{
			$theme_options["header_top_bar_container"] = "style_4";
			$theme_options["header_container"] = "style_2 small";
		}
		else
			$theme_options["header_container"] = "small";
	}
	else if($_POST["header_style"]=="style_12")
	{
		if($_POST["color_scheme"]=="dark")
		{
			$theme_options["header_top_bar_container"] = "style_4";
			$theme_options["header_container"] = "style_2 small";
		}
		else
		{
			$theme_options["header_top_bar_container"] = "style_2 border";
			$theme_options["header_container"] = "small";
		}
		$theme_options["menu_container"] = "style_2";
	}
	else if($_POST["header_style"]=="style_13")
	{
		if($_POST["color_scheme"]=="dark")
		{
			$theme_options["header_top_bar_container"] = "style_4";
			$theme_options["header_container"] = "style_2";
		}
		else
			$theme_options["header_top_bar_container"] = "style_3";
		$theme_options["menu_container"] = "style_8";
	}
	else if($_POST["header_style"]=="style_14")
	{
		if($_POST["color_scheme"]=="dark")
		{
			$theme_options["header_top_bar_container"] = "style_4";
			$theme_options["header_container"] = "style_2";
		}
		else
			$theme_options["header_top_bar_container"] = "style_2 border";
		$theme_options["menu_container"] = "style_5";
	}
	else if($_POST["header_style"]=="style_15")
	{
		if($_POST["color_scheme"]=="dark")
			$theme_options["header_top_bar_container"] = "style_4";
		else
			$theme_options["header_top_bar_container"] = "border";
		$theme_options["header_container"] = "style_2 small";
		$theme_options["menu_container"] = "style_10";
	}
	else if($_POST["header_style"]=="style_high_contrast")
	{
		$theme_options["header_top_bar_container"] = "style_5 border";
		$theme_options["header_container"] = "style_3";
	}
	
	if($_POST["color_scheme"]=="high_contrast")
	{
		$theme_options["header_top_bar_container"] = "style_5 border";
		$theme_options["header_container"] = "style_3";
		$theme_options["menu_container"] = "";
	}
	update_option($themename . "_options", $theme_options);
	echo json_encode($_POST);
	exit();
}
add_action('wp_ajax_' . $themename . '_save', $themename . '_save_options');

function pr_get_new_widget_name( $widget_name, $widget_index ) 
{
	$current_sidebars = get_option( 'sidebars_widgets' );
	$all_widget_array = array( );
	foreach ( $current_sidebars as $sidebar => $widgets ) {
		if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
			foreach ( $widgets as $widget ) {
				$all_widget_array[] = $widget;
			}
		}
	}
	while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
		$widget_index++;
	}
	$new_widget_name = $widget_name . '-' . $widget_index;
	return $new_widget_name;
}
function pr_download_import_file($file)
{	
	$url = "http://quanticalabs.com/wptest/pressroom/files/2015/01/" . $file["name"] . "." . $file["extension"];
	$attachment = get_page_by_title($file["name"], "OBJECT", "attachment");
	if($attachment!=null)
		$id = $attachment->ID;
	else
	{
		$tmp = download_url($url);
		$file_array = array(
			'name' => basename($url),
			'tmp_name' => $tmp
		);

		// Check for download errors
		if(is_wp_error($tmp)) 
		{
			@unlink($file_array['tmp_name']);
			return $tmp;
		}

		$id = media_handle_sideload($file_array, 0);
		// Check for handle sideload errors.
		if(is_wp_error($id))
		{
			@unlink($file_array['tmp_name']);
			return $id;
		}
	}
    return get_attached_file($id);
}
function pressroom_import_shop_dummy()
{
	$result = array("info" => "");
	//import dummy content
	$fetch_attachments = true;
	$file = pr_download_import_file(array(
		"name" => "dummy-shop",
		"extension" => "xml"
	));
	if(!is_wp_error($file))
		require_once(locate_template('importer/importer.php'));
	else
		$result["info"] = "Import file dummy_shop.xml not found! Please upload import file manually into Media library. You can find this file in 'dummy content files' directory inside zip archive downloaded from ThemeForest.";
	if($result["info"]=="")
		$result["info"] = "dummy_shop.xml file content has been imported successfully!";
	echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
	exit();
}
add_action('wp_ajax_' . $themename . '_import_shop_dummy', $themename . '_import_shop_dummy');
function pressroom_import_dummy()
{
	$result = array("info" => "");
	//import dummy content
	$fetch_attachments = true;
	$file = pr_download_import_file(array(
		"name" => "dummy-images",
		"extension" => "xml"
	));
	if(!is_wp_error($file))
		require_once(locate_template('importer/importer.php'));
	else
		$result["info"] = "Import file dummy_images.xml not found! Please upload import file manually into Media library. You can find this file in 'dummy content files' directory inside zip archive downloaded from ThemeForest.";
	if($result["info"]=="")
		$result["info"] = "dummy_images.xml file content has been imported successfully!";
	echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
	exit();
}
add_action('wp_ajax_' . $themename . '_import_dummy', $themename . '_import_dummy');

function pressroom_import_dummy2()
{
	global $themename;
	$result = array("info" => "");
	//import dummy content
	$fetch_attachments = false;
	$file = pr_download_import_file(array(
		"name" => "dummy-data",
		"extension" => "xml"
	));
	if(!is_wp_error($file))
		require_once(locate_template('importer/importer.php'));
	else
	{
		$result["info"] .= "Import file: dummy-data.xml not found! Please upload import file manually into Media library. You can find this file in 'dummy content files' directory inside zip archive downloaded from ThemeForest.";
		exit();
	}
	//set menu
	$locations = get_theme_mod('nav_menu_locations');
	$menus = wp_get_nav_menus();
	foreach($menus as $menu)
		$locations[$menu->slug] = $menu->term_id;
	
	set_theme_mod('nav_menu_locations', $locations);
	//set front page
	$home = get_page_by_title('HOME');
	update_option('page_on_front', $home->ID);
	update_option('show_on_front', 'page');
	//set blog description
	update_option("blogdescription", "News and Magazine Theme");
	//set top sidebar
	$theme_sidebars_array = get_posts(array(
		'post_type' => 'pressroom_sidebars',
		'posts_per_page' => '-1',
		'nopaging' => true,
		'post_status' => 'publish',
		'orderby' => 'menu_order',
		'order' => 'ASC'
	));
	$theme_options = get_option($themename . "_options", true);
	$needed_id = 0;
	foreach($theme_sidebars_array as $theme_sidebar)
	{	
		if($theme_sidebar->post_title=="Sidebar Header")
		{
			$needed_id = $theme_sidebar->ID;
			break;
		}
	}
	$theme_options["header_top_sidebar"] = $needed_id;
	$needed_id = 0;
	foreach($theme_sidebars_array as $theme_sidebar)
	{	
		if($theme_sidebar->post_title=="Sidebar Header Right")
		{
			$needed_id = $theme_sidebar->ID;
			break;
		}
	}
	$theme_options["header_top_right_sidebar"] = $needed_id;
	update_option($themename . "_options", $theme_options);
	
	//widget import
	$response = array(
		'what' => 'widget_import_export',
		'action' => 'import_submit'
	);

	$widgets = isset( $_POST['widgets'] ) ? $_POST['widgets'] : false;
	$json_file = pr_download_import_file(array(
		"name" => "widget_data",
		"extension" => "json"
	));
	if(!is_wp_error($json_file))
	{
		$json_data = file_get_contents($json_file);
		$json_data = json_decode( $json_data, true );
		$sidebars_data = $json_data[0];
		$widget_data = $json_data[1];
		$current_sidebars = get_option( 'sidebars_widgets' );
		//remove inactive widgets
		$current_sidebars['wp_inactive_widgets'] = array();
		update_option('sidebars_widgets', $current_sidebars);
		$new_widgets = array( );
		foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

			foreach ( $import_widgets as $import_widget ) :
				//if the sidebar exists
				//if ( isset( $current_sidebars[$import_sidebar] ) ) :
					$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
					$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
					$current_widget_data = get_option( 'widget_' . $title );
					$new_widget_name = pr_get_new_widget_name( $title, $index );
					$new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

					if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
						while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
							$new_index++;
						}
					}
					$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
					if ( array_key_exists( $title, $new_widgets ) ) {
						$new_widgets[$title][$new_index] = $widget_data[$title][$index];
						$multiwidget = $new_widgets[$title]['_multiwidget'];
						unset( $new_widgets[$title]['_multiwidget'] );
						$new_widgets[$title]['_multiwidget'] = $multiwidget;
					} else {
						$current_widget_data[$new_index] = $widget_data[$title][$index];
						$current_multiwidget = $current_widget_data['_multiwidget'];
						$new_multiwidget = $widget_data[$title]['_multiwidget'];
						$multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
						unset( $current_widget_data['_multiwidget'] );
						$current_widget_data['_multiwidget'] = $multiwidget;
						$new_widgets[$title] = $current_widget_data;
					}

				//endif;
			endforeach;
		endforeach;
		if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
			update_option( 'sidebars_widgets', $current_sidebars );

			foreach ( $new_widgets as $title => $content )
				update_option( 'widget_' . $title, $content );

		}
	}
	else
	{
		$result["info"] .= "Widgets data file not found! Please upload widgets data file manually.";
		exit();
	}
	if($result["info"]=="")
	{
		//set shop page
		$shop = get_page_by_title('Shop');
		update_option('woocommerce_shop_page_id', $shop->ID);
		//set my-account page
		$myaccount = get_page_by_title('My Account');
		update_option('woocommerce_myaccount_page_id', $myaccount->ID);
		//set cart page
		$cart = get_page_by_title('Cart');
		update_option('woocommerce_cart_page_id', $cart->ID);
		//set checkout page
		$checkout = get_page_by_title('Checkout');
		update_option('woocommerce_checkout_page_id', $checkout->ID);
		
		$hide_notice = sanitize_text_field("install");
		$notices = array_diff(get_option('woocommerce_admin_notices', array()), array("install"));
		update_option('woocommerce_admin_notices', $notices);
		do_action('woocommerce_hide_install_notice');
		
		$result["info"] = "dummy-data.xml file content and widgets settings has been imported successfully!";
	}
	echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
	exit();
}
add_action('wp_ajax_' . $themename . '_import_dummy2', $themename . '_import_dummy2');

function pressroom_options() 
{
	global $themename;
	
	$theme_options = array(
		"logo_url" => '',
		"logo_text" => '',
		"footer_text" => '',
		"sticky_menu" => '',
		"responsive" => '',
		"layout" => '',
		"layout_style" => '',
		"layout_image_overlay" => '',
		"style_selector" => '',
		"direction" => '',
		"cf_admin_name" => '',
		"cf_admin_email" => '',
		"cf_smtp_host" => '',
		"cf_smtp_username" => '',
		"cf_smtp_password" => '',
		"cf_smtp_port" => '',
		"cf_smtp_secure" => '',
		"cf_email_subject" => '',
		"cf_template" => '',
		"color_scheme" => '',
		"font_size_selector" => '',
		"site_background_color" => '',
		"main_color" => '',
		"header_style" => '',
		"header_top_sidebar" => '',
		"header_top_right_sidebar" => '',
		"primary_font" => '',
		"primary_font_custom" => '',
		"secondary_font" => '',
		"secondary_font_custom" => '',
		"text_font" => '',
		"text_font_custom" => ''
	);
	$theme_options = pr_theme_stripslashes_deep(array_merge($theme_options, get_option($themename . "_options")));

	if(isset($_POST["action"]) && $_POST["action"]==$themename . "_save")
	{
	?>
	<div class="updated"> 
		<p>
			<strong>
				<?php _e('Options saved', 'pressroom'); ?>
			</strong>
		</p>
	</div>
	<?php
	}
	//get google fonts
	$fontsArray = get_option($themename . "_google_fonts");
	//update if option doesn't exist or it was modified more than 2 weeks ago
	if($fontsArray===FALSE || (time()-$fontsArray->last_update>2*7*24*60*60)) 
	{
		$google_api_url = 'http://quanticalabs.com/.tools/GoogleFont/font.txt';
		$fontsJson = wp_remote_retrieve_body(wp_remote_get($google_api_url, array('sslverify' => false )));
		$fontsArray = json_decode($fontsJson);
		$fontsArray->last_update = time();		
		update_option($themename . "_google_fonts", $fontsArray);
	}

	//$fontsJson = file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyB4_VClnbxilxqjZd7NbysoHwAXX1ZGdKQ');
	//$fontsArray = json_decode($fontsJson);
	?>
	<form class="theme_options" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="theme-options-panel">
		<div class="header">
			<div class="header_left">
				<h3>
					<a href="http://themeforest.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs" title="QuanticaLabs">
						QuanticaLabs
					</a>
				</h3>
				<h5>Theme Options</h5>
			</div>
			<div class="header_right">
				<div class="description">
					<h3>
						<a href="http://themeforest.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs" title="Pressroom - News and Magazine Theme">
							Pressroom - Responsive News and Magazine Theme
						</a>
					</h3>
					<h5>Version 1.8</h5>
					<a class="description_link" target="_blank" href="<?php echo esc_url(get_template_directory_uri() . '/documentation/index.html'); ?>">Documentation</a>
					<a class="description_link" target="_blank" href="http://support.quanticalabs.com">Support Forum</a>
					<a class="description_link" target="_blank" href="http://themeforest.net/item/pressroom-news-and-magazine-wordpress-theme/10678098?ref=QuanticaLabs">Theme site</a>
				</div>
				<a class="logo" href="http://themeforest.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs" title="QuanticaLabs">
					&nbsp;
				</a>
			</div>
		</div>
		<div class="content clearfix">
			<ul class="menu">
				<li>
					<a href='#tab-main' class="selected">
						<span class="dashicons dashicons-hammer"></span>
						<?php _e('Main', 'pressroom'); ?>
					</a>
				</li>
				<li>
					<a href="#tab-email-config">
						<span class="dashicons dashicons-email-alt"></span>
						<?php _e('Email Config', 'pressroom'); ?>
					</a>
				</li>
				<li>
					<a href="#tab-colors">
						<span class="dashicons dashicons-art"></span>
						<?php _e('Colors', 'pressroom'); ?>
					</a>
				</li>
				<li>
					<a href="#tab-header">
						<span class="dashicons dashicons-welcome-widgets-menus"></span>
						<?php _e('Header', 'pressroom'); ?>
					</a>
				</li>
				<li>
					<a href="#tab-fonts">
						<span class="dashicons dashicons-editor-textcolor"></span>
						<?php _e('Fonts', 'pressroom'); ?>
					</a>
				</li>
			</ul>
			<div id="tab-main" class="settings" style="display: block;">
				<h3><?php _e('Main', 'pressroom'); ?></h3>
				<ul class="form_field_list">
					<li>
						<label for="import_dummy"><?php _e('DUMMY CONTENT IMPORT', 'pressroom'); ?></label>
						<input type="button" class="button" name="<?php echo esc_attr($themename);?>_import_dummy" id="import_dummy" value="<?php esc_attr_e('Import dummy content', 'pressroom'); ?>" />
						<img id="dummy_content_preloader" src="<?php echo get_template_directory_uri();?>/admin/images/ajax-loader.gif" />
						<img id="dummy_content_tick" src="<?php echo get_template_directory_uri();?>/admin/images/tick.png" />
						<div id="dummy_content_info"></div>
					</li>
					<?php
					if(is_plugin_active('woocommerce/woocommerce.php')):
					?>
					<li>
						<label for="import_shop_dummy"><?php _e('DUMMY SHOP CONTENT IMPORT', 'pressroom'); ?></label>
						<input type="button" class="button" name="<?php echo esc_attr($themename);?>_import_shop_dummy" id="import_shop_dummy" value="<?php esc_attr_e('Import shop dummy content', 'pressroom'); ?>" />
						<img id="dummy_shop_content_preloader" src="<?php echo get_template_directory_uri();?>/admin/images/ajax-loader.gif" />
						<img id="dummy_shop_content_tick" src="<?php echo get_template_directory_uri();?>/admin/images/tick.png" />
						<div id="dummy_shop_content_info"></div>
					</li>
					<?php
					endif;
					?>
					<li>
						<label for="logo_url"><?php _e('LOGO URL', 'pressroom'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["logo_url"]); ?>" id="logo_url" name="logo_url">
							<input type="button" class="button" name="<?php echo esc_attr($themename);?>_upload_button" id="logo_url_upload_button" value="<?php esc_attr_e('Insert logo', 'pressroom'); ?>" />
						</div>
					</li>
					<li>
						<label for="logo_text"><?php _e('LOGO TEXT', 'pressroom'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["logo_text"]); ?>" id="logo_text" name="logo_text">
						</div>
					</li>
					<li>
						<label for="footer_text"><?php _e('FOOTER TEXT', 'pressroom'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["footer_text"]); ?>" id="footer_text" name="footer_text">
						</div>
					</li>
					<li>
						<label for="sticky_menu"><?php _e('STICKY MENU', 'pressroom'); ?></label>
						<div>
							<select id="sticky_menu" name="sticky_menu">
								<option value="0"<?php echo ((int)$theme_options["sticky_menu"]==0 ? " selected='selected'" : "") ?>><?php _e('no', 'pressroom'); ?></option>
								<option value="1"<?php echo ((int)$theme_options["sticky_menu"]==1 ? " selected='selected'" : "") ?>><?php _e('yes', 'pressroom'); ?></option>
							</select>
						</div>
					</li>
					<li>
						<label for="responsive"><?php _e('RESPONSIVE', 'pressroom'); ?></label>
						<div>
							<select id="responsive" name="responsive">
								<option value="1"<?php echo ((int)$theme_options["responsive"]==1 ? " selected='selected'" : "") ?>><?php _e('yes', 'pressroom'); ?></option>
								<option value="0"<?php echo ((int)$theme_options["responsive"]==0 ? " selected='selected'" : "") ?>><?php _e('no', 'pressroom'); ?></option>
							</select>
						</div>
					</li>
					<li>
						<label for="layout"><?php _e('LAYOUT', 'pressroom'); ?></label>
						<div>
							<select id="layout" name="layout">
								<option value="fullwidth"<?php echo ($theme_options["layout"]=="fullwidth" ? " selected='selected'" : "") ?>><?php _e('full width', 'pressroom'); ?></option>
								<option value="boxed"<?php echo ($theme_options["layout"]=="boxed" ? " selected='selected'" : "") ?>><?php _e('boxed', 'pressroom'); ?></option>
							</select>
						</div>
					</li>
					<li class="boxed_bg_image clearfix"<?php echo ($theme_options["layout"]!="boxed" ? ' style="display: none;"' : ''); ?>>
						<label for="layout"><?php _e('BOXED LAYOUT BACKGROUND', 'pressroom');?></label>
						<div>
							<label class="small_label"><?php _e("Boxed Layout Background Color", 'pressroom'); ?></label>
							<div<?php echo (isset($theme_options['layout_style']) && $theme_options['layout_style']=='color_preview' ? ' class="selected"' : ''); ?>>
								<a href="#" class="color_preview" style="background-color: #<?php echo ($theme_options["site_background_color"]!="" ? esc_attr($theme_options["site_background_color"]) : 'F0F0F0'); ?>;"><span class="tick"></span></a>
								<input type="text" class="regular-text color short" value="<?php echo esc_attr($theme_options["site_background_color"]); ?>" id="site_background_color" name="site_background_color" data-default-color="F0F0F0">
							</div>
							<br>
							<label class="small_label"><?php _e("Boxed Layout Pattern", 'pressroom'); ?></label>
							<ul class="layout_chooser clearfix">
								<li<?php echo (isset($theme_options['layout_style']) && $theme_options['layout_style']=='pattern_1' ? ' class="selected"' : ''); ?>>
									<a href="#" class="pattern_1">
										<span class="tick"></span>
									</a>
								</li>
								<li<?php echo (isset($theme_options['layout_style']) && $theme_options['layout_style']=='pattern_2' ? ' class="selected"' : ''); ?>>
									<a href="#" class="pattern_2">
										<span class="tick"></span>
									</a>
								</li>
								<li<?php echo (isset($theme_options['layout_style']) && $theme_options['layout_style']=='pattern_3' ? ' class="selected"' : ''); ?>>
									<a href="#" class="pattern_3">
										<span class="tick"></span>
									</a>
								</li>
								<li<?php echo (isset($theme_options['layout_style']) && $theme_options['layout_style']=='pattern_4' ? ' class="selected"' : ''); ?>>
									<a href="#" class="pattern_4">
										<span class="tick"></span>
									</a>
								</li>
								<li<?php echo (isset($theme_options['layout_style']) && $theme_options['layout_style']=='pattern_5' ? ' class="selected"' : ''); ?>>
									<a href="#" class="pattern_5">
										<span class="tick"></span>
									</a>
								</li>
								<li class="first<?php echo (isset($theme_options['layout_style']) && $theme_options['layout_style']=='pattern_6' ? ' selected' : ''); ?>">
									<a href="#" class="pattern_6">
										<span class="tick"></span>
									</a>
								</li>
								<li<?php echo (isset($theme_options['layout_style']) && $theme_options['layout_style']=='pattern_7' ? ' class="selected"' : ''); ?>>
									<a href="#" class="pattern_7">
										<span class="tick"></span>
									</a>
								</li>
								<li<?php echo (isset($theme_options['layout_style']) && $theme_options['layout_style']=='pattern_8' ? ' class="selected"' : ''); ?>>
									<a href="#" class="pattern_8">
										<span class="tick"></span>
									</a>
								</li>
								<li<?php echo (isset($theme_options['layout_style']) && $theme_options['layout_style']=='pattern_9' ? ' class="selected"' : ''); ?>>
									<a href="#" class="pattern_9">
										<span class="tick"></span>
									</a>
								</li>
								<li<?php echo (isset($theme_options['layout_style']) && $theme_options['layout_style']=='pattern_10' ? ' class="selected"' : ''); ?>>
									<a href="#" class="pattern_10">
										<span class="tick"></span>
									</a>
								</li>
							</ul>
							<label class="small_label"><?php _e("Boxed Layout Image", 'pressroom'); ?></label>
							<ul class="layout_chooser clearfix">
								<li<?php echo (!isset($theme_options['layout_style']) || (isset($theme_options['layout_style']) && $theme_options['layout_style']=='image_1') ? ' class="selected"' : ''); ?>>
									<a href="#" class="image_1">
										<span class="tick"></span>
									</a>
								</li>
								<li<?php echo (isset($theme_options['layout_style']) && $theme_options['layout_style']=='image_2' ? ' class="selected"' : ''); ?>>
									<a href="#" class="image_2">
										<span class="tick"></span>
									</a>
								</li>
								<li<?php echo (isset($theme_options['layout_style']) && $theme_options['layout_style']=='image_3' ? ' class="selected"' : ''); ?>>
									<a href="#" class="image_3">
										<span class="tick"></span>
									</a>
								</li>
								<li<?php echo (isset($theme_options['layout_style']) && $theme_options['layout_style']=='image_4' ? ' class="selected"' : ''); ?>>
									<a href="#" class="image_4">
										<span class="tick"></span>
									</a>
								</li>
								<li<?php echo (isset($theme_options['layout_style']) && $theme_options['layout_style']=='image_5' ? ' class="selected"' : ''); ?>>
									<a href="#" class="image_5">
										<span class="tick"></span>
									</a>
								</li>
								<li class="first">
									<input type="checkbox"<?php echo ((isset($theme_options['layout_image_overlay']) && $theme_options['layout_image_overlay']=='overlay') || !isset($theme_options['layout_image_overlay']) ? ' checked="checked"' : ''); ?> id="overlay" name="layout_image_overlay" value="overlay"><label class="overlay_label small_label" for="overlay"><?php _e("overlay", 'pressroom'); ?></label>
								</li>
							</ul>
							<input type="hidden" name="layout_style" id="layout_style_input" value="<?php echo esc_attr($theme_options['layout_style']); ?>">
						</div>
					</li>
					<li>
						<label for="style_selector"><?php _e('SHOW STYLE SELECTOR', 'pressroom'); ?></label>
						<div>
							<select id="style_selector" name="style_selector">
								<option value="0"<?php echo (!(int)$theme_options["style_selector"] ? " selected='selected'" : "") ?>><?php _e('no', 'pressroom'); ?></option>
								<option value="1"<?php echo ((int)$theme_options["style_selector"] ? " selected='selected'" : "") ?>><?php _e('yes', 'pressroom'); ?></option>
							</select>
						</div>
					</li>
					<li>
						<label for="direction"><?php _e('Direction', 'pressroom'); ?></label>
						<div>
							<select id="direction" name="direction">
								<option value="default" <?php echo ($theme_options["direction"]=="default" ? " selected='selected'" : "") ?>><?php _e('Default', 'pressroom'); ?></option>
								<option value="ltr" <?php echo ($theme_options["direction"]=="ltr" ? " selected='selected'" : "") ?>><?php _e('LTR', 'pressroom'); ?></option>
								<option value="rtl" <?php echo ($theme_options["direction"]=="rtl" ? " selected='selected'" : "") ?>><?php _e('RTL', 'pressroom'); ?></option>	
							</select>
						</div>
					</li>
				</ul>
			</div>
			<div id="tab-email-config" class="settings">
				<h3><?php _e('Contact Form', 'pressroom'); ?></h3>
				<h4><?php _e('ADMIN EMAIL CONFIG', 'pressroom'); ?></h4>
				<ul class="form_field_list">
					<li>
						<label for="cf_admin_name"><?php _e('NAME', 'pressroom'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_admin_name"]); ?>" id="cf_admin_name" name="cf_admin_name">
						</div>
					</li>
					<li>
						<label for="cf_admin_email"><?php _e('EMAIL', 'pressroom'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_admin_email"]); ?>" id="cf_admin_email" name="cf_admin_email">
						</div>
					</li>
				</ul>
				<h4><?php _e('ADMIN SMTP CONFIG (OPTIONAL)', 'pressroom'); ?></h4>
				<ul class="form_field_list">
					<li>
						<label for="cf_smtp_host"><?php _e('HOST', 'pressroom'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_smtp_host"]); ?>" id="cf_smtp_host" name="cf_smtp_host">
						</div>
					</li>
					<li>
						<label for="cf_smtp_username"><?php _e('USERNAME', 'pressroom'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_smtp_username"]); ?>" id="cf_smtp_username" name="cf_smtp_username">
						</div>
					</li>
					<li>
						<label for="cf_smtp_password"><?php _e('PASSWORD', 'pressroom'); ?></label>
						<div>
							<input type="password" class="regular-text" value="<?php echo esc_attr($theme_options["cf_smtp_password"]); ?>" id="cf_smtp_password" name="cf_smtp_password">
						</div>
					</li>
					<li>
						<label for="cf_smtp_port"><?php _e('PORT', 'pressroom'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_smtp_port"]); ?>" id="cf_smtp_port" name="cf_smtp_port">
						</div>
					</li>
					<li>
						<label for="cf_smtp_secure"><?php _e('SMTP SECURE', 'pressroom'); ?></label>
						<div>
							<select id="cf_smtp_secure" name="cf_smtp_secure">
								<option value=""<?php echo ($theme_options["cf_smtp_secure"]=="" ? " selected='selected'" : "") ?>>-</option>
								<option value="ssl"<?php echo ($theme_options["cf_smtp_secure"]=="ssl" ? " selected='selected'" : "") ?>><?php _e('ssl', 'pressroom'); ?></option>
								<option value="tls"<?php echo ($theme_options["cf_smtp_secure"]=="tls" ? " selected='selected'" : "") ?>><?php _e('tls', 'pressroom'); ?></option>
							</select>
						</div>
					</li>
				</ul>
				<h4><?php _e('EMAIL CONFIG', 'pressroom'); ?></h4>
				<ul class="form_field_list">
					<li>
						<label for="cf_email_subject"><?php _e('EMAIL SUBJECT', 'pressroom'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_email_subject"]); ?>" id="cf_email_subject" name="cf_email_subject">
						</div>
					</li>
					<li>
						<label for="cf_template"><?php _e('TEMPLATE', 'pressroom'); ?></label>
						<div>
							<?php _e("Available shortcodes:", 'pressroom'); ?><br><strong>[name]</strong>, <strong>[email]</strong>, <strong>[message]</strong><br><br>
							<?php wp_editor($theme_options["cf_template"], "cf_template");?>
						</div>
					</li>
				</ul>
			</div>
			<div id="tab-colors" class="settings">
				<h3><?php _e('Colors', 'pressroom'); ?></h3>
				<ul class="form_field_list">
					<li>
						<label for="color_scheme"><?php _e('Color scheme', 'pressroom'); ?></label>
						<div>
							<select id="color_scheme" name="color_scheme">
								<option value="light"<?php echo ($theme_options["color_scheme"]=="light" ? " selected='selected'" : "") ?>><?php _e('light (default)', 'pressroom'); ?></option>
								<option value="dark"<?php echo ($theme_options["color_scheme"]=="dark" ? " selected='selected'" : "") ?>><?php _e('dark', 'pressroom'); ?></option>
								<option value="high_contrast"<?php echo ($theme_options["color_scheme"]=="high_contrast" ? " selected='selected'" : "") ?>><?php _e('high contrast', 'pressroom'); ?></option>
							</select>
						</div>
					</li>
					<li class="high_contrast_font_size"<?php echo ($theme_options["color_scheme"]!="high_contrast" ? ' style="display: none;"' : ''); ?>>
						<label class="small_label"><?php _e("Font size selector", 'pressroom'); ?></label>
						<div>
							<select id="font_size_selector" name="font_size_selector">
								<option value="yes"<?php echo ($theme_options["font_size_selector"]=="yes" ? " selected='selected'" : "") ?>><?php _e('yes', 'pressroom'); ?></option>
								<option value="no"<?php echo ($theme_options["font_size_selector"]=="no" ? " selected='selected'" : "") ?>><?php _e('no', 'pressroom'); ?></option>
							</select>
						</div>
					<li>
						<label for="main_color"><?php _e('Main color', 'pressroom'); ?></label>
						<div>
							<span class="color_preview" style="background-color: #<?php echo ($theme_options["main_color"]!="" ? esc_attr($theme_options["main_color"]) : 'ED1C24'); ?>;"></span>
							<input type="text" class="regular-text color short margin_top_0" value="<?php echo esc_attr($theme_options["main_color"]); ?>" id="main_color" name="main_color" data-default-color="ED1C24">
						</div>
						<div>
							<br>
							<label class="small_label"><?php _e("Choose from predefined colors", 'pressroom'); ?></label>
							<ul class="layout_chooser for_main_color clearfix">
								<li>
									<a href="#" class="color_preview" style="background-color: #42AAE6;" data-color="42AAE6">&nbsp;</a>
								</li>
								<li>
									<a href="#" class="color_preview" style="background-color: #85B53E;" data-color="85B53E">&nbsp;</a>
								</li>
								<li>
									<a href="#" class="color_preview" style="background-color: #F5910F;" data-color="F5910F">&nbsp;</a>
								</li>
								<li>
									<a href="#" class="color_preview" style="background-color: #18ACB6;" data-color="18ACB6">&nbsp;</a>
								</li>
								<li>
									<a href="#" class="color_preview" style="background-color: #4CA5D9;" data-color="4CA5D9">&nbsp;</a>
								</li>
								<li>
									<a href="#" class="color_preview" style="background-color: #FC724B;" data-color="FC724B">&nbsp;</a>
								</li>
								<li>
									<a href="#" class="color_preview" style="background-color: #C29A48;" data-color="C29A48">&nbsp;</a>
								</li>
								<li>
									<a href="#" class="color_preview" style="background-color: #00C7A6;" data-color="00C7A6">&nbsp;</a>
								</li>
							</ul>
						</div>
					</li>
				</ul>
			</div>
			<div id="tab-header" class="settings">
				<h3><?php _e('Header', 'pressroom'); ?></h3>
				<ul class="form_field_list">
					<li class="header_style_container"<?php echo ($theme_options["color_scheme"]=="high_contrast" ? ' style="display: none;"' : ''); ?>>
						<label for="header_style"><?php _e('Header style', 'pressroom'); ?></label>
						<div>
							<select id="header_style" name="header_style">
								<?php
								for($i=0; $i<15; $i++)
								{
								?>
								<option<?php echo ($theme_options["header_style"]=="style_" . ($i+1) ? " selected='selected'" : ""); ?>  value="style_<?php echo ($i+1);?>"><?php _e("Style " . ($i+1), 'pressroom'); ?></option>
								<?php
								}
								?>
								<option<?php echo ($theme_options["header_style"]=="style_high_contrast" ? " selected='selected'" : ""); ?>  value="style_high_contrast"><?php _e("Style high contrast", 'pressroom'); ?></option>
							</select>
						</div>
					</li>
					<li>
						<label for="header_top_sidebar"><?php _e('Header top sidebar', 'pressroom'); ?></label>
						<div>
						<?php
						//get theme sidebars
						$theme_sidebars = array();
						$theme_sidebars_array = get_posts(array(
							'post_type' => 'pressroom_sidebars',
							'posts_per_page' => '-1',
							'nopaging' => true,
							'post_status' => 'publish',
							'orderby' => 'menu_order',
							'order' => 'ASC'
						));
						for($i=0; $i<count($theme_sidebars_array); $i++)
						{
							$theme_sidebars[$i]["id"] = $theme_sidebars_array[$i]->ID;
							$theme_sidebars[$i]["title"] = $theme_sidebars_array[$i]->post_title;
						}
						?>
						<select id="header_top_sidebar" name="header_top_sidebar">
							<option value=""<?php echo ($theme_options["header_top_sidebar"]=="" ? " selected='selected'" : ""); ?>><?php _e("none", 'pressroom'); ?></option>
							<?php
							foreach($theme_sidebars as $theme_sidebar)
							{
								?>
								<option value="<?php echo esc_attr($theme_sidebar["id"]); ?>"<?php echo ($theme_options["header_top_sidebar"]==$theme_sidebar["id"] ? " selected='selected'" : ""); ?>><?php echo $theme_sidebar["title"]; ?></option>
								<?php
							}
							?>
						</select>
						</div>
					</li>
					<li id="header_top_right_sidebar_container">
						<label for="header_top_right_sidebar"><?php _e('Header top right sidebar', 'pressroom'); ?></label>
						<div>
						<select id="header_top_right_sidebar" name="header_top_right_sidebar">
							<option value=""<?php echo ($theme_options["header_top_right_sidebar"]=="" ? " selected='selected'" : ""); ?>><?php _e("none", 'pressroom'); ?></option>
							<?php
							foreach($theme_sidebars as $theme_sidebar)
							{
								?>
								<option value="<?php echo esc_attr($theme_sidebar["id"]); ?>"<?php echo ($theme_options["header_top_right_sidebar"]==$theme_sidebar["id"] ? " selected='selected'" : ""); ?>><?php echo $theme_sidebar["title"]; ?></option>
								<?php
							}
							?>
						</select>
						</div>
					</li>
				</ul>
			</div>
			<div id="tab-fonts" class="settings">
				<h3><?php _e('Fonts', 'pressroom'); ?></h3>
				<ul class="form_field_list">
					<li>
						<label for="primary_font"><?php _e('Primary font', 'pressroom'); ?></label>
						<div>
							<label class="small_label"><?php _e('Enter font name', 'pressroom'); ?></label>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["primary_font_custom"]); ?>" id="primary_font_custom" name="primary_font_custom">
							<label class="small_label margin_top_10"><?php _e('or choose Google font', 'pressroom'); ?></label>
							<select id="primary_font" name="primary_font">
								<option<?php echo ($theme_options["primary_font"]=="" ? " selected='selected'" : ""); ?>  value=""><?php _e("Default (Roboto)", 'pressroom'); ?></option>
								<?php
								$fontsCount = count($fontsArray->items);
								for($i=0; $i<$fontsCount; $i++)
								{
								?>
									
									<?php
									$variantsCount = count($fontsArray->items[$i]->variants);
									if($variantsCount>1)
									{
										for($j=0; $j<$variantsCount; $j++)
										{
										?>
											<option<?php echo ($theme_options["primary_font"]==$fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j] ? " selected='selected'" : ""); ?> value="<?php echo esc_attr($fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]); ?>"><?php echo $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]; ?></option>
										<?php
										}
									}
									else
									{
									?>
									<option<?php echo ($theme_options["primary_font"]==$fontsArray->items[$i]->family ? " selected='selected'" : ""); ?> value="<?php echo esc_attr($fontsArray->items[$i]->family); ?>"><?php echo $fontsArray->items[$i]->family; ?></option>
									<?php
									}
								}
								?>
							</select>
						</div>
					</li>
					<li>
						<br>
						<label for="secondary_font"><?php _e('Secondary font', 'pressroom'); ?></label>
						<div>
							<label class="small_label"><?php _e('Enter font name', 'pressroom'); ?></label>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["secondary_font_custom"]); ?>" id="secondary_font_custom" name="secondary_font_custom">
							<label class="small_label margin_top_10"><?php _e('or choose Google font', 'pressroom'); ?></label>
							<select id="secondary_font" name="secondary_font">
								<option<?php echo ($theme_options["secondary_font"]=="" ? " selected='selected'" : ""); ?>  value=""><?php _e("Default (Roboto Condensed)", 'pressroom'); ?></option>
								<?php
								$fontsCount = count($fontsArray->items);
								for($i=0; $i<$fontsCount; $i++)
								{
								?>
									
									<?php
									$variantsCount = count($fontsArray->items[$i]->variants);
									if($variantsCount>1)
									{
										for($j=0; $j<$variantsCount; $j++)
										{
										?>
											<option<?php echo ($theme_options["secondary_font"]==$fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j] ? " selected='selected'" : ""); ?> value="<?php echo esc_attr($fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]); ?>"><?php echo $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]; ?></option>
										<?php
										}
									}
									else
									{
									?>
									<option<?php echo ($theme_options["secondary_font"]==$fontsArray->items[$i]->family ? " selected='selected'" : ""); ?> value="<?php echo esc_attr($fontsArray->items[$i]->family); ?>"><?php echo $fontsArray->items[$i]->family; ?></option>
									<?php
									}
								}
								?>
							</select>
						</div>
					</li>
					<li>
						<br>
						<label for="text_font"><?php _e('Text font', 'pressroom'); ?></label>
						<div>
							<label class="small_label"><?php _e('Enter font name', 'pressroom'); ?></label>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["text_font_custom"]); ?>" id="text_font_custom" name="text_font_custom">
							<label class="small_label margin_top_10"><?php _e('or choose Google font', 'pressroom'); ?></label>
							<select id="text_font" name="text_font">
								<option<?php echo ($theme_options["text_font"]=="" ? " selected='selected'" : ""); ?>  value=""><?php _e("Default (Arial)", 'pressroom'); ?></option>
								<?php
								$fontsCount = count($fontsArray->items);
								for($i=0; $i<$fontsCount; $i++)
								{
								?>
									
									<?php
									$variantsCount = count($fontsArray->items[$i]->variants);
									if($variantsCount>1)
									{
										for($j=0; $j<$variantsCount; $j++)
										{
										?>
											<option<?php echo ($theme_options["text_font"]==$fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j] ? " selected='selected'" : ""); ?> value="<?php echo esc_attr($fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]); ?>"><?php echo $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]; ?></option>
										<?php
										}
									}
									else
									{
									?>
									<option<?php echo ($theme_options["text_font"]==$fontsArray->items[$i]->family ? " selected='selected'" : ""); ?> value="<?php echo esc_attr($fontsArray->items[$i]->family); ?>"><?php echo $fontsArray->items[$i]->family; ?></option>
									<?php
									}
								}
								?>
							</select>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="footer">
			<div class="footer_left">
				<ul class="social-list">
					<li><a target="_blank" href="http://www.facebook.com/QuanticaLabs/" class="social-list-facebook" title="Facebook"></a></li>
					<li><a target="_blank" href="https://twitter.com/quanticalabs" class="social-list-twitter" title="Twitter"></a></li>
					<li><a target="_blank" href="http://www.flickr.com/photos/76628486@N03" class="social-list-flickr" title="Flickr"></a></li>
					<li><a target="_blank" href="http://themeforest.net/user/QuanticaLabs?ref=QuanticaLabs" class="social-list-envato" title="Envato"></a></li>
					<li><a target="_blank" href="http://quanticalabs.tumblr.com/" class="social-list-tumblr" title="Tumblr"></a></li>
					<li><a target="_blank" href="http://quanticalabs.deviantart.com/" class="social-list-deviantart" title="Deviantart"></a></li>
				</ul>
			</div>
			<div class="footer_right">
				<input type="hidden" name="action" value="<?php echo esc_attr($themename); ?>_save" />
				<input type="submit" name="submit" value="Save Options" />
				<img id="theme_options_preloader" src="<?php echo get_template_directory_uri();?>/admin/images/ajax-loader.gif" />
				<img id="theme_options_tick" src="<?php echo get_template_directory_uri();?>/admin/images/tick.png" />
			</div>
		</div>
	</form>
<?php
}
?>