<?php
/**
 * Adds content to the plugin's options page
 *
 */
function WPSP_Options_Page() {
	if (isset($_POST['action']) === true) {
		$options_string = "";
		if(isset($_POST["sd_transition_time"])){
			$options_string .= "transition_time:".$_POST["sd_transition_time"];
		}
		if(isset($_POST["sd_braeking_enabled"])){
			$options_string .= "~get_braeking:true";
		}else{
			$options_string .= "~get_braeking:0";
		}
		if(isset($_POST["sd_automatic_enabled"])){
			$options_string .= "~get_slider:true";
		}else{
			$options_string .= "~get_slider:0";
		}
		if(isset($_POST["sd_slider_color"])){
			$sd_post = $_POST["sd_slider_color"];
			$options_string .= "~slider_color:".$sd_post;
		}
		if(isset($_POST["sd_text_color"])){
			$sd_post = $_POST["sd_text_color"];
			$options_string .= "~text_color:".$sd_post;
		}
		if(isset($_POST["sd_link_color"])){
			$sd_post = $_POST["sd_link_color"];
			$options_string .= "~link_color:".$sd_post;
		}
		if(isset($_POST["sd_number_news"])){
			$sd_post = $_POST["sd_number_news"];
			$options_string .= "~number_news:".$sd_post;
		}else{
			$options_string .= "~number_news:0";
		}
		if(isset($_POST["sd_number_enabled"])){
			$sd_post = $_POST["sd_number_enabled"];
			$options_string .= "~number_post:".$sd_post;
		}else{
			$options_string .= "~number_post:0";
		}
		if(isset($_POST["sd_word_enabled"])){
			$sd_post = $_POST["sd_word_enabled"];
			$options_string .= "~number_word:".$sd_post;
		}else{
			$options_string .= "~number_word:0";
		}
		if(isset($_POST["sd_posts_news"])){
			$sd_post = $_POST["sd_posts_news"];
			$options_string .= "~posts_news:".$sd_post;
		}else{
			$options_string .= "~posts_news:0";
		}
		if(isset($_POST["sd_id_news"])){
			$sd_post = $_POST["sd_id_news"];
			$options_string .= "~id_news:".$sd_post;
		}else{
			$options_string .= "~id_news:0";
		}
		if(isset($_POST["sd_posts_enabled"])){
			$sd_post = $_POST["sd_posts_enabled"];
			$options_string .= "~posts_slider:".$sd_post;
		}else{
			$options_string .= "~posts_slider:0";
		}
		if(isset($_POST["sd_id_enabled"])){
			$sd_post = $_POST["sd_id_enabled"];
			$options_string .= "~posts_id:".$sd_post;
		}else{
			$options_string .= "~posts_id:0";
		}
		if(isset($_POST["sd_bullets_enabled"])){
			$sd_post = $_POST["sd_bullets_enabled"];
			$options_string .= "~bullets_slider:".$sd_post;
		}else{
			$options_string .= "~bullets_slider:0";
		}
		if(isset($_POST["sd_category_news"])){
			$sd_post = $_POST["sd_category_news"];
			$options_string .= "~category_news:".$sd_post;
		}else{
			$options_string .= "~category_news:0";
		}
		if(isset($_POST["sd_category_enabled"])){
			$sd_post = $_POST["sd_category_enabled"];
			$options_string .= "~category_slider:".$sd_post;
		}else{
			$options_string .= "~category_slider:0";
		}
		update_option( "wp_slideshow_posts_options", $options_string );
	}

	if( isset( $_REQUEST['action'] ) ){
		if( 'reset' == $_REQUEST['action'] ) {
		update_option( "wp_slideshow_posts_options", "transition_time:5000~get_braeking:true~slider_color:#000000~text_color:#ffffff~link_color:#666666~get_slider:true~bullets_slider:1~number_word:100~number_news:3~number_post:3~posts_news:1~posts_slider:1~posts_id:0~category_slider:Choose a category" );
		}
	}

$sc_options = WPSP_GetOptions();
?>

<style type="text/css">
.wrap .mw-panel-tabs {
	background: #ffffff;
}
.wrap .mw-panel-tabs ul {
	height:47px;
	border-bottom:1px solid #ddd;
	margin:0;
}
.wrap .mw-panel-tabs li {
	list-style:none;
	float:left;
	border-right: 1px solid #ddd;
	margin-bottom: 0;
}
.wrap .mw-panel-tabs li a {
	background:#F5F5F5;
	height:17px;
	border-bottom: 1px solid #ddd;
	padding: 15px 20px;
	display: block;
	color: white;
	cursor: pointer;
	border: 0;
	opacity: .8;
	outline: none;
	font-weight: bold;
	text-decoration: none;
	-webkit-transition: background ease-in-out 0.2s , padding  ease-in-out 0.2s;
	-moz-transition: background ease-in-out 0.2s , padding  ease-in-out 0.2s;
	-o-transition: background ease-in-out 0.2s , padding  ease-in-out 0.2s;
	transition: background  ease-in-out 0.2s , padding  ease-in-out 0.2s;
	color: #55606E;
}
.wrap .mw-panel-tabs li a:hover {
	opacity: 1;
}
.wrap .mw-panel-tabs li.active {
	position: relative;
}
.wrap .mw-panel-tabs li.active a {
	color: #000;	
	opacity: 1;
	height:18px;
	background: #FFFFFF;
}
.wrap {
	border: 1px solid #DFDFDF;
	padding: 0;
	background: #fff;
	position: relative;
}
.wrap #plugin-header h3 {
	font-size: 18px;
	font-weight: bold;
	color: #1982d1;
	padding: 8px 20px;
}
.wrap #row_item {
	background: #FAFAFA;
	border: 1px solid #DFDFDF;
	margin: 20px;
	padding: 20px;
}
.box-min {
	display: inline-block;
	margin: 0 3% 0 0;
}
.wrap .inside {
	margin: 0 0 0 22px;
}
.wrap #row_item h3 {
	font-size: 14px;
	font-weight: bold;
	line-height: 0.7;
	padding: 0 0 15px;
	color: #555;
	margin: 0;
}
#sd_category_enabled {
	width: 200px;
}
.plugin-info {
	border-left: 4px solid #2EA2CC;
	border-top: 1px solid #2EA2CC;
	border-right: 1px solid #2EA2CC;
	border-bottom: 1px solid #2EA2CC;
	background-color:#F7FCFE;
	color: #555555;
}
.plugin-info {
	border-radius: 3px;
	font-size: 12px;
	line-height: 19px;
	margin: 15px auto 0;
	padding: 0 20px;
}
input[type="text"] {
	margin-top:10px;
}
.form-reset {
	position: absolute;
	right: 42px;
	bottom: 35px;
}
.reset {
	background: #f5f5f5;
	-moz-box-sizing: border-box;
	border-color: #777;
	border-radius: 3px;
	border-style: solid;
	border-width: 1px;
	cursor: pointer;
	display: inline-block;
	font-size: 13px;
	height: 28px;
	line-height: 26px;
	margin: 0;
	text-decoration: none;
	padding: 0 10px 1px;
	white-space: nowrap;
}
.reset:hover {
	background: #333;
	border-color: #111;
	color: #FFFFFF;
	text-decoration: none;
}
</style>

<div class="wrap">
	<div class="mw-panel-tabs">
		<ul>
			<li class="sw-tabs general"><a href="#tab1"><span></span>General</a></li>
			<li class="sw-tabs count"><a href="#tab2"><span></span>Full Slideshow</a></li>
			<li class="sw-tabs sharer"><a href="#tab3"><span></span>Small Slideshow</a></li>
		</ul>
		<div class="clear"></div>
	</div> <!-- .sw-panel-tabs -->

		<form name="sc_form" id="sc_form" action="" method="post">
		<input type="hidden" name="action" value="edit" />

		<div id="tab1" class="tabs-box">
			<div id="plugin-header">
				<h3>Genenal Options Slideshow</h3>
			</div>

		<div id="row_item">
			<h3>Transition Time</h3>
		<select style="width:200px" name="sd_transition_time" id="sd_transition_time" class="regular-text">
		<?php $interval_fields = array(
				__( '2000', 'wpsp' ) => '2000',
				__( '5000', 'wpsp' ) => '5000',
				__( '8000', 'wpsp' ) => '8000',
				__( '11000', 'wpsp' ) => '11000',
				__( '14000', 'wpsp' ) => '14000',
				__( '17000', 'wpsp' ) => '17000',
				__( '20000', 'wpsp' ) => '20000'
				);
		foreach ($interval_fields as $shown => $value) {
		if($sc_options['transition_time'] == $value){ ?>

		<option value="<?php echo $value; ?>" selected="selected" ><?php echo $shown; ?></option>
		<?php }else{ ?>
		<option value="<?php echo $value; ?>" ><?php echo $shown; ?></option>
		<?php } } ?>
		</select>
		</div>

		<div id="row_item">
<span class="box-min">
			<h3>Slider Color</h3>
<input maxlength="200" name="sd_slider_color" id="sd_slider_color" type="text" value="<?php echo ( $sc_options['slider_color']!='0' ) ? $sc_options['slider_color'] : '' ?>" class="color-picker" />
</span>
<span class="box-min">
			<h3>Text Color</h3>
<input maxlength="200" name="sd_text_color" id="sd_text_color" type="text" value="<?php echo ( $sc_options['text_color']!='0' ) ? $sc_options['text_color'] : '' ?>" class="color-picker" />
</span>
		</div>
			</div><!-- and tab#1 -->

		<div id="tab2" class="tabs-box">
			<div id="plugin-header">
				<h3>Settings Full Slideshow</h3>
			</div>

		<div id="row_item">
		<label for"sd_automatic" class="labels">
		<input type="checkbox" name="sd_automatic_enabled" id="sd_automatic_enabled" class="checkboxr" <?php echo ( $sc_options['get_slider']=='true' ) ? ' checked="checked"' : '' ?>" >&nbsp;Show Full Slideshow?
		</label>
		<div class="plugin-info">
		<br />
		<h3>Insert one of code below in your template to show slideshow in blog.</h3>
		<b>1. For display complete slideshow:</b>
		<p>&lt;?Php if ( function_exists( 'wpsp_Slideshow' ) ) { wpsp_Slideshow(); } ?&gt;</p>

		<b>2. For display complete slideshow into the post:</b>
		<p>[slideshow-wpsp]</p>
		<br />

		<h3>Individual Configuration</h3>

		<b>1. Disable Title:</b>
		<p>&lt;?Php if ( function_exists( 'wpsp_Slideshow' ) ) { wpsp_Slideshow('0,1,1,1'); } ?&gt;
		</p>
		<p>
		[slideshow-wpsp display="0,1,1,1"]
		</p>

		<b>2. Disable Summary:</b>
		<p>&lt;?Php if ( function_exists( 'wpsp_Slideshow' ) ) { wpsp_Slideshow('1,0,1,1'); } ?&gt;
		</p>
		<p>
		[slideshow-wpsp display="1,0,1,1"]
		</p>

		<b>3. Disable PREV/NEXT Button:</b>
		<p>&lt;?Php if ( function_exists( 'wpsp_Slideshow' ) ) { wpsp_Slideshow('1,1,0,1'); } ?&gt;
		</p>
		<p>
		[slideshow-wpsp display="1,1,0,1"]
		</p>

		<b>4. Disable Pagination:</b>
		<p>&lt;?Php if ( function_exists( 'wpsp_Slideshow' ) ) { wpsp_Slideshow('1,1,1,0'); } ?&gt;
		</p>
		<p>
		[slideshow-wpsp display="1,1,1,0"]
		</p>

		</div>
		</div>

		<div id="row_item">
			<h3>Number of Posts</h3>
		<input type="text" maxlength="125" size="5" name="sd_number_enabled" id="sd_number_enabled" value="<?php echo ( $sc_options['number_post']!='0' ) ? $sc_options['number_post'] : '' ?>">
		<span class="description">
 &nbsp;&nbsp;<small>Enter Number Post In Slider</small>.
		</span>
		</div>

		<div id="row_item">
			<h3>Choose Post Type</h3>
	 <?php $options = array(
			'1' => 'Recent Post',
			'2' => 'Popular Post',
			'3' => 'Category <small>( Use select category slider )</small>',
			'4' => 'Posts by ID <small>( Enter id post below )</small>',
			'5' => 'Pages',
			'6' => 'Pages by ID <small>( Enter id post below )</small>',
			'7' => 'Post Type <small>( Enter the name of the post type below )</small>'
		);
		foreach ( $options as $key=>$option ) {
		$radio_setting = $sc_options['posts_slider'];
			if( $radio_setting != '' ){
				if ( $key == $radio_setting ) {
						$checked = "checked=\"checked\"";
						} else {
							$checked = "";
						}
				} ?>
				<input type="radio" name="sd_posts_enabled" id="sd_posts_enabled<?php echo $key; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> />
<label for="sd_posts_enabled<?php echo $key; ?>"> &nbsp;&nbsp;<?php echo $option; ?></label><br />
				<?php } ?>
		<input type="text" maxlength="128" size="32" name="sd_id_enabled" id="sd_id_enabled" value="<?php echo ( $sc_options['posts_id']!='0' ) ? $sc_options['posts_id'] : '' ?>"> 
		<div class="description">
		<small>Enter ids Posts or Pages, or name of the post type separated by comma <br/>ie: 1,55,305 or movie,book,labs</small> 
		</div>
		</div>

		<div id="row_item">
			<h3>Select Category Slider</h3>
<?php
		$radio_setting = $sc_options['category_slider'];

$categories = get_categories( 'hide_empty=0&orderby=name' );
$wp_cats = array();
foreach ( $categories as $category_list ) {
       $wp_cats[$category_list->cat_ID] = $category_list->cat_name;
}
array_unshift( $wp_cats, "Choose a category" ); ?>


	<select name="sd_category_enabled" id="sd_category_enabled">
	<?php foreach ( $wp_cats as $option ) { ?>

	<option <?php if ( $radio_setting == $option ) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>

	<?php } ?>
	</select>
		</div>

		<div id="row_item">
			<h3>Word Count Description</h3>
		<input type="text" maxlength="125" size="5" name="sd_word_enabled" id="sd_word_enabled" value="<?php echo ( $sc_options['number_word']!='0' ) ? $sc_options['number_word'] : '' ?>">
		<span class="description">
 &nbsp;&nbsp;<small>Enter Number of Words</small>.
		</span>
		</div>

		<div id="row_item">
			<h3>Pagination Type</h3>
	 <?php $options = array(
			'1' => 'With Numbers',
			'2' => 'Without Numbers'
		);
		foreach ( $options as $key=>$option ) {
		$radio_setting = $sc_options['bullets_slider'];
			if( $radio_setting != '' ){
				if ( $key == $radio_setting ) {
						$checked = "checked=\"checked\"";
						} else {
							$checked = "";
						}
				} ?>
				<input type="radio" name="sd_bullets_enabled" id="sd_bullets_enabled<?php echo $key; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> />
<label for="sd_bullets_enabled<?php echo $key; ?>"> &nbsp;&nbsp;<?php echo $option; ?></label><br />
				<?php } ?>
		</div>

			</div><!-- and tab#2 -->
		<div id="tab3" class="tabs-box">
				<div id="plugin-header">
					<h3>Settings Small Slideshow</h3>
				</div>

		<div id="row_item">
		<label for"sd_braeking" class="labels">
		<input type="checkbox" name="sd_braeking_enabled" id="sd_braeking_enabled" class="checkboxr" <?php echo ( $sc_options['get_braeking']=='true' ) ? ' checked="checked"' : '' ?>" >&nbsp;Show Small Slideshow?
		</label>
		<div class="plugin-info">
		<br />
		<h3>Use the code below to show breaking news.</h3>

		<b>1. Insert code in template place display:</b>
		<p>&lt;?Php if ( function_exists( 'wpsp_breakingnews' ) ) { 
				wpsp_breakingnews();
		 } ?&gt;</p>
		</div>
		</div>

		<div id="row_item">
			<h3>Number of Posts</h3>
		<input type="text" maxlength="125" size="5" name="sd_number_news" id="sd_number_news" value="<?php echo ( $sc_options['number_news']!='0' ) ? $sc_options['number_news'] : '' ?>">
		<span class="description">
 &nbsp;&nbsp;<small>Enter Number Post In Slider</small>.
		</span>
		</div>

		<div id="row_item">
<span class="box-min">
			<h3>Title Link Color</h3>
<input maxlength="200" name="sd_link_color" id="sd_link_color" type="text" value="<?php echo ( $sc_options['link_color']!='0' ) ? $sc_options['link_color'] : '' ?>" class="color-picker" />
</span>
		</div>

		<div id="row_item">
			<h3>Choose Post Type</h3>
	 <?php $options = array(
			'1' => 'Recent Post',
			'2' => 'Popular Post',
			'3' => 'Category <small>( Use select category slider )</small>',
			'4' => 'Posts by ID <small>( Enter id post below )</small>',
			'5' => 'Pages',
			'6' => 'Pages by ID <small>( Enter id post below )</small>',
			'7' => 'Post Type <small>( Enter the name of the post type below )</small>'
		);
		foreach ( $options as $key=>$option ) {
		$radio_setting = $sc_options['posts_news'];
			if( $radio_setting != '' ){
				if ( $key == $radio_setting ) {
						$checked = "checked=\"checked\"";
						} else {
							$checked = "";
						}
				} ?>
				<input type="radio" name="sd_posts_news" id="sd_posts_news<?php echo $key; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> />
<label for="sd_posts_news<?php echo $key; ?>"> &nbsp;&nbsp;<?php echo $option; ?></label><br />
				<?php } ?>
		<input type="text" maxlength="128" size="32" name="sd_id_news" id="sd_id_news" value="<?php echo ( $sc_options['id_news']!='0' ) ? $sc_options['id_news'] : '' ?>"> 
		<div class="description">
		<small>Enter ids Posts or Pages, or name of the post type separated by comma <br/>ie: 1,55,305 or movie,book,labs</small> 
		</div>
		</div>

		<div id="row_item">
			<h3>Select Category Slider</h3>
<?php
		$radio_setting = $sc_options['category_news'];

$categories = get_categories( 'hide_empty=0&orderby=name' );
$wp_cats = array();
foreach ( $categories as $category_list ) {
       $wp_cats[$category_list->cat_ID] = $category_list->cat_name;
}
array_unshift( $wp_cats, "Choose a category" ); ?>


	<select name="sd_category_news" id="sd_category_news">
	<?php foreach ( $wp_cats as $option ) { ?>

	<option <?php if ( $radio_setting == $option ) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>

	<?php } ?>
	</select>
		</div>

			</div><!-- and tab#3 -->

		<div class="inside">
		<p class="submit">
		<input type="submit" name="submit" value="Save Options &raquo;" class="button-primary" />
		</p>
		</div>
		</form>

		<span class="form-reset">
		 	<form method="post">
				<input class="reset" name="reset" type="submit" value="Reset Settings" />
				<input type="hidden" name="action" value="reset" />
			</form>
		</span>

</div><!-- and wrap -->
<?php } ?>
