<?php
//columns
function pr_theme_columns($atts, $content)
{	
	extract(shortcode_atts(array(
		"class" => ""
	), $atts));
	return '<div class="columns' . ($class!='' ? ' ' . $class : '') . '">' . do_shortcode($content) . '</div>';
}
add_shortcode("columns", "pr_theme_columns");

//column left
function pr_theme_column_left($atts, $content)
{
	return '<div class="column_left">' . do_shortcode($content) . '</div>';
}
add_shortcode("column_left", "pr_theme_column_left");

//column right
function pr_theme_column_right($atts, $content)
{
	return '<div class="column_right">' . do_shortcode($content) . '</div>';
}
add_shortcode("column_right", "pr_theme_column_right");
?>
