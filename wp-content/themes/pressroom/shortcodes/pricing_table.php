<?php
//visual composer
function pr_theme_pricing_table_vc_init()
{
	global $wpdb;
	//get pricing tables list
	$query = "SELECT option_name FROM {$wpdb->options}
			WHERE 
			option_name LIKE 'css3_grid_shortcode_settings%'
			ORDER BY option_name";
	$pricing_tables_list = $wpdb->get_results($query);
	$css3GridAllShortcodeIds = array();
	foreach($pricing_tables_list as $pricing_table)
		$css3GridAllShortcodeIds[substr($pricing_table->option_name, 29)] = substr($pricing_table->option_name, 29);
	
	wpb_map( array(
		"name" => __("Pricing table", 'pressroom'),
		"base" => "css3_grid",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-pricing-table",
		"category" => __('Pressroom', 'pressroom'),
		"params" => array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Id", 'pressroom'),
				"param_name" => "id",
				"value" => $css3GridAllShortcodeIds
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Top margin", 'pressroom'),
				"param_name" => "top_margin",
				"value" => array(__("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section", __("None", 'pressroom') => "none")
			)
		)
	));
}
add_action("init", "pr_theme_pricing_table_vc_init"); 
?>