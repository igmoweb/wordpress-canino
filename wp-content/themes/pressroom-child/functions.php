<?php

add_action( 'wp_enqueue_scripts', 'pressroom_child_enqueue_styles' );
function pressroom_child_enqueue_styles() {
    wp_enqueue_style( 'pressroom-style', get_template_directory_uri() . '/style.css' );
    //post_formats
}

// Load translation files from your child theme instead of the parent theme
add_action( 'after_setup_theme', 'my_child_theme_locale' );
function my_child_theme_locale() {
    load_child_theme_textdomain( 'pressroom', get_stylesheet_directory() . '/languages' );
}

add_action( 'after_setup_theme', 'childtheme_formats', 11 );
function childtheme_formats(){
//    remove_theme_support('post-formats');
    add_theme_support( 'post-formats', array('aside', 'link', 'gallery', 'video') );
}

function rename_post_formats( $safe_text ) {
    if ( $safe_text == 'Aside' )
        return 'Artículo';
    elseif ( $safe_text == 'Link' )
        return 'Noticia';

    return $safe_text;
}
add_filter( 'esc_html', 'rename_post_formats' );

//rename Aside in posts list table
function live_rename_formats() {
    global $current_screen;

    if ( $current_screen->id == 'edit-post' ) { ?>
        <script type="text/javascript">
            jQuery('document').ready(function() {

                jQuery("span.post-state-format").each(function() {
                    if ( jQuery(this).text() == "Aside" )
                        jQuery(this).text("Artículo");
                    else if ( jQuery(this).text() == "Link" )
                        jQuery(this).text("Noticia");
                });

            });
        </script>
    <?php }
}
add_action('admin_head', 'live_rename_formats');

function change_article_excerpt($excerpt) {
    global $page, $pages;

    $has_teaser = false;

    if ( $page > count( $pages ) ) // if the requested page doesn't exist
        $page = count( $pages ); // give them the highest numbered page that DOES exist

    $content = $pages[$page - 1];
    if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
        $content = explode( $matches[0], $content, 2 );
        $has_teaser = true;
        $excerpt = $content[0];
    }

    return $excerpt;
}
add_filter( 'the_more_excerpt', 'change_article_excerpt' );

add_action('wp_footer', 'add_googleanalytics');

function add_googleanalytics() { ?>

	<script type="text/javascript">
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-66902738-1', 'auto');
		ga('send', 'pageview');
		
		jQuery(document).ready(function() {
			jQuery('.post img').hide();
			jQuery(window).load(function() {
				jQuery('.post img').fadeIn(800);
			});
		});
	</script>

<?php }

// Remove the default Thematic blogtitle function
function remove_thematic_actions() {
    remove_filter('vc_gitem_template_attribute_post_image_background_image_css','vc_gitem_template_attribute_post_image_background_image_css',10);
}
// Call 'remove_thematic_actions' (above) during WP initialization
add_action('vc_gitem_template_attribute_filter_terms_css_classes','remove_thematic_actions');

add_action('vc_gitem_template_attribute_post_image_background_image_css','custom_vc_gitem_template_attribute_post_image_background_image_css', 10,2);


/**
Modificación en wp-content\plugins\js_composer\include\params\vc_grid_item\attributes.php
 */
function custom_vc_gitem_template_attribute_post_image_background_image_css( $value, $data ) {

    $output = '';
    extract( array_merge( array(
        'post' => null,
        'data' => ''
    ), $data ) );
    if ( 'attachment' === $post->post_type ) {
        $src = wp_get_attachment_image_src( $post->ID, 'large' );
    } else {
        if( class_exists('Dynamic_Featured_Image') ) {
            global $dynamic_featured_image;
            $featuredImages = $dynamic_featured_image->get_featured_images($post->ID);
            if ($featuredImages[0]['attachment_id']) {
                $attachment_id = $featuredImages[0]['attachment_id'];
            } else {
                $attachment_id = get_post_thumbnail_id($post->ID);
            }
        } else {
            $attachment_id = get_post_thumbnail_id($post->ID);
        }
        $src = wp_get_attachment_image_src( $attachment_id, 'large' );
    }
    if ( ! empty( $src ) ) {
        $output = 'background-image: url(' . $src[0] . ') !important;';
    } else {
        $output = 'background-image: url(' . vc_asset_url( 'vc/vc_gitem_image.png' ) . ') !important;';
    }

    return apply_filters( 'vc_gitem_template_attribute_post_image_background_image_css_value', $output );
}

/* field groups*/
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_critica',
		'title' => 'Critica - Ficha',
		'fields' => array (
			array (
				'key' => 'fieldficha1',
				'label' => 'Titulo',
				'name' => 'titulo',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_55ef4562c5ffd',
				'label' => 'Portada',
				'name' => 'portada',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'fieldficha3',
				'label' => 'texto-ficha',
				'name' => 'texto-ficha',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha4',
				'label' => 'texto-ficha2',
				'name' => 'texto-ficha2',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha5',
				'label' => 'Año',
				'name' => 'year',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha6',
				'label' => 'cine-director',
				'name' => 'cine-director',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha7',
				'label' => 'cine-guion',
				'name' => 'cine-guion',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha8',
				'label' => 'cine-actores',
				'name' => 'cine-actores',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha9',
				'label' => 'cine-formatos',
				'name' => 'cine-formatos',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha10',
				'label' => 'comic-guionista',
				'name' => 'comic-guionista',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha11',
				'label' => 'comic-editorial',
				'name' => 'comic-editorial',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha12',
				'label' => 'comic-dibujante',
				'name' => 'comic-dibujante',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha13',
				'label' => 'musica-artista',
				'name' => 'musica-artista',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha14',
				'label' => 'musica-sello',
				'name' => 'musica-sello',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha15',
				'label' => 'game-estudio',
				'name' => 'game-estudio',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha16',
				'label' => 'game-distribuidora',
				'name' => 'game-distribuidora',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha17',
				'label' => 'game-plataformas',
				'name' => 'game-plataformas',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'fieldficha18',
				'label' => 'libro-editorial',
				'name' => 'libro-editorial',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' =>  'fieldficha19',
				'label' => 'libro-autor',
				'name' => 'libro-autor',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			)
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

function ficha_shortcode( $atts ) {

echo '<div class="wpb_column vc_column_container vc_col-sm-4 ficha-tecnica">';

$titulo =get_post_meta(get_the_ID(), 'titulo', true);
echo '<h2>' . $titulo . '<h2>';

$portada = get_field('portada');
$size='medium';
if( !empty($portada))
	echo '<img  width="330" height="auto"  src="'.$portada['url'].'" alt="'.$portada['alt'].'" />';

$text1 =get_post_meta(get_the_ID(), 'texto-ficha', true);
if (!empty($text1))  echo '<p><i>' . $text1 . '</i></p>';



echo '<p><ul>';
$cinedirector=get_post_meta(get_the_ID(), 'cine-director', true);
if( !empty($cinedirector   )){	echo '<li>'.    $cinedirector   .'</li>';}
$cineguion=get_post_meta(get_the_ID(), 'cine-guion', true);
if( !empty($cineguion   )){	echo '<li>'.    $cineguion   .'</li>';}
$cineactores=get_post_meta(get_the_ID(), 'cine-actores', true);
if( !empty($cineactores   )){	echo '<li>'.    $cineactores   .'</li>';}
$cineformato=get_post_meta(get_the_ID(), 'cine-formatos', true);
if( !empty($cineformato   )){	echo '<li>'.    $cineformato   .'</li>';}

$comicg=get_post_meta(get_the_ID(), 'comic-guionista', true);
if( !empty($comicg   )){	echo '<li>'.    $comicg   .'</li>';}
$comicd=get_post_meta(get_the_ID(), 'comic-dibujante', true);
if( !empty($comicd   )){	echo '<li>'.    $comicd   .'</li>';}
$comice=get_post_meta(get_the_ID(), 'comic-editorial', true);
if( !empty($comice   )){	echo '<li>'.    $comice   .'</li>';}

$musicaut=get_post_meta(get_the_ID(), 'musica-artista', true);
if( !empty($musicaut   )){	echo '<li>'.    $musicaut   .'</li>';}
$musicalab=get_post_meta(get_the_ID(), 'musica-sello', true);
if( !empty($musicalab   )){	echo '<li>'.    $musicalab   .'</li>';}

$gamestu=get_post_meta(get_the_ID(), 'game-estudio', true);
if( !empty($gamestu   )){	echo '<li>'.    $gamestu   .'</li>';}
$gamedis=get_post_meta(get_the_ID(), 'game-distribuidora', true);
if( !empty($gamedis   )){	echo '<li>'.    $gamedis   .'</li>';}
$gamepla=get_post_meta(get_the_ID(), 'game-plataformas', true);
if( !empty($gamepla   )){	echo '<li>'.    $gamepla   .'</li>';}


$libroaut=get_post_meta(get_the_ID(), 'libro-autor', true);
if( !empty($libroaut   )){	echo '<li>'.    $libroaut   .'</li>';}
$libroedi=get_post_meta(get_the_ID(), 'libro-editorial', true);
if( !empty($libroedi   )){	echo '<li>'.    $libroedi   .'</li>';}

$year=get_post_meta(get_the_ID(), 'year', true);
if( !empty($year   )){	echo '<li>'.    $year   .'</li>';}

echo '</ul></p>';



$text2 =get_post_meta(get_the_ID(), 'texto-ficha2', true);
if (!empty($text2)) {
	echo '<p>' . $text2 . '<p>';
}



echo '</p>';
echo '</div>';


}
 
add_shortcode( 'page_header', 'ficha_shortcode' );
add_action( 'vc_after_init', 'ficha_integrateWithVC' );
 
function ficha_integrateWithVC() {
   vc_map( array(
      "name" => __( "Ficha Critica", "my-text-domain" ),
      "base" => "ficha_critica",
      "class" => 'wpb_vc_wp_widget',
      "weight" => - 50,
      "category" => __( "Content", "my-text-domain")    
	)    
);
}
