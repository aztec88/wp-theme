<?php
/*
Template Name: Search Page
*/
?>
<?php get_header(); ?>

<?php
//$query         = get_query_var( 's' );
$query    = get_search_query();
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
	's'       => $query,
	'orderby' => 'title',
	'posts_per_page' => 12,
	'paged'          => $paged
);
function html2text( $Document ) {
	$Rules   = array(
		'@<script[^>]*?>.*?</script>@si',
		'@<[\/\!]*?[^<>]*?>@si',
		'@([\r\n])[\s]+@',
		'@&(quot|#34);@i',
		'@&(amp|#38);@i',
		'@&(lt|#60);@i',
		'@&(gt|#62);@i',
		'@&(nbsp|#160);@i',
		'@&(iexcl|#161);@i',
		'@&(cent|#162);@i',
		'@&(pound|#163);@i',
		'@&(copy|#169);@i',
		'@&(reg|#174);@i',
		'@&#(d+);@e'
	);
	$Replace = array(
		'',
		'',
		'',
		'',
		'&',
		'<',
		'>',
		' ',
		chr( 161 ),
		chr( 162 ),
		chr( 163 ),
		chr( 169 ),
		chr( 174 ),
		'chr()'
	);

	return preg_replace( $Rules, $Replace, $Document );
}


function search_excerpt_highlight() {
	$excerpt = get_the_excerpt();
	$keys    = implode( '|', explode( ' ', get_search_query() ) );
	$excerpt = preg_replace( '/(' . $keys . ')/iu', '<strong class="highlight">\0</strong>', strip_tags( $excerpt ) );

	echo '<p>' . $excerpt . '</p>';
}

function link_parent_title($post) {
	$title = [];
	if($post->post_parent) {
		$post = get_post( $post->post_parent );
		if($post) {
			$title[] = get_the_title();
		}
	}
	return $title;
}

function search_title_highlight() {
	global $post;

	$title = [get_the_title()];
	if(in_array($post->post_type, ['products', 'solutions'])) {
		$post = get_post( $post->post_parent );
		if($post) {
			$title = array_merge($title, link_parent_title($post));
		}

	}
	$title = array_reverse($title);
	$title = implode(' > ', $title);
	$keys  = implode( '|', explode( ' ', get_search_query() ) );
	$title = preg_replace( '/(' . $keys . ')/iu', '<strong class="highlight">\0</strong>', strip_tags( $title ) );

	echo $title;
}




$the_query     = new WP_Query( $args ); ?>
<div class="container searchWrapper">
	<div class="query search_title">
		<h1>Search</h1>
		<h3><?php echo __( "Result(s) for: ", 'geoplast' ) . "<span class=\"highlight\">{$query}</span>"; ?><h3>
	</div>
	<?php if ( $the_query->have_posts() ): $shown = []; ?>


		<ul class="results">


			<?php while ( $the_query->have_posts() ): ?>
					<?php $the_query->the_post(); ?>
				<?php $post = $the_query->post; $wp_query = $the_query;?>
					<?php if ( !in_array( $post->ID, $shown ) ): ?>
						<?php $shown[] = $post->ID; ?>
						<?php $post_type = get_post_type_object( get_post_type( $post ) ); ?>
						<li>
							<a href="<?php $link = get_the_permalink(); echo $link; ?>">
								<h3><?php search_title_highlight(); ?> - <span><?php echo $post_type->label; ?></span></h3>
							</a>
							<a href="<?php echo $link; ?>">
								<div class="snippet">
									<?php search_excerpt_highlight(); ?>
								</div>
							</a>
						</li>
					<?php endif; ?>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</ul>
		<div class="page_pagination col-xs-12">
					<?php the_posts_pagination( array(
						'mid_size'  => 2,
						'prev_text' => 'PREVIOUS',
						'next_text' => 'NEXT',
						'screen_reader_text' => 0
					) ); ?>
				</div>
	<?php else: ?>
		<div class="noResults">
			<div class="alert alert-info">
				<p><?php _e( 'No results found for this search.', 'geoplast' ); ?></p>
				<p><?php _e( 'Refine your keywords.', 'geoplast' ); ?></p>
			</div>
		</div>
	<?php endif ?>
</div>
	
<?php get_footer(); ?>
