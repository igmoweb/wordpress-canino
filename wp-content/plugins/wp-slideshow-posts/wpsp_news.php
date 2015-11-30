<?php 
function WPSP_breakingnews() {
	global $wpdb, $post;
	$sc_options = WPSP_GetOptions(); 
?>

<style type="text/css">
#ticker-wrapper h3,
#ticker-wrapper #random-article a {
background-color: <?php echo $sc_options['slider_color']; ?>;
}
#ticker-wrapper h3,
.wsp-icon-shuffle {
color: <?php echo $sc_options['text_color']; ?>;
}
#s7, #s7 a {
color: <?php echo $sc_options['link_color']; ?>;
}
</style>

<?php
		if( $sc_options['get_braeking']=='true' ) : 
			echo '<div id="ticker-wrapper">
<h3 class="ticker-header">';
			echo "<span class='wsp-icon-pushpin'></span>";
			echo "Breaking news";
			echo '</h3><div id="s7">';

		if( $sc_options['posts_news']=='1' ) :

		$my_query = new WP_Query( 'posts_per_page='.$sc_options['number_news'].'' );

		elseif ( $sc_options['posts_news']=='2' ) :

		$my_query = new WP_Query( 'orderby=comment_count&posts_per_page='.$sc_options['number_news'].'' );

		elseif ( $sc_options['posts_news']=='3' ) :

		$my_query = new WP_Query( 				'category_name='.$sc_options['category_news'].'&posts_per_page='.$sc_options['id_news'].'' );

		elseif ( $sc_options['posts_news']=='4' ) :

		$args = array();
		$str = explode(',', $sc_options['id_news']);
		$args = $str;
		$my_query = new WP_Query( array( 'post_type' => 'post', 'post__in' => $str ) );

		elseif ( $sc_options['posts_news']=='5' ) :

		$my_query = new WP_Query( 'post_type=page&posts_per_page='.$sc_options['number_news'].'' );

		elseif ( $sc_options['posts_news']=='6' ) :

		$args = array();
		$str = explode(',', $sc_options['id_news']);
		$args = $str;
		$my_query = new WP_Query( array( 'post_type' => 'page', 'post__in' => $str ) );

		elseif ( $sc_options['posts_news']=='7' ) :

		$args = array();
		$str = explode(',', $sc_options['id_news']);
		$args = $str;
		$my_query = new WP_Query( array( 'post_type' => $str, 'posts_per_page' => $sc_options['number_news'] ) );

		endif;

	while ( $my_query->have_posts() ) : $my_query->the_post();
			echo '<div id="entry-s7">';
		if( $sc_options['posts_news'] !=='3' && $sc_options['posts_news'] !=='5' && $sc_options['posts_news'] !=='6' ) :
			echo '<span class="wsp-icon-folder-open"></span>';


	$category = get_the_category();
	if ($category) {
  		echo '<a class="ticker-cat" href="' . get_category_link( $category[0]->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a> ';

	}
			echo ' &rarr; ';
		endif;
			echo '<a href="' . get_permalink() . '" rel="bookmark">';
			the_title();
			echo '</a></div>';

	endwhile; 
	wp_reset_postdata();

			echo '</div>';
			echo '<div id="random-article">';
	$randomPost = $wpdb->get_var( "SELECT guid FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' ORDER BY rand() LIMIT 1" );

			echo '<a href="'.$randomPost.'" title1="Random posts">';
			echo '<span class="wsp-icon-shuffle"></span>';
			echo '</a></div></div>';
		endif;
}
?>