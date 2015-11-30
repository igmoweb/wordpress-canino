<?php
//author
function pr_theme_single_author($atts, $content)
{
	extract(shortcode_atts(array(
		"show_social_icons" => 1,
		"show_twitter" => 1,
		"show_facebook" => 1,
		"show_linkedin" => 1,
		"show_skype" => 1,
		"show_googleplus" => 1,
		"show_instagram" => 1,
		"top_margin" => "page_margin_top"
	), $atts));
	
	$author = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
	$output = "";
	$args = array(
		'author' => $author->ID,
		'posts_per_page' => -1
	);
	$author_posts = get_posts($args);
	$views = 0;
	foreach($author_posts as $author_post)
		$views += getPostViews($author_post->ID);
	$output .= '<ul class="authors_list rating' . ($top_margin!="none" ? ' ' . $top_margin : '') . '">
		<li class="single-author clearfix">
			<div class="avatar_block">
				<a class="thumb" href="' . get_author_posts_url($author->ID) . '" title="' . esc_attr($author->display_name) . '">' . get_avatar($author->ID, 300) . '</a>
				<div class="details clearfix">
					<ul class="columns">
						<li class="column">
							<span class="number animated_element" data-value="' . count_user_posts($author->ID) . '"></span>
							<h5>' . __("Articles", 'pressroom') . '</h5>
						</li>
						<li class="column">
							<span class="number animated_element" data-value="' . $views . '"></span>
							<h5>' . __("Views", 'pressroom') . '</h5>
						</li>
					</ul>
				</div>
			</div>
			<div class="content">';
				if((int)$show_social_icons && ((int)$show_twitter || (int)$show_facebook || (int)$show_linkedin || (int)$show_skype || (int)$show_googleplus || (int)$show_instagram))
				{
					if((int)$show_twitter)
						$twitter = get_the_author_meta("twitter", $author->ID);
					if((int)$show_facebook)
						$facebook = get_the_author_meta("facebook", $author->ID);
					if((int)$show_linkedin)
						$linkedin = get_the_author_meta("linkedin", $author->ID);
					if((int)$show_skype)
						$skype = get_the_author_meta("skype", $author->ID);
					if((int)$show_googleplus)
						$googleplus = get_the_author_meta("googleplus", $author->ID);
					if((int)$show_instagram)
						$instagram = get_the_author_meta("instagram", $author->ID);
					if($twitter!="" || $facebook!="" || $linkedin!="" || $skype!="" || $gooleplus!="" || $instagram!="")
					{
						$output .= '<ul class="social_icons clearfix">';
						if($twitter!="")
							$output .= '<li><a target="_blank" title="" href="' . esc_url($twitter) . '" class="social_icon twitter">&nbsp;</a></li>';
						if($facebook!="")
							$output .= '<li><a target="_blank" title="" href="' . esc_url($facebook) . '" class="social_icon facebook">&nbsp;</a></li>';
						if($linkedin!="")
							$output .= '<li><a target="_blank" title="" href="' . esc_url($linkedin) . '" class="social_icon linkedin">&nbsp;</a></li>';
						if($skype!="")
							$output .= '<li><a target="_blank" title="" href="' . esc_url($skype) . '" class="social_icon skype">&nbsp;</a></li>';
						if($googleplus!="")
							$output .= '<li><a target="_blank" title="" href="' . esc_url($googleplus) . '" class="social_icon googleplus">&nbsp;</a></li>';
						if($instagram!="")
							$output .= '<li><a target="_blank" title="" href="' . esc_url($instagram) . '" class="social_icon instagram">&nbsp;</a></li>';
						$output .= '</ul>';
					}
				}
				$output .= '<h6>' . strtoupper($author->roles[0]) . '</h6>
				<h2><a href="' . get_author_posts_url($author->ID) . '" title="' . esc_attr($author->display_name) . '">' . esc_attr($author->display_name) . '</a></h2>';
				$description = get_the_author_meta("description", $author->ID);
				if($description!="")
					$output .= '<p>' . $description . '</p>';
			$output .= '</div>
		</li>
	</ul>';
	
	return $output;
}
add_shortcode("single_author", "pr_theme_single_author");

//visual composer
function pr_theme_single_author_vc_init()
{
	$params = array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show social icons", 'pressroom'),
			"param_name" => "show_social_icons",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show twitter icon", 'pressroom'),
			"param_name" => "show_twitter",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0),
			"dependency" => Array('element' => "show_social_icons", 'value' => '1')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show facebook icon", 'pressroom'),
			"param_name" => "show_facebook",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0),
			"dependency" => Array('element' => "show_social_icons", 'value' => '1')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show linkedin icon", 'pressroom'),
			"param_name" => "show_linkedin",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0),
			"dependency" => Array('element' => "show_social_icons", 'value' => '1')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show skype icon", 'pressroom'),
			"param_name" => "show_skype",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0),
			"dependency" => Array('element' => "show_social_icons", 'value' => '1')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Google Plus icon", 'pressroom'),
			"param_name" => "show_googleplus",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0),
			"dependency" => Array('element' => "show_social_icons", 'value' => '1')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Instagram icon", 'pressroom'),
			"param_name" => "show_instagram",
			"value" => array(__("Yes", 'pressroom') => 1, __("No", 'pressroom') => 0),
			"dependency" => Array('element' => "show_social_icons", 'value' => '1')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("Page (small)", 'pressroom') => "page_margin_top", __("None", 'pressroom') => "none", __("Section (large)", 'pressroom') => "page_margin_top_section")
		)
	);
	
	wpb_map( array(
		"name" => __("Author", 'pressroom'),
		"base" => "single_author",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-author",
		"category" => __('Pressroom', 'pressroom'),
		"params" => $params
	));
}
add_action("init", "pr_theme_single_author_vc_init");
?>
