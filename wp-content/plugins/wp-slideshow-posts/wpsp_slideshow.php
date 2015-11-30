<?php
function wp_slideshow_posts( $item_toggle = null ) {
	$share_items = array();
	$item_title = array(
		"title" => "-display "
	);

	$item_description = array(
		"description" => "-display "
	);

	$item_arrows = array(
		"arrows" => "<div class='slider-arrows'><a href='#' class='slideshow_prev'><div class='color-transparent'></div><span class='wsp-icon-arrow-left'></span></a>
			<a href='#' class='slideshow_next'><div class='color-transparent'></div><span class='wsp-icon-uniE604'></span></a></div>"
	);

	$item_bullets = array(
		"bullets" => "<div class='slideshow_paging'></div>"
	);

if( $item_toggle ) {
	$item_toggle_array = explode( ",", $item_toggle );
	$show_title = $item_toggle_array['0'];
	$show_description = $item_toggle_array['1'];
	$show_arrows = $item_toggle_array['2'];
	$show_bullets = $item_toggle_array['3'];
} else {
	$display_all_items = 1;
}

if( $show_title == 1 || $display_all_items ) {
	array_push( $share_items, $item_title );
}
if( $show_description == 1 || $display_all_items ) {
	array_push( $share_items, $item_description );
}
if( $show_arrows == 1 || $display_all_items ) {
	array_push( $share_items, $item_arrows );
}
if( $show_bullets == 1 || $display_all_items ) {
	array_push( $share_items, $item_bullets );
}

		$sc_options = WPSP_GetOptions(); 
?>

<style type="text/css">
	.ss1_wrapper a.slideshow_prev .color-transparent,
	.ss1_wrapper a.slideshow_prev:hover .color-transparent,
	.ss1_wrapper a.slideshow_next .color-transparent,
	.ss1_wrapper a.slideshow_next:hover .color-transparent,
	.ss1_wrapper .slideshow_paging a .color-transparent,
	.ss1_wrapper .slideshow_box .data .color-transparent {
		background: <?php echo $sc_options['slider_color']; ?>; 
	}
	.ss1_wrapper .slideshow_paging a.activeSlide,
	.ss1_wrapper .slideshow_paging a:hover.activeSlide { 
		color: <?php echo $sc_options['slider_color']; ?>; 
	}
	.wsp-icon-uniE604,
	.wsp-icon-arrow-left,
	.ss1_wrapper .slideshow_paging a,
	.ss1_wrapper .slideshow_paging a:hover,
	.ss1_wrapper .slideshow_box .data a,
	.ss1_wrapper .slideshow_box .data p {
		color: <?php echo $sc_options['text_color']; ?>;
	}
	.ss1_wrapper .slideshow_paging a.activeSlide {
		background: <?php echo $sc_options['text_color']; ?>;
	}
<?php
	if( $sc_options['bullets_slider'] == 1 ) {
?>
		.ss1_wrapper .slideshow_paging {
			font-size:10px;
		}
		.ss1_wrapper .slideshow_paging a { 
			padding:3px 5px;
		}
<?php
	} elseif( $sc_options['bullets_slider'] == 2 ) {
?>
		.ss1_wrapper .slideshow_paging {
			font-size:0px;
		}
		.ss1_wrapper .slideshow_paging a { 
			padding:7px;
		}
<?php
	}
?>
</style>

<?php
		echo'<div class="ss1_wrapper">
			<div class="ss1_entry">';

	if( !empty( $share_items ) ) {
		foreach( $share_items as $share_item ) {
			$share_output .= "{$share_item['arrows']}";
			$share_output .= "{$share_item['bullets']}";
		}
		echo $share_output;
	}

		echo'<div class="slideshow_wrapper">
		<div class="slideshow_box">
		<div class="data"></div>
		</div>
		</div>
			
		<div id="slideshow_1" class="slideshow">';

		if( $sc_options['posts_slider']=='1' ) :

		$my_query = new WP_Query( 'posts_per_page='.$sc_options['number_post'].'' );

	elseif ( $sc_options['posts_slider']=='2' ) :

		$my_query = new WP_Query( 'orderby=comment_count&posts_per_page='.$sc_options['number_post'].'' );

	elseif ( $sc_options['posts_slider']=='3' ) :

		$my_query = new WP_Query( 'category_name='.$sc_options['category_slider'].'&posts_per_page='.$sc_options['number_post'].'' );

	elseif ( $sc_options['posts_slider']=='4' ) :

		$args = array();
		$str = explode(',', $sc_options['posts_id']);
		$args = $str;
		$my_query = new WP_Query( array( 'post_type' => 'post', 'post__in' => $str ) );

	elseif ( $sc_options['posts_slider']=='5' ) :

		$my_query = new WP_Query( 'post_type=page&posts_per_page='.$sc_options['number_post'].'' );

	elseif ( $sc_options['posts_slider']=='6' ) :

		$args = array();
		$str = explode(',', $sc_options['posts_id']);
		$args = $str;
		$my_query = new WP_Query( array( 'post_type' => 'page', 'post__in' => $str ) );

	elseif ( $sc_options['posts_slider']=='7' ) :

		$args = array();
		$str = explode(',', $sc_options['posts_id']);
		$args = $str;
		$my_query = new WP_Query( array( 'post_type' => $str, 'posts_per_page' => $sc_options['number_post'] ) );

	endif;

	while ( $my_query->have_posts() ) : $my_query->the_post();

		echo'<div class="slideshow_item">'; 

	if ( has_post_thumbnail() ) {

		$matches = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );

	$image_img_tag = $matches[0];

	} else {

		global $post;

		preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

		$image_img_tag = $matches[1][0];
	}
		echo '<img src="'.$image_img_tag.'" />

		<div class="data">';

	if( !empty( $share_items ) ) {
		foreach( $share_items as $share_item ) {
			$title_output .= "{$share_item['title']}";
		}
		echo'<h4 class="title'.$title_output.'">';

		echo'<a href="'.get_permalink().'">';

	the_title();

		echo'</a></h4>';
	}

	if( !empty( $share_items ) ) {
		foreach( $share_items as $share_item ) {
			$description_output .= "{$share_item['description']}";
		}
		echo'<div class="description'.$description_output.'"><p>';

		$excerpt = get_the_excerpt();
		echo substr($excerpt,0, $sc_options['number_word']);
			if (strlen($excerpt) > 99){
				echo' ...'; 
			} 

		echo'</p></div>';
	}
		echo'</div></div>';

	endwhile;
	wp_reset_postdata();

		echo'</div></div></div>';
}

?>