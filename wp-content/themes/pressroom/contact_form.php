<?php
global $themename;
//contact form
function pr_theme_contact_form_shortcode($atts)
{
	extract(shortcode_atts(array(
		"id" => "contact_form",
		"top_margin" => "none",
		"el_class" => ""
	), $atts));
	
	$output = "";
	$output .= '<form class="contact_form ' . ($top_margin!="none" ? $top_margin : '') . ($el_class!="" ? ' ' . $el_class : '') . '" id="' . $id . '" method="post" action="#">
		<fieldset class="vc_col-sm-4 wpb_column vc_column_container">
			<div class="block">
				<input class="text_input" name="name" type="text" value="' . __("Your Name *", 'pressroom') . '" placeholder="' . __("Your Name *", 'pressroom') . '">
			</div>
		</fieldset>
		<fieldset class="vc_col-sm-4 wpb_column vc_column_container">
			<div class="block">
				<input class="text_input" name="email" type="text" value="' . __("Your Email *", 'pressroom') . '" placeholder="' . __("Your Email *", 'pressroom') . '">
			</div>
		</fieldset>
		<fieldset class="vc_col-sm-4 wpb_column vc_column_container">
			<div class="block">
				<input class="text_input" name="subject" type="text" value="' . __("Subject", 'pressroom') . '" placeholder="' . __("Subject", 'pressroom') . '">
			</div>
		</fieldset>
		<fieldset>
			<div class="block">
				<textarea class="margin_top_10" name="message" placeholder="' . __("Message *", 'pressroom') . '">' . __("Message *", 'pressroom') . '</textarea>
			</div>
		</fieldset>
		<fieldset>
			<input type="hidden" name="action" value="theme_contact_form">
			<input type="hidden" name="id" value="' . $id . '">
			<input type="submit" name="submit" value="' . __("SEND MESSAGE", 'pressroom') . '" class="more active">
		</fieldset>
	</form>';
	return $output;
}
add_shortcode($themename . "_contact_form", "pr_theme_contact_form_shortcode");

//visual composer
function pr_theme_contact_form_vc_init()
{
	wpb_map( array(
		"name" => __("Contact form", 'pressroom'),
		"base" => "pressroom_contact_form",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-contact-form",
		"category" => __('Pressroom', 'pressroom'),
		"params" => array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Id", 'pressroom'),
				"param_name" => "id",
				"value" => "contact_form",
				"description" => __("Please provide unique id for each contact form on the same page/post", 'pressroom')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Top margin", 'pressroom'),
				"param_name" => "top_margin",
				"value" => array(__("None", 'pressroom') => "none", __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section")
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
			)
		)
	));
}
add_action("init", "pr_theme_contact_form_vc_init");

//contact form submit
function pr_theme_contact_form()
{
	global $theme_options;

    require_once(locate_template("phpMailer/class.phpmailer.php"));

    $result = array();
	$result["isOk"] = true;
	if($_POST["name"]!="" && $_POST["name"]!=__("Your Name *", 'pressroom') && $_POST["email"]!="" && $_POST["email"]!=__("Your Email *", 'pressroom') && preg_match("#^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$#", $_POST["email"]) && $_POST["message"]!="" && $_POST["message"]!=__("Message *", 'pressroom'))
	{
		$values = array(
			"name" => $_POST["name"],
			"subject" => $_POST["subject"],
			"email" => $_POST["email"],
			"message" => $_POST["message"]
		);
		if((bool)ini_get("magic_quotes_gpc")) 
			$values = array_map("stripslashes", $values);
		$values = array_map("htmlspecialchars", $values);

		$mail=new PHPMailer();

		$mail->CharSet='UTF-8';

		$mail->SetFrom($values["email"], $values["name"]);
		$mail->AddAddress($theme_options["cf_admin_email"], $theme_options["cf_admin_name"]);

		$smtp = $theme_options["cf_smtp_host"];
		if(!empty($smtp))
		{
			$mail->IsSMTP();
			$mail->SMTPAuth = true; 
			$mail->Host = $theme_options["cf_smtp_host"];
			$mail->Username = $theme_options["cf_smtp_username"];
			$mail->Password = $theme_options["cf_smtp_password"];
			if((int)$theme_options["cf_smtp_post"]>0)
				$mail->Port = (int)$theme_options["cf_smtp_port"];
			$mail->SMTPSecure = $theme_options["cf_smtp_secure"];
		}
		
		$subject = ($values["subject"]!=__("Subject", 'pressroom') ? $values["subject"] : $theme_options["cf_email_subject"]);
		$subject = str_replace("[name]", $values["name"], $subject);
		$subject = str_replace("[email]", $values["email"], $subject);
		$subject = str_replace("[message]", $values["message"], $subject);
		$mail->Subject = $subject;
		$body = $theme_options["cf_template"];
		$body = str_replace("[name]", $values["name"], $body);
		$body = str_replace("[email]", $values["email"], $body);
		$body = str_replace("[message]", $values["message"], $body);
		$mail->MsgHTML($body);

		if($mail->Send())
			$result["submit_message"] = __("Thank you for contacting us", 'pressroom');
		else
		{
			$result["isOk"] = false;
			$result["submit_message"] = __("Sorry, we can't send this message", 'pressroom');
		}
	}
	else
	{
		$result["isOk"] = false;
		if($_POST["name"]=="" || $_POST["name"]==__("Your Name *", 'pressroom'))
			$result["error_name"] = __("Please enter your name.", 'pressroom');
		if($_POST["email"]=="" || $_POST["email"]==__("Your Email *", 'pressroom') || !preg_match("#^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$#", $_POST["email"]))
			$result["error_email"] = __("Please enter valid e-mail.", 'pressroom');
		if($_POST["message"]=="" || $_POST["message"]==__("Message *", 'pressroom'))
			$result["error_message"] = __("Please enter your message.", 'pressroom');
	}
	echo @json_encode($result);
	exit();
}
add_action("wp_ajax_theme_contact_form", "pr_theme_contact_form");
add_action("wp_ajax_nopriv_theme_contact_form", "pr_theme_contact_form");
?>