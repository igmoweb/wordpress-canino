<?php
global $themename;
//google map
function pr_theme_map_shortcode($atts)
{
	extract(shortcode_atts(array(
		"id" => "map",
		"width" => "100%",
		"height" => "",
		"map_type" => "ROADMAP",
		"lat" => "45.358887",
		"lng" => "-75.702429",
		"marker_lat" => "45.358887",
		"marker_lng" => "-75.702429",
		"zoom" => "15",
		"streetviewcontrol" => "false",
		"maptypecontrol" => "false",
		"map_icon_url" => get_template_directory_uri() . "/images/icons/other/map_pointer.png",
		"icon_width" => 38,
		"icon_height" => 45,
		"icon_anchor_x" => 18,
		"icon_anchor_y" => 44,
		"top_margin" => "page_margin_top"
	), $atts));
	
	$map_type = strtoupper($map_type);
	$width = (substr($width, -1)!="%" && substr($width, -2)!="px" ? $width . "px" : $width);
	$height = (substr($height, -1)!="%" && substr($height, -2)!="px" ? $height . "px" : $height);
	$output = "<div id='" . $id . "'" . ($width!="" || $height!="" ? " style='" . ($width!="" ? "width:" . $width . ";" : "") . ($height!="" ? "height:" . $height . ";" : "") . "'" : "") . ($top_margin!="none" ? " class='" . $top_margin . "'" : "") . "></div>
	<script type='text/javascript'>
	var map_$id = null;
	var coordinate_$id;
	try
    {
        coordinate_$id=new google.maps.LatLng($lat, $lng);
        var mapOptions= 
        {
            zoom:$zoom,
            center:coordinate_$id,
            mapTypeId:google.maps.MapTypeId.$map_type,
			streetViewControl:$streetviewcontrol,
			mapTypeControl:$maptypecontrol
        };
        var map_$id = new google.maps.Map(document.getElementById('$id'),mapOptions);";
	if($marker_lat!="" && $marker_lng!="")
	{
	$output .= "
		var marker_$id = new google.maps.Marker({
			position: new google.maps.LatLng($marker_lat, $marker_lng),
			map: map_$id" . ($map_icon_url!="" ? ", icon: new google.maps.MarkerImage('$map_icon_url', new google.maps.Size($icon_width, $icon_height), null, new google.maps.Point($icon_anchor_x, $icon_anchor_y))" : "") . "
		});";
		/*var infowindow = new google.maps.InfoWindow();
		infowindow.setContent('<p style=\'color:#000;\'>your html content</p>');
		infowindow.open(map_$id,marker_$id);*/
	}
	$output .= "
    }
    catch(e) {};
	jQuery(document).ready(function($){
		$(window).resize(function(){
			if(map_$id!=null)
				map_$id.setCenter(coordinate_$id);
		});
	});
	</script>";
	return $output;
}
add_shortcode($themename . "_map", "pr_theme_map_shortcode");
//visual composer
function pr_theme_google_map_vc_init()
{
	wpb_map( array(
		"name" => __("Google map", 'pressroom'),
		"base" => "pressroom_map",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-map-pin",
		"category" => __('Pressroom', 'pressroom'),
		"params" => array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Id", 'pressroom'),
				"param_name" => "id",
				"value" => "map",
				"description" => __("Please provide unique id for each map on the same page/post", 'pressroom')
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Width", 'pressroom'),
				"param_name" => "width",
				"value" => "100%"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Height", 'pressroom'),
				"param_name" => "height",
				"value" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Map type", 'pressroom'),
				"param_name" => "map_type",
				"value" => array(__("Roadmap", 'pressroom') => "ROADMAP", __("Satellite", 'pressroom') => "SATELLITE", __("Hybrid", 'pressroom') => "HYBRID", __("Terrain", 'pressroom') => "TERRAIN")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Latitude", 'pressroom'),
				"param_name" => "lat",
				"value" => "45.358887",
				"description" => __("You can use this <a href='http://www.birdtheme.org/useful/v3tool.html' target='_blank'>http://www.birdtheme.org/useful/v3tool.html</a> tool to designate coordinates", 'pressroom')
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Longitude", 'pressroom'),
				"param_name" => "lng",
				"value" => "-75.702429",
				"description" => __("You can use this <a href='http://www.birdtheme.org/useful/v3tool.html' target='_blank'>http://www.birdtheme.org/useful/v3tool.html</a> tool to designate coordinates", 'pressroom')
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Marker/Point Latitude", 'pressroom'),
				"param_name" => "marker_lat",
				"value" => "45.358887",
				"description" => __("You can use this <a href='http://www.birdtheme.org/useful/v3tool.html' target='_blank'>http://www.birdtheme.org/useful/v3tool.html</a> tool to designate coordinates", 'pressroom')
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Marker/point Longitude", 'pressroom'),
				"param_name" => "marker_lng",
				"value" => "-75.702429",
				"description" => __("You can use this <a href='http://www.birdtheme.org/useful/v3tool.html' target='_blank'>http://www.birdtheme.org/useful/v3tool.html</a> tool to designate coordinates", 'pressroom')
			),
			array(
				"type" => "dropdown",
				"heading" => __("Map Zoom", "js_composer"),
				"param_name" => "zoom",
				"value" => array(__("15 - Default", "js_composer") => 15, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 16, 17, 18, 19, 20)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Street view control", 'pressroom'),
				"param_name" => "streetviewcontrol",
				"value" => array(__("no", 'pressroom') => "false", __("yes", 'pressroom') => "true")
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Map type control", 'pressroom'),
				"param_name" => "maptypecontrol",
				"value" => array(__("no", 'pressroom') => "false", __("yes", 'pressroom') => "true")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Marker/Point icon url", 'pressroom'),
				"param_name" => "map_icon_url",
				"value" => get_template_directory_uri() . "/images/icons/other/map_pointer.png"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Icon width", 'pressroom'),
				"param_name" => "icon_width",
				"value" => 38
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Icon height", 'pressroom'),
				"param_name" => "icon_height",
				"value" => 45
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Icon anchor x", 'pressroom'),
				"param_name" => "icon_anchor_x",
				"value" => 18
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Icon anchor y", 'pressroom'),
				"param_name" => "icon_anchor_y",
				"value" => 44
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Top margin", 'pressroom'),
				"param_name" => "top_margin",
				"value" => array(__("None", 'pressroom') => "none", __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section")
			)
		)
	));
}
add_action("init", "pr_theme_google_map_vc_init");
?>