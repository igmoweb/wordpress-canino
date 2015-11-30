<?php

/*
Plugin Name: Real Post Slider Lite
Plugin URI: http://wordpress.org/plugins/wp/
Description: Works as a post slider (lite version)
Author: Vojislav Kovacevic
Version: 2.4
Author URI: http://wordpress.org/plugins/wp/
*/
add_action( 'init', 'vkrpsl_options' );
function vkrpsl_options() {
    add_option( 'vkrpsl_cat_name', 'uncategorized' );
    add_option( 'vkrpsl_slider_width', 800 );
    add_option( 'vkrpsl_char_limit', 150 );
    add_option( 'vkrpsl_autoplay', 'false' );
    add_option( 'vkrpsl_autoplay_speed', 5 );
    add_option( 'vkrpsl_thumb_width', 50 );
    add_option( 'vkrpsl_thumb_height', '' );
    add_option( 'vkrpsl_nav_arrows', 'no' );
    add_option( 'vkrpsl_visible', 3 );
    add_option( 'vkrpsl_order', '' );
    add_option( 'vkrpsl_ascdesc', 'ASC' );
} 
add_action( 'admin_menu', 'vkrpsl_add_config_page' );
function vkrpsl_add_config_page() {
    add_options_page( 
        'Real Post Slider Lite Options', 
        'Real Post Slider Lite', 
        'manage_options',
        basename(__FILE__), 
        'vkrpsl_config_page'
    );
} 
function vkrpsl_config_page() {

    if ( isset($_POST['submit']) ) { 
        $nonce = $_REQUEST['_wpnonce'];
        if (! wp_verify_nonce($nonce, 'vkrpsl-updatesettings' ) ) {
            die('security error');
        }
        $cat_name = $_POST['cat-name'];
        $slider_width = $_POST['slider-width'];
        $char_limit = $_POST['char-limit'];
        $autoplay = $_POST['autoplay'];
        $autoplay_speed = $_POST['autoplay-speed'];
        $thumb_width = $_POST['thumb-width'];
        $thumb_height = $_POST['thumb-height'];
        $nav_arrows = $_POST['nav-arrows'];
        $visible = $_POST['visible'];
        $order = $_POST['order'];
        $ascdesc = $_POST['ascdesc'];
        update_option( 'vkrpsl_cat_name', $cat_name );
        update_option( 'vkrpsl_slider_width', $slider_width );
        update_option( 'vkrpsl_char_limit', $char_limit );
        update_option( 'vkrpsl_autoplay', $autoplay );
        update_option( 'vkrpsl_autoplay_speed', $autoplay_speed );
        update_option( 'vkrpsl_thumb_width', $thumb_width );
        update_option( 'vkrpsl_thumb_height', $thumb_height );
        update_option( 'vkrpsl_nav_arrows', $nav_arrows );
        update_option( 'vkrpsl_visible', $visible );
        update_option( 'vkrpsl_order', $order );
        update_option( 'vkrpsl_ascdesc', $ascdesc );
    } 
    $vkrpsl_cat_name = get_option( 'vkrpsl_cat_name' );
    $vkrpsl_slider_width = get_option( 'vkrpsl_slider_width' );
    $vkrpsl_char_limit = get_option( 'vkrpsl_char_limit' );
    $vkrpsl_autoplay = get_option( 'vkrpsl_autoplay' );
    $vkrpsl_autoplay_speed = get_option( 'vkrpsl_autoplay_speed' );
    $vkrpsl_thumb_width = get_option( 'vkrpsl_thumb_width' );
    $vkrpsl_thumb_height = get_option( 'vkrpsl_thumb_height' );
    $vkrpsl_nav_arrows = get_option( 'vkrpsl_nav_arrows' );
    $vkrpsl_visible = get_option( 'vkrpsl_visible' );
    $vkrpsl_order= get_option( 'vkrpsl_order' );
    $vkrpsl_ascdesc= get_option( 'vkrpsl_ascdesc' );

    ?>

    <style type="text/css">

    .postbox {
      float: left;
      height: 90px;
      margin-left: 20px;
      padding: 20px;
      width: 300px;
    }

    </style>

    <div class="wrap">
        <h2>Real Post Slider Lite options</h2>

        <form action="" method="post" id="vkrpsp-config">

        <table class="form-table">
        <?php wp_nonce_field('vkrpsl-updatesettings'); ?>

        <tr>
            <div class="postbox">
                <p>Check out the enhanced, premium version of this plugin here: <br><a href="http://www.jultranet.com/wp/" target="_blank">Real Post Slider Plus Responsive</a><br>
                Demo: <a href="http://jultranet.com/wp/real-post-slider-plus-responsive/" target="_blank">DEMO</a>
                </p>
            </div> <!-- end .postbox -->

            <div class="postbox">
                <p>Checkout Featured Posts Slider - a great slider to display posts: 
                <br><a href="http://www.jultranet.com/wp/" target="_blank">Real Post Slider Plus Responsive</a><br>
                Demo: <a href="http://jultranet.com/wp/fps/" target="_blank">DEMO</a>
                </p>
            </p>
            </div> <!-- end .postbox -->

            <div class="postbox">
                <p>For a bigger, news-like featured slider, check out <br><a href="http://www.jultranet.com/wp/" target="_blank">Real Post Slider Pro DEMO</a><br>
                Demo: <a href="http://jultranet.com/wp/rps-pro/" target="_blank">DEMO</a>
                </p>
            </div> <!-- end .postbox -->

            <div class="clear"></div>
        </tr>

        <tr>
            <th scope="row" valign="top">
            <label for="cat-name">
                Category name:
            </label>
            </th>
            <td>
                <input type="text" name="cat-name" id="cat-name" class="regular-text" value="<?php echo $vkrpsl_cat_name; ?>">
            </td>
        </tr>

        <tr>
            <th scope="row" valign="top">
            <label for="slider-width">
                Slider width:
            </label>
            </th>
            <td>
                <input type="text" name="slider-width" id="slider-width" class="regular-text" value="<?php echo $vkrpsl_slider_width; ?>">
            </td>
        </tr>

        <tr>
            <th scope="row" valign="top">
            <label for="slider-width">
                Visible items:
            </label>
            </th>
            <td>
                <input type="text" name="visible" id="slider-width" class="regular-text" value="<?php echo $vkrpsl_visible; ?>">
            </td>
        </tr>

        <tr>
            <th scope="row" valign="top">
            <label for="nav-pos">
               Post ordering:
            </label>
            </th>
            <td>
                <input type="radio" name="ascdesc" id="asc" class="regular-textt" value="ASC" <?php if ($vkrpsl_ascdesc == 'ASC') echo 'checked="checked"'; ?>>
                <label for="asc">ASC</label>
                <input type="radio" name="ascdesc" id="desc" class="regular-textt" value="DESC" <?php if ($vkrpsl_ascdesc == 'DESC') echo 'checked="checked"'; ?>>
                <label for="desc">DESC</label>
            </td>
        </tr>

        <tr>
            <th scope="row" valign="top">
            <label for="slider-width">
                Custom post ordering:
            </label>
            </th>
            <td>
                <input type="text" name="order" id="slider-width" class="regular-text" value="<?php echo $vkrpsl_order; ?>">
            </td>
        </tr>

        <tr>
            <th scope="row" valign="top">
            <label for="char-limit">
                Max number of characters in slides:
            </label>
            </th>
            <td>
                <input type="text" name="char-limit" id="char-limit" class="regular-text" value="<?php echo $vkrpsl_char_limit; ?>">
            </td>
        </tr>

        <tr>
            <th scope="row" valign="top">
            <label for="nav-pos">
               Disable navigation arrows:
            </label>
            </th>
            <td>
                <input type="radio" name="nav-arrows" id="na-no" class="regular-textt" value="no" <?php if ($vkrpsl_nav_arrows == 'no') echo 'checked="checked"'; ?>>
                <label for="na-no">No</label>
                <input type="radio" name="nav-arrows" id="na-yes" class="regular-textt" value="yes" <?php if ($vkrpsl_nav_arrows == 'yes') echo 'checked="checked"'; ?>>
                <label for="na-yes">Yes</label>
            </td>
        </tr>

        <tr>
            <th scope="row" valign="top">
            <label for="autoplayy">
                Autoplay:
            </label>
            </th>
            <td>
                <input type="radio" name="autoplay" id="ap-no" class="regular-textt" value="false" <?php if ($vkrpsl_autoplay == 'false') echo 'checked="checked"'; ?>>
                <label for="ap-no">No</label>
                <input type="radio" name="autoplay" id="ap-yes" class="regular-textt" value="true" <?php if ($vkrpsl_autoplay == 'true') echo 'checked="checked"'; ?>>
                <label for="ap-yes">Yes</label>
            </td>
        </tr>

        <tr>
            <th scope="row" valign="top">
            <label for="autoplay-speed">
                Autoplay speed (in seconds):
            </label>
            </th>
            <td>
                <input type="text" name="autoplay-speed" id="autoplay-speed" class="regular-text" value="<?php echo $vkrpsl_autoplay_speed; ?>">
            </td>
        </tr>

        <tr>
            <th scope="row" valign="top">
            <label for="thumb-width">
                Thumbnail width:
            </label>
            </th>
            <td>
                <input type="text" name="thumb-width" id="thumb-width" class="regular-text" value="<?php echo $vkrpsl_thumb_width; ?>">
            </td>
        </tr>

        <tr>
            <th scope="row" valign="top">
            <label for="thumb-width">
                Thumbnail height:
            </label>
            </th>
            <td>
                <input type="text" name="thumb-height" id="thumb-height" class="regular-text" value="<?php echo $vkrpsl_thumb_height; ?>">
            </td>
        </tr>

        </table>

        <p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit"></p>
        </form>
    </div> <!-- end .wrap -->
<?php
}
add_action('wp_enqueue_scripts', 'vkrpsl_get_scripts');
function  vkrpsl_get_scripts() {
    wp_enqueue_script(
        'slidesjs',
        plugins_url('js/jquery.lbslider.js', __FILE__),
        array( 'jquery' )
    );
        wp_enqueue_style( 'vkrpslcss', plugins_url('css/vkrpsl.css', __FILE__) );
} 
function vkrpsl_do_slider() {
    wp_enqueue_script(
        'vkrpsl',
        plugins_url('js/vkrpsl.js', __FILE__),
        array( 'jquery' )
    );
    $vkrpsl_cat_name = get_option( 'vkrpsl_cat_name' );
    $vkrpsl_slider_width = get_option( 'vkrpsl_slider_width' );
    $vkrpsl_char_limit = get_option( 'vkrpsl_char_limit' );
    $vkrpsl_autoplay = get_option( 'vkrpsl_autoplay' );
    $vkrpsl_autoplay_speed = get_option( 'vkrpsl_autoplay_speed' );
    $vkrpsl_thumb_width = get_option( 'vkrpsl_thumb_width' );
    $vkrpsl_thumb_height = get_option( 'vkrpsl_thumb_height' );
    $vkrpsl_nav_arrows = get_option( 'vkrpsl_nav_arrows' );
    $vkrpsl_visible = get_option( 'vkrpsl_visible' );
    $vkrpsl_order = get_option( 'vkrpsl_order' );
    $vkrpsl_ascdesc = get_option( 'vkrpsl_ascdesc' );

    $params = array(
        'slider_width' => $vkrpsl_slider_width,
        'autoplay' => $vkrpsl_autoplay,
        'autoplay_speed' => $vkrpsl_autoplay_speed,
        'nav_arrows' => $vkrpsl_nav_arrows,
        'visible' => $vkrpsl_visible
    );
    wp_localize_script('vkrpsl', 'vkrpsl_object', $params);
    ?>

    <div class="slider-wrap">
      <div class="vkrpsl-slider">
      <?php
      if (empty($vkrpsl_order)) { 
        $cat_id = get_cat_id($vkrpsl_cat_name);
        $the_query = new WP_Query( array('category__in' => $cat_id, 'order' => $vkrpsl_ascdesc,  'posts_per_page'=>-1) );
      } else {
          $s = explode(',', $vkrpsl_order);
          $arr = array('post__in' => $s, 'orderby' => 'post__in');
          $the_query = new WP_Query( $arr );
      }

      if ( $the_query->have_posts() ) {

              echo '<ul>';

          while ( $the_query->have_posts() ) {
              $the_query->the_post();
              echo '<li>';
              echo  '<a href='.get_permalink().' class=imglink>';
              echo the_post_thumbnail('rpsl_image');
              echo '</a>';
              echo  '<a href='.get_permalink().'>'.get_the_title() . '</a>';
              echo '<p>'.substr(strip_tags(get_the_content()), 0, $vkrpsl_char_limit).'...</p>';
              echo '</li>';
          }
              echo '</ul>';

      } else {
          echo 'no posts found';
      }
      wp_reset_postdata();
      
      ?>
      </div>
      <a href="#" class="slider-arrow sa-left">&lt;</a> <a href="#" class="slider-arrow sa-right">&gt;</a>
    </div>

<?php
} 
$tw = get_option( 'vkrpsl_thumb_width' );
$th = get_option( 'vkrpsl_thumb_height' );

if ( empty($tw) ) {
    add_image_size('rpsl_image', $tw);
} else {
    add_image_size('rpsl_image', $tw, $th, true);
}
add_theme_support('post-thumbnails');

add_filter('widget_text', 'do_shortcode');

add_shortcode('vkrpsl', 'vkrpsl_do_slider');
?>