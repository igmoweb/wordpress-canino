<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style_selector/style_selector.css">
<?php
global $theme_options;
?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/style_selector/style_selector.js"></script>
<div class="style_selector<?php echo (isset($_COOKIE['pr_style_selector']) ? ' ' . $_COOKIE['pr_style_selector'] : ' opened'); ?>">
	<div class="style_selector_icon">
		&nbsp;
	</div>
	<div class="style_selector_content">
		<h4><?php _e("Style Selector", 'pressroom'); ?></h4>
		<ul>
			<li class="style_selector_header hide_on_mobile clearfix"<?php if((isset($_COOKIE['pr_color_skin']) && $_COOKIE['pr_color_skin']=="high_contrast") || (!isset($_COOKIE['pr_color_skin']) && $theme_options["color_scheme"]=="high_contrast")) echo " style='display: none;'";?>>
				<label><?php _e("Header Style:", 'pressroom'); ?></label>
				<select name="header_style">
					<option value="style_1"<?php echo (!isset($_COOKIE['pr_header_style']) || $_COOKIE['pr_header_style']=="style_1" ? ' selected="selected"' : ''); ?>><?php _e("Style 1", 'pressroom'); ?></option>
					<option value="style_2"<?php echo ((!isset($_COOKIE['pr_header_style']) && $theme_options["header_style"]=="style_2") || (isset($_COOKIE['pr_header_style']) && $_COOKIE['pr_header_style']=="style_2") ? ' selected="selected"' : ''); ?>><?php _e("Style 2", 'pressroom'); ?></option>
					<option value="style_3"<?php echo ((!isset($_COOKIE['pr_header_style']) && $theme_options["header_style"]=="style_3") || (isset($_COOKIE['pr_header_style']) && $_COOKIE['pr_header_style']=="style_3") ? ' selected="selected"' : ''); ?>><?php _e("Style 3", 'pressroom'); ?></option>
					<option value="style_4"<?php echo ((!isset($_COOKIE['pr_header_style']) && $theme_options["header_style"]=="style_4") || (isset($_COOKIE['pr_header_style']) && $_COOKIE['pr_header_style']=="style_4") ? ' selected="selected"' : ''); ?>><?php _e("Style 4", 'pressroom'); ?></option>
					<option value="style_5"<?php echo ((!isset($_COOKIE['pr_header_style']) && $theme_options["header_style"]=="style_5") || (isset($_COOKIE['pr_header_style']) && $_COOKIE['pr_header_style']=="style_5") ? ' selected="selected"' : ''); ?>><?php _e("Style 5", 'pressroom'); ?></option>
					<option value="style_6"<?php echo ((!isset($_COOKIE['pr_header_style']) && $theme_options["header_style"]=="style_6") || (isset($_COOKIE['pr_header_style']) && $_COOKIE['pr_header_style']=="style_6") ? ' selected="selected"' : ''); ?>><?php _e("Style 6", 'pressroom'); ?></option>
					<option value="style_7"<?php echo ((!isset($_COOKIE['pr_header_style']) && $theme_options["header_style"]=="style_7") || (isset($_COOKIE['pr_header_style']) && $_COOKIE['pr_header_style']=="style_7") ? ' selected="selected"' : ''); ?>><?php _e("Style 7", 'pressroom'); ?></option>
					<option value="style_8"<?php echo ((!isset($_COOKIE['pr_header_style']) && $theme_options["header_style"]=="style_8") || (isset($_COOKIE['pr_header_style']) && $_COOKIE['pr_header_style']=="style_8") ? ' selected="selected"' : ''); ?>><?php _e("Style 8", 'pressroom'); ?></option>
					<option value="style_9"<?php echo ((!isset($_COOKIE['pr_header_style']) && $theme_options["header_style"]=="style_9") || (isset($_COOKIE['pr_header_style']) && $_COOKIE['pr_header_style']=="style_9") ? ' selected="selected"' : ''); ?>><?php _e("Style 9", 'pressroom'); ?></option>
					<option value="style_10"<?php echo ((!isset($_COOKIE['pr_header_style']) && $theme_options["header_style"]=="style_10") || (isset($_COOKIE['pr_header_style']) && $_COOKIE['pr_header_style']=="style_10") ? ' selected="selected"' : ''); ?>><?php _e("Style 10", 'pressroom'); ?></option>
					<option value="style_11"<?php echo ((!isset($_COOKIE['pr_header_style']) && $theme_options["header_style"]=="style_11") || (isset($_COOKIE['pr_header_style']) && $_COOKIE['pr_header_style']=="style_11") ? ' selected="selected"' : ''); ?>><?php _e("Style 11", 'pressroom'); ?></option>
					<option value="style_12"<?php echo ((!isset($_COOKIE['pr_header_style']) && $theme_options["header_style"]=="style_12") || (isset($_COOKIE['pr_header_style']) && $_COOKIE['pr_header_style']=="style_12") ? ' selected="selected"' : ''); ?>><?php _e("Style 12", 'pressroom'); ?></option>
					<option value="style_13"<?php echo ((!isset($_COOKIE['pr_header_style']) && $theme_options["header_style"]=="style_13") || (isset($_COOKIE['pr_header_style']) && $_COOKIE['pr_header_style']=="style_13") ? ' selected="selected"' : ''); ?>><?php _e("Style 13", 'pressroom'); ?></option>
					<option value="style_14"<?php echo ((!isset($_COOKIE['pr_header_style']) && $theme_options["header_style"]=="style_14") || (isset($_COOKIE['pr_header_style']) && $_COOKIE['pr_header_style']=="style_14") ? ' selected="selected"' : ''); ?>><?php _e("Style 14", 'pressroom'); ?></option>
					<option value="style_15"<?php echo ((!isset($_COOKIE['pr_header_style']) && $theme_options["header_style"]=="style_15") || (isset($_COOKIE['pr_header_style']) && $_COOKIE['pr_header_style']=="style_15") ? ' selected="selected"' : ''); ?>><?php _e("Style 15", 'pressroom'); ?></option>
					<option value="style_high_contrast"<?php echo ((!isset($_COOKIE['pr_header_style']) && $theme_options["header_style"]=="style_high_contrast") || (isset($_COOKIE['pr_header_style']) && $_COOKIE['pr_header_style']=="style_high_contrast") ? ' selected="selected"' : ''); ?>><?php _e("Style high contrast", 'pressroom'); ?></option>
				</select>
			</li>
			<li class="hide_on_mobile clearfix">
				<label><?php _e("Menu Type:", 'pressroom'); ?></label>
				<select name="menu_type">
					<option value="default"<?php echo (!isset($_COOKIE['pr_menu_type']) || $_COOKIE['pr_menu_type']=="default" ? ' selected="selected"' : ''); ?>><?php _e("Default", 'pressroom'); ?></option>
					<option value="sticky"<?php echo ((!isset($_COOKIE['pr_menu_type']) && (int)$theme_options['sticky_menu']==1) || (isset($_COOKIE['pr_menu_type']) && $_COOKIE['pr_menu_type']=="sticky") ? ' selected="selected"' : ''); ?>><?php _e("Sticky", 'pressroom'); ?></option>
				</select>
			</li>
			<li class="hide_on_mobile clearfix">
				<label><?php _e("Layout Style:", 'pressroom'); ?></label>
				<select name="layout_style">
					<option value="wide"<?php echo (!isset($_COOKIE['pr_layout']) || (isset($_COOKIE['pr_layout']) && $_COOKIE['pr_layout']=="") ? ' selected="selected"' : ''); ?>><?php _e("Wide", 'pressroom'); ?></option>
					<option value="boxed"<?php echo ((!isset($_COOKIE['pr_layout']) && $theme_options['layout']=="boxed") || (isset($_COOKIE['pr_layout']) && $_COOKIE['pr_layout']=="boxed") ? ' selected="selected"' : ''); ?>><?php _e("Boxed", 'pressroom'); ?></option>
				</select>
			</li>
			<li class="clearfix">
				<label><?php _e("Color Skin:", 'pressroom'); ?></label>
				<select name="color_skin">
					<option value="light"<?php echo (!isset($_COOKIE['pr_color_skin']) || $_COOKIE['pr_color_skin']=="light" ? ' selected="selected"' : ''); ?>><?php _e("Light", 'pressroom'); ?></option>
					<option value="dark"<?php echo ((!isset($_COOKIE['pr_color_skin']) && $theme_options['color_scheme']=="dark") || (isset($_COOKIE['pr_color_skin']) && $_COOKIE['pr_color_skin']=="dark") ? ' selected="selected"' : ''); ?>><?php _e("Dark", 'pressroom'); ?></option>
					<option value="high_contrast"<?php echo ((!isset($_COOKIE['pr_color_skin']) && $theme_options['color_scheme']=="high_contrast") || (isset($_COOKIE['pr_color_skin']) && $_COOKIE['pr_color_skin']=="high_contrast") ? ' selected="selected"' : ''); ?>><?php _e("Hight Contrast", 'pressroom'); ?></option>
				</select>
				<div class="high_contrast_switch_icon_container">
					<input type="checkbox"<?php echo (/*(!isset($_COOKIE['pr_hc_switch_icon']) && is_active_widget(false, false, "pressroom_high_contrast_switch_icon")!==false) || */((isset($_COOKIE['pr_hc_switch_icon']) && $_COOKIE['pr_hc_switch_icon']=='show')) ? ' checked="checked"' : ''); ?> id="high_contrast_switch_icon"><label class="high_contrast_switch_icon_label" for="high_contrast_switch_icon"><?php _e("High contrast switch icon", 'pressroom'); ?></label>
				</div>
			</li>
			<li class="clearfix">
				<label><?php _e("Direction:", 'pressroom'); ?></label>
				<select name="style_selector_direction">
					<option value="LTR"<?php echo (!isset($_COOKIE['pr_direction']) || $_COOKIE['pr_direction']=="LTR" ? ' selected="selected"' : ''); ?>><?php _e("LTR", 'pressroom'); ?></option>
					<option value="RTL"<?php echo ((!isset($_COOKIE['pr_direction']) && $theme_options["direction"]=="rtl") || (isset($_COOKIE['pr_direction']) && $_COOKIE['pr_direction']=="RTL") ? ' selected="selected"' : ''); ?>><?php _e("RTL", 'pressroom'); ?></option>
				</select>
			</li>
			<li class="hide_on_mobile"<?php echo ((isset($_COOKIE['pr_color_skin']) && $_COOKIE['pr_color_skin']=="high_contrast") || (!isset($_COOKIE['pr_color_skin']) && $theme_options["color_scheme"]=="high_contrast") ? ' style="display: none;"' : ''); ?>>
				<label class="single_label"><?php _e("Main Color (examples)", 'pressroom'); ?></label>
				<ul class="layout_chooser for_main_color clearfix">
					<li<?php echo ((!isset($_COOKIE['pr_main_color']) && strtoupper($theme_options['main_color'])=='ED1C24') || (isset($_COOKIE['pr_main_color']) && strtoupper($_COOKIE['pr_main_color'])=='ED1C24') || (!isset($_COOKIE['pr_main_color']) && (!isset($theme_options['main_color']) || $theme_options['main_color']=="")) ? ' class="selected"' : ''); echo ((isset($_COOKIE['pr_color_skin']) && $_COOKIE['pr_color_skin']!="light") || (!isset($_COOKIE['pr_color_skin']) && $theme_options["color_scheme"]!="light") ? ' style="display: none;"' : '');?>>
						<a href="#" class="color_preview" style="background-color: #ED1C24;" data-color="ED1C24">	
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo ((!isset($_COOKIE['pr_main_color']) && $theme_options['main_color']=='42AAE6') || (isset($_COOKIE['pr_main_color']) && $_COOKIE['pr_main_color']=='42AAE6') ? ' class="selected"' : ''); echo ((isset($_COOKIE['pr_color_skin']) && $_COOKIE['pr_color_skin']!="light") || (!isset($_COOKIE['pr_color_skin']) && $theme_options["color_scheme"]!="light") ? ' style="display: none;"' : ''); ?>>
						<a href="#" class="color_preview" style="background-color: #42AAE6;" data-color="42AAE6">	
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo ((!isset($_COOKIE['pr_main_color']) && $theme_options['main_color']=='85B53E') || (isset($_COOKIE['pr_main_color']) && $_COOKIE['pr_main_color']=='85B53E') ? ' class="selected"' : ''); echo ((isset($_COOKIE['pr_color_skin']) && $_COOKIE['pr_color_skin']!="light") || (!isset($_COOKIE['pr_color_skin']) && $theme_options["color_scheme"]!="light") ? ' style="display: none;"' : ''); ?>>
						<a href="#" class="color_preview" style="background-color: #85B53E;" data-color="85B53E">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo ((!isset($_COOKIE['pr_main_color']) && $theme_options['main_color']=='F5910F') || (isset($_COOKIE['pr_main_color']) && $_COOKIE['pr_main_color']=='F5910F') ? ' class="selected"' : ''); echo ((isset($_COOKIE['pr_color_skin']) && $_COOKIE['pr_color_skin']!="light") || (!isset($_COOKIE['pr_color_skin']) && $theme_options["color_scheme"]!="light") ? ' style="display: none;"' : ''); ?>>
						<a href="#" class="color_preview" style="background-color: #F5910F;" data-color="F5910F">
							<span class="tick"></span>
						</a>
					</li>
					<li class="last<?php echo ((!isset($_COOKIE['pr_main_color']) && $theme_options['main_color']=='18ACB6') || (isset($_COOKIE['pr_main_color']) && $_COOKIE['pr_main_color']=='18ACB6') ? ' selected' : '') . '"'; echo ((isset($_COOKIE['pr_color_skin']) && $_COOKIE['pr_color_skin']!="light") || (!isset($_COOKIE['pr_color_skin']) && $theme_options["color_scheme"]!="light") ? ' style="display: none;"' : ''); ?>>
						<a href="#" class="color_preview" style="background-color: #18ACB6;" data-color="18ACB6">
							<span class="tick"></span>
						</a>
					</li>
					<li class="first<?php echo ((!isset($_COOKIE['pr_main_color']) && strtoupper($theme_options['main_color'])=='8CC152') || (isset($_COOKIE['pr_main_color']) && strtoupper($_COOKIE['pr_main_color'])=='8CC152') || (!isset($_COOKIE['pr_main_color']) && (!isset($theme_options['main_color']) || $theme_options['main_color']=="")) ? ' selected' : '') . '"'; echo ((isset($_COOKIE['pr_color_skin']) && $_COOKIE['pr_color_skin']!="dark") || (!isset($_COOKIE['pr_color_skin']) && $theme_options["color_scheme"]!="dark") ? ' style="display: none;"' : ''); ?>>
						<a href="#" class="color_preview" style="background-color: #8CC152;" data-color="8CC152">	
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo ((!isset($_COOKIE['pr_main_color']) && $theme_options['main_color']=='4CA5D9') || (isset($_COOKIE['pr_main_color']) && $_COOKIE['pr_main_color']=='4CA5D9') ? ' class="selected"' : ''); echo ((isset($_COOKIE['pr_color_skin']) && $_COOKIE['pr_color_skin']!="dark") || (!isset($_COOKIE['pr_color_skin']) && $theme_options["color_scheme"]!="dark") ? ' style="display: none;"' : ''); ?>>
						<a href="#" class="color_preview" style="background-color: #4CA5D9;" data-color="4CA5D9">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo ((!isset($_COOKIE['pr_main_color']) && $theme_options['main_color']=='FC724B') || (isset($_COOKIE['pr_main_color']) && $_COOKIE['pr_main_color']=='FC724B') ? ' class="selected"' : ''); echo ((isset($_COOKIE['pr_color_skin']) && $_COOKIE['pr_color_skin']!="dark") || (!isset($_COOKIE['pr_color_skin']) && $theme_options["color_scheme"]!="dark") ? ' style="display: none;"' : ''); ?>>
						<a href="#" class="color_preview" style="background-color: #FC724B;" data-color="FC724B">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo ((!isset($_COOKIE['pr_main_color']) && $theme_options['main_color']=='C29A48') || (isset($_COOKIE['pr_main_color']) && $_COOKIE['pr_main_color']=='C29A48') ? ' class="selected"' : ''); echo ((isset($_COOKIE['pr_color_skin']) && $_COOKIE['pr_color_skin']!="dark") || (!isset($_COOKIE['pr_color_skin']) && $theme_options["color_scheme"]!="dark") ? ' style="display: none;"' : ''); ?>>
						<a href="#" class="color_preview" style="background-color: #C29A48;" data-color="C29A48">
							<span class="tick"></span>
						</a>
					</li>
					<li class="last<?php echo ((!isset($_COOKIE['pr_main_color']) && $theme_options['main_color']=='00C7A6') || (isset($_COOKIE['pr_main_color']) && $_COOKIE['pr_main_color']=='00C7A6') ? ' selected' : '') . '"'; echo ((isset($_COOKIE['pr_color_skin']) && $_COOKIE['pr_color_skin']!="dark") || (!isset($_COOKIE['pr_color_skin']) && $theme_options["color_scheme"]!="dark") ? ' style="display: none;"' : ''); ?>>
						<a href="#" class="color_preview" style="background-color: #00C7A6;" data-color="00C7A6">
							<span class="tick"></span>
						</a>
					</li>
				</ul>
			</li>
			<li class="clearfix hide_on_mobile">
				<label class="single_label"><?php _e("Boxed Layout Pattern", 'pressroom'); ?></label>
				<ul class="layout_chooser">
					<li<?php echo ((!isset($_COOKIE['pr_layout_style']) && $theme_options['layout_style']=='pattern_1') || (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']=='pattern_1') ? ' class="selected"' : ''); ?>>
						<a href="#" class="pattern_1">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo ((!isset($_COOKIE['pr_layout_style']) && $theme_options['layout_style']=='pattern_2') || (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']=='pattern_2') ? ' class="selected"' : ''); ?>>
						<a href="#" class="pattern_2">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo ((!isset($_COOKIE['pr_layout_style']) && $theme_options['layout_style']=='pattern_3') || (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']=='pattern_3') ? ' class="selected"' : ''); ?>>
						<a href="#" class="pattern_3">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo ((!isset($_COOKIE['pr_layout_style']) && $theme_options['layout_style']=='pattern_4') || (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']=='pattern_4') ? ' class="selected"' : ''); ?>>
						<a href="#" class="pattern_4">
							<span class="tick"></span>
						</a>
					</li>
					<li class="last<?php echo ((!isset($_COOKIE['pr_layout_style']) && $theme_options['layout_style']=='pattern_5') || (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']=='pattern_5') ? ' selected' : '') . '"'; ?>>
						<a href="#" class="pattern_5">
							<span class="tick"></span>
						</a>
					</li>
					<li class="first<?php echo ((!isset($_COOKIE['pr_layout_style']) && $theme_options['layout_style']=='pattern_6') || (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']=='pattern_6') ? ' selected' : ''); ?>">
						<a href="#" class="pattern_6">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo ((!isset($_COOKIE['pr_layout_style']) && $theme_options['layout_style']=='pattern_7') || (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']=='pattern_7') ? ' class="selected"' : ''); ?>>
						<a href="#" class="pattern_7">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo ((!isset($_COOKIE['pr_layout_style']) && $theme_options['layout_style']=='pattern_8') || (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']=='pattern_8') ? ' class="selected"' : ''); ?>>
						<a href="#" class="pattern_8">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo ((!isset($_COOKIE['pr_layout_style']) && $theme_options['layout_style']=='pattern_9') || (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']=='pattern_9') ? ' class="selected"' : ''); ?>>
						<a href="#" class="pattern_9">
							<span class="tick"></span>
						</a>
					</li>
					<li class="last<?php echo ((!isset($_COOKIE['pr_layout_style']) && $theme_options['layout_style']=='pattern_10') || (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']=='pattern_10') ? ' selected' : '') . '"'; ?>>
						<a href="#" class="pattern_10">
							<span class="tick"></span>
						</a>
					</li>
				</ul>
			</li>
			<li class="clearfix hide_on_mobile">
				<label class="single_label"><?php _e("Boxed Layout Image", 'pressroom'); ?></label>
				<ul class="layout_chooser">
					<li<?php echo ((!isset($_COOKIE['pr_layout_style']) && (!isset($theme_options['layout_style']) || $theme_options['layout_style']=='image_1')) || (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']=='image_1') ? ' class="selected"' : ''); ?>>
						<a href="#" class="image_1">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo ((!isset($_COOKIE['pr_layout_style']) && $theme_options['layout_style']=='image_2') || (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']=='image_2') ? ' class="selected"' : ''); ?>>
						<a href="#" class="image_2">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo ((!isset($_COOKIE['pr_layout_style']) && $theme_options['layout_style']=='image_3') || (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']=='image_3') ? ' class="selected"' : ''); ?>>
						<a href="#" class="image_3">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo ((!isset($_COOKIE['pr_layout_style']) && $theme_options['layout_style']=='image_4') || (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']=='image_4') ? ' class="selected"' : ''); ?>>
						<a href="#" class="image_4">
							<span class="tick"></span>
						</a>
					</li>
					<li class="last<?php echo ((!isset($_COOKIE['pr_layout_style']) && $theme_options['layout_style']=='image_5') || (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']=='image_5') ? ' selected' : '') . '"'; ?>>
						<a href="#" class="image_5">
							<span class="tick"></span>
						</a>
					</li>
					<li class="first">
						<input type="checkbox"<?php echo ((!isset($_COOKIE['pr_image_overlay']) && $theme_options['layout_image_overlay']=='overlay') || ((isset($_COOKIE['pr_image_overlay']) && $_COOKIE['pr_image_overlay']=='overlay') || (!isset($_COOKIE['pr_image_overlay']) && $theme_options['layout_image_overlay']=='')) ? ' checked="checked"' : ''); ?> id="overlay"><label class="overlay_label" for="overlay"><?php _e("Overlay", 'pressroom'); ?></label>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</div>
