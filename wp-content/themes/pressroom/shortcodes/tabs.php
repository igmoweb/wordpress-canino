<?php
function pr_theme_tabs($atts, $content)
{
	extract(shortcode_atts(array(
		"width" => ""
	), $atts));
	
	$output .= '<div class="tabs"' . ($width!="" ? ' style="width: ' . $width . 'px"' : '') . '>
		' . do_shortcode($content) . '
	</div>';
	return $output;
}
add_shortcode("tabs", "pr_theme_tabs");

function pr_theme_tabs_navigation($atts, $content)
{	
	$output .= '<ul class="clearfix tabs_navigation">
		' . do_shortcode($content) . '
	</ul>';
	return $output;
}
add_shortcode("tabs_navigation", "pr_theme_tabs_navigation");

function pr_theme_tab($atts, $content)
{	
	global $themename;
	extract(shortcode_atts(array(
		"id" => ""
	), $atts));
	if($id!="")
	{
		$output .= '<li>
			<a title="' . esc_attr($content) . '" href="#' . $id . '">
				' . do_shortcode($content) . '
			</a>
		</li>';
	}
	else
		$output .= __("Attribute id is required. For example [tab id='tab-1']", 'pressroom');
	return $output;
}
add_shortcode("tab", "pr_theme_tab");

function pr_theme_tab_content($atts, $content)
{
	global $themename;
	extract(shortcode_atts(array(
		"id" => ""
	), $atts));
	
	if($id!="")
	{
		$output .= '<div id="' . $id . '">
			' . do_shortcode(apply_filters("the_content", $content)) . '
		</div>';
	}
	else
		$output .= __("Attribute id is required. For example [tab_content id='tab-1']", 'pressroom');
	return $output;
}
add_shortcode("tab_content", "pr_theme_tab_content");
?>