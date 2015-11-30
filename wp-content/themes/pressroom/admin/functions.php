<?php
function pr_theme_admin_init()
{
	wp_register_script("theme-colorpicker", get_template_directory_uri() . "/admin/js/colorpicker.js", array("jquery"));
	wp_register_script("theme-admin", get_template_directory_uri() . "/admin/js/theme_admin.js", array("jquery", "colorpicker"));
	wp_register_script("jquery-bqq", get_template_directory_uri() . "/admin/js/jquery.ba-bbq.min.js", array("jquery"));
	wp_register_style("theme-colorpicker", get_template_directory_uri() . "/admin/style/colorpicker.css");
	wp_register_style("theme-admin-style", get_template_directory_uri() . "/admin/style/style.css");
	wp_register_style("theme-admin-style-rtl", get_template_directory_uri() . "/admin/style/rtl.css");
}
add_action("admin_init", "pr_theme_admin_init");

function pr_theme_admin_print_scripts()
{
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-bqq');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('theme-admin');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	wp_enqueue_style("google-font-open-sans", "http://fonts.googleapis.com/css?family=Open+Sans:400,600");
	
	$sidebars = array(
		"default" => array(
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'pressroom')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'pressroom')
			)
		),
		"template-blog.php" => array(
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'pressroom')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'pressroom')
			)
		),
		"single.php" => array(
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'pressroom')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'pressroom')
			)
		),
		"author.php" => array(
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'pressroom')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'pressroom')
			)
		),
		"search.php" => array(
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'pressroom')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'pressroom')
			)
		),
		"template-default-without-breadcrumbs.php" => array(
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'pressroom')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'pressroom')
			)
		),
		"404.php" => array(
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'pressroom')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'pressroom')
			)
		)
	);
	//get theme sidebars
	$theme_sidebars = array();
	$theme_sidebars_array = get_posts(array(
		'post_type' => 'pressroom_sidebars',
		'posts_per_page' => '-1',
		'post_status' => 'publish',
		'orderby' => 'menu_order',
		'order' => 'ASC'
	));
	for($i=0; $i<count($theme_sidebars_array); $i++)
	{
		$theme_sidebars[$i]["id"] = $theme_sidebars_array[$i]->ID;
		$theme_sidebars[$i]["title"] = $theme_sidebars_array[$i]->post_title;
	}
	//get theme sliders
	$sliderAllShortcodeIds = array();
	$allOptions = wp_load_alloptions();
	foreach($allOptions as $key => $value)
	{
		if(substr($key, 0, 26)=="pressroom_slider_settings")
			$sliderAllShortcodeIds[] = $key;
	}
	if(is_plugin_active( 'revslider/revslider.php'))
	{
		//get revolution sliders
		global $wpdb;
		$rs = $wpdb->get_results( 
		"
		SELECT id, title, alias
		FROM ".$wpdb->prefix."revslider_sliders
		ORDER BY id ASC LIMIT 100
		"
		);
		if($rs) 
		{
			foreach($rs as $slider)
			{
				$sliderAllShortcodeIds[] = "revolution_slider_settings_" . $slider->alias;
			}
		}
	}
	if(is_plugin_active( 'LayerSlider/layerslider.php'))
	{
		//get layer sliders
		global $wpdb;
		$ls = $wpdb->get_results(
		"
		SELECT id, name, date_c
		FROM ".$wpdb->prefix."layerslider
		WHERE flag_hidden = '0' AND flag_deleted = '0'
		ORDER BY date_c ASC LIMIT 999
		"
		);
		$layer_sliders = array();
		if($ls)
		{
			foreach($ls as $slider)
			{
				$sliderAllShortcodeIds[] = "aaaaalayer_slider_settings_" . $slider->id;
			}
		}
	}
	//sort slider ids
	sort($sliderAllShortcodeIds);
	$data = array(
		'img_url' =>  get_template_directory_uri() . "/images/",
		'admin_img_url' =>  get_template_directory_uri() . "/admin/images/",
		'sidebar_label' => __('Sidebar', 'pressroom'),
		'slider_label' => __('Main Slider', 'pressroom'),
		'sidebars' => $sidebars,
		'theme_sidebars' => $theme_sidebars,
		'page_sidebars' => get_post_meta(get_the_ID(), "pressroom_page_sidebars", true),
		'theme_sliders' => $sliderAllShortcodeIds,
		'main_slider' => get_post_meta(get_the_ID(), "main_slider", true)
	);
	//pass data to javascript
	$params = array(
		'l10n_print_after' => 'config = ' . json_encode($data) . ';'
	);
	wp_localize_script("theme-admin", "config", $params);
}

function pr_theme_admin_print_scripts_colorpicker()
{	
	wp_enqueue_script('theme-admin');
	wp_enqueue_script('theme-colorpicker');
	wp_enqueue_style('theme-colorpicker');
}

function pr_theme_admin_print_scripts_all()
{
	global $theme_options;
	wp_enqueue_style('theme-admin-style');
	if((is_rtl() || (isset($theme_options['direction']) && $theme_options["direction"]=='rtl')) && $_COOKIE["pr_direction"]!="LTR")
		wp_enqueue_style('theme-admin-style-rtl');
}

function pr_theme_admin_menu_theme_options() 
{
	add_action("admin_print_scripts", "pr_theme_admin_print_scripts_all");
	add_action("admin_print_scripts-post-new.php", "pr_theme_admin_print_scripts");
	add_action("admin_print_scripts-post.php", "pr_theme_admin_print_scripts");
	add_action("admin_print_scripts-appearance_page_ThemeOptions", "pr_theme_admin_print_scripts");
	add_action("admin_print_scripts-widgets.php", "pr_theme_admin_print_scripts_colorpicker");
	add_action("admin_print_scripts-appearance_page_ThemeOptions", "pr_theme_admin_print_scripts_colorpicker");
	add_action("admin_print_scripts-edit-tags.php", "pr_theme_admin_print_scripts_colorpicker");
	add_action("admin_print_scripts-post-new.php", "pr_theme_admin_print_scripts_colorpicker");
	add_action("admin_print_scripts-post.php", "pr_theme_admin_print_scripts_colorpicker");
}
add_action("admin_menu", "pr_theme_admin_menu_theme_options");

function pr_rename_post_formats($translation, $text, $context, $domain) 
{
	$names = array(
		'Image'  => 'Small Image'
	);
    if($context == 'Post format') 
		$translation = str_replace(array_keys($names), array_values($names), $text);
    return $translation;
}
add_filter('gettext_with_context', 'pr_rename_post_formats', 10, 4);

//http://wpthemetutorial.com/2013/02/21/adding-custom-meta-to-wordpress-taxonomies/
add_action('category_edit_form_fields', 'pr_edit_category_color_field', 10, 2);
function pr_edit_category_color_field($term)
{
	$term_id = $term->term_id;
	$term_meta = get_option( "taxonomy_$term_id");
	$category_color = $term_meta['color'] ? $term_meta['color'] : '';
?>
	<tr class="form-field">
		<th scope="row">
			<label for="color"><?php _e("Category color", 'pressroom'); ?></label>
			<td>
				<span class="color_preview" style="background-color: #<?php echo ($category_color!="" ? $category_color : ''); ?>;"></span>
				<input style="width: 70px;" type="text" class="regular-text color" value="<?php echo esc_attr($category_color); ?>" id="color" name="color" data-default-color="transparent">
				<script type="text/javascript">
		jQuery(document).ready(function($){
			$(".color").ColorPicker({
				onChange: function(hsb, hex, rgb, el) {
					$(el).val(hex);
					$(el).prev(".color_preview").css("background-color", "#" + hex);
				},
				onSubmit: function(hsb, hex, rgb, el){
					$(el).val(hex);
					$(el).ColorPickerHide();
				},
				onBeforeShow: function (){
					var color = (this.value!="" ? this.value : $(this).attr("data-default-color"));
					$(this).ColorPickerSetColor(color);
					$(this).prev(".color_preview").css("background-color", color);
				}
			}).on('keyup', function(event, param){
				$(this).ColorPickerSetColor(this.value);

				var default_color = $(this).attr("data-default-color");
				$(this).prev(".color_preview").css("background-color", (this.value!="none" ? "#" + (this.value!="" ? (typeof(param)=="undefined" ? $(".colorpicker:visible .colorpicker_hex input").val() : this.value) : default_color) : "transparent"));
			});
			$("#color").change(function(){
				$(this).next().next().val($(this).val()).trigger("keyup", [1]);
			});
		});
		</script>
			</td>
		</th>
	</tr>
<?php
}

add_action('category_add_form_fields', 'pr_add_category_color_field');
function pr_add_category_color_field()
{
    ?>
	<div class="form-field">
		<label for="color"><?php _e("Category color", 'pressroom'); ?></label>
		<span class="color_preview" style="background-color: transparent;"></span>
		<input style="width: 70px;" type="text" class="regular-text color" value="" name="color" data-default-color="transparent">
	</div>
    <?php
}

add_action('edited_category', 'pr_save_tax_meta', 10, 2);
add_action('create_category', 'pr_save_tax_meta', 10, 2);
	
function pr_save_tax_meta($term_id)
{
	if(isset($_POST['color'])) 
	{
		$t_id = $term_id;
		$term_meta = array();

		$term_meta['color'] = isset ( $_POST['color'] ) ?  $_POST['color']  : '';
		// Save the option array.
		update_option( "taxonomy_$t_id", $term_meta );

	}
}
	
//visual composer
if(function_exists("add_shortcode_param"))
{
	//dropdownmulti
	add_shortcode_param('dropdownmulti' , 'pr_dropdownmultiple_settings_field');
	function pr_dropdownmultiple_settings_field($settings, $value)
	{
		$value = ($value==null ? array() : $value);
		$dependency = vc_generate_dependencies_attributes($settings);
		if(!is_array($value))
			$value = explode(",", $value);
		$output = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'"' . $dependency . ' multiple>';
				foreach ( $settings['value'] as $text_val => $val ) {
					if ( is_numeric($text_val) && is_string($val) || is_numeric($text_val) && is_numeric($val) ) {
						$text_val = $val;
					}
					$text_val = __($text_val, "js_composer");
				   // $val = strtolower(str_replace(array(" "), array("_"), $val));
					$selected = '';
					if ( in_array($val,$value) ) $selected = ' selected="selected"';
					$output .= '<option class="'.$val.'" value="'.$val.'"'.$selected.'>'.$text_val.'</option>';
				}
				$output .= '</select>';
		return $output;
	}
	//hidden
	add_shortcode_param('hidden', 'pr_hidden_settings_field');
	function pr_hidden_settings_field($settings, $value) 
	{
	   $dependency = vc_generate_dependencies_attributes($settings);
	   return '<input name="'.$settings['param_name']
				 .'" class="wpb_vc_param_value wpb-textinput '
				 .$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'
				 .$value.'" ' . $dependency . '/>';
	}
	//add item button
	add_shortcode_param('listitem' , 'pr_listitem_settings_field');
	function pr_listitem_settings_field($settings, $value)
	{
		$dependency = vc_generate_dependencies_attributes($settings);
		$value = explode(",", $value);
		$output = '<input type="button" value="' . __('Add list item', 'pressroom') . '" name="'.$settings['param_name'].'" class="button '.$settings['param_name'].' '.$settings['type'].'" style="width: auto; padding: 0 10px 1px;"' . $dependency . '/>';
		return $output;
	}
	//add item window
	add_shortcode_param('listitemwindow' , 'pr_listitemwindow_settings_field');
	function pr_listitemwindow_settings_field($settings, $value)
	{
		$value = explode(",", $value);
		$output = '<div class="listitemwindow vc_panel vc_shortcode-edit-form" name="'.$settings['param_name'].'">
			<div class="vc_panel-heading">
				<a class="vc_close" href="#" title="Close panel"><i class="vc_icon"></i></a>
				<h3 class="vc_panel-title">' . __('Add New List Item', 'pressroom') . '</h3>
			</div>
			<div class="modal-body wpb-edit-form" style="display: block;min-height: auto;">
				<div class="vc_row-fluid wpb_el_type_textfield">
					<div class="wpb_element_label">' . __("Text", 'pressroom') . '</div>
					<div class="edit_form_line">
						<input type="text" value="" class="wpb_vc_param_value wpb-textinput textfield" name="item_content">
					</div>
				</div>
				<div class="vc_row-fluid wpb_el_type_textfield">
					<div class="wpb_element_url">' . __("Url", 'pressroom') . '</div>
					<div class="edit_form_line">
						<input type="text" value="" class="wpb_vc_param_value wpb-textinput textfield" name="item_url">
					</div>
				</div>
				<div class="vc_row-fluid wpb_el_type_dropdown">
					<div class="wpb_element_label">' . __("Url target", 'pressroom') . '</div>
					<div class="edit_form_line">
						<select class="wpb_vc_param_value wpb-input wpb-select item_url_target dropdown" name="item_url_target">
							<option selected="selected" value="new_window">' . __("new window", 'pressroom') . '</option>
							<option value="same_window">' . __("same window", 'pressroom') . '</option>
						</select>
					</div>
				</div>
				<div class="vc_row-fluid wpb_el_type_dropdown">
					<div class="wpb_element_label">' . __("Icon", 'pressroom') . '</div>
					<div class="edit_form_line">
						<select class="wpb_vc_param_value wpb-input wpb-select item_type dropdown" name="item_icon">
							<option selected="selected" value="">' . __("-", 'pressroom') . '</option>
							<option value="bullet style_1">' . __("Bullet style 1", 'pressroom') . '</option>
							<option value="bullet style_2">' . __("Bullet style 2", 'pressroom') . '</option>
							<option value="bullet style_3">' . __("Bullet style 3", 'pressroom') . '</option>
							<option value="bullet style_4">' . __("Bullet style 4", 'pressroom') . '</option>
						</select>
					</div>
				</div>
				<div class="vc_row-fluid wpb_el_type_colorpicker">
					<div class="wpb_element_label">' . __("Custom text color", 'pressroom') . '</div>
					<div class="edit_form_line">
						<div class="color-group">
							<input name="item_content_color" class="wpb_vc_param_value wpb-textinput colorpicker_field vc-color-control wp-color-picker" type="text"/>
						</div>
					</div>
				</div>
				<div class="edit_form_actions" style="padding-top: 20px;">
					<a id="add-item-shortcode" class="button-primary" href="#">' . __("Add Item", 'pressroom') . '</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="cancel-item-options button" href="#">' . __("Cancel", 'pressroom') . '</a>
				</div>
			</div>
		</div>';
		return $output;
	}
}
/*
//attach_images_custom
add_shortcode_param('attach_images_custom' , attach_images_custom_settings_field);
function attach_images_custom_settings_field($settings, $value)
{
	$param_line = '';
	
	$dependency = vc_generate_dependencies_attributes($settings);
	// TODO: More native way
	$param_value = wpb_removeNotExistingImgIDs($value);
	$param_line .= '<input type="hidden" class="wpb_vc_param_value gallery_widget_attached_images_ids '.$settings['param_name'].' '.$settings['type'].'" name="'.$settings['param_name'].'" value="'.$param_value.'" ' . $dependency . '/>';
	//$param_line .= '<a class="button gallery_widget_add_images" href="#" title="'.__('Add images', "js_composer").'">'.__('Add images', "js_composer").'</a>';
	$param_line .= '<div class="gallery_widget_attached_images">';
	$param_line .= '<ul class="gallery_widget_attached_images_list">';
	$param_line .= ($param_value != '') ? fieldAttachedImages(explode(",", $param_value)) : '';
	$param_line .= '</ul>';
	$param_line .= '</div>';
	$param_line .= '<div class="gallery_widget_site_images">';
	// $param_line .= siteAttachedImages(explode(",", $param_value));
	$param_line .= '</div>';
	$param_line .= '<a class="gallery_widget_add_images" href="#" title="'.__('Add images', "js_composer").'">'.__('Add images', "js_composer").'</a>';//class: button
	//$param_line .= '<div class="wpb_clear"></div>';
	for($i=0; $i<count(explode(",", $param_value)); $i++)
	{
		$param_line .= '<div class="row-fluid wpb_el_type_textfield">
				<div class="wpb_element_label">' . __("Text", 'pressroom') . '</div>
				<div class="edit_form_line">
					<input type="text" value="" class="wpb_vc_param_value wpb-textinput textfield" name="item_content' . $i . '">
				</div>
			</div>';
	}
	return $param_line;
}


//Gets post cat slug and looks for single-[cat slug].php and applies it
add_filter('single_template', create_function(
	'$the_template',
	'foreach( (array) get_the_category() as $cat ) {
		if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") )
		return TEMPLATEPATH . "/single-{$cat->slug}.php"; }
	return $the_template;' )
);

//Gets post cat slug and looks for single-[cat slug].php and applies it
add_filter('single_template', create_function(
	'$the_template',
	'foreach( (array) get_the_category() as $cat ) {
		if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") )
		return TEMPLATEPATH . "/single-{$cat->slug}.php"; }
	return $the_template;' )
);

//Gets post cat slug and looks for single-[cat slug].php and applies it
add_filter('single_template_s', create_function(
	'$the_template',
	'foreach( (array) get_the_category() as $cat ) {
		if ( file_exists(STYLESHEETPATH . "/single-{$cat->slug}.php") )
		return STYLESHEETPATH . "/single-{$cat->slug}.php"; }
	return $the_template;' )
);
STYLESHEETPATH














*/
?>