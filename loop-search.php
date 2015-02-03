<?php
	if ( have_posts() ) : // Search results
?>
	<header class="archive-block-header home-block-header search-title">
		<h1 title="<?php esc_attr_e( sprintf( __( 'Search results for \'%s\'', 'modern-estate' ), get_search_query() ) ); ?>" class="page-title"><?php printf( __( 'Search results for "%s"', 'modern-estate' ), get_search_query() ); ?></h1>
	</header>

	<?php while ( have_posts() ) : the_post(); ?>
		<?php tha_entry_before(); ?>
		<section id="post-<?php the_ID(); ?>" <?php post_class(  ( has_post_thumbnail() ) ? 'post post-block has-post-thumbnail news-block search-block' : 'post post-block no-post-thumbnail news-block search-block' ); ?>>
			<?php tha_entry_top(); ?>

			<?php if ( has_post_thumbnail() ) : // Featured Image ?>
				<section class="news-thumb">
					<?php sds_featured_image( true ); ?>
				</section>
			<?php endif; ?>

			<section class="news-block-info blog-post-content cf">
				<?php if ( $post->post_type === 'post' ) : ?>
					<p class="home-block-date">
						<?php
							if ( strlen( get_the_title() ) > 0 ) :
								the_time( get_option( 'date_format' ) );
							else: // No title
						?>
							<a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
						<?php
							endif;
						?>
					</p>
				<?php endif; ?>
				<h2 class="block-news-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

				<?php the_excerpt(); ?>
				<p><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="more read-more more-link">Read More</a></p>
			</section>

			<?php tha_entry_bottom(); ?>
		</section>
		<?php tha_entry_after(); ?>
	<?php endwhile; ?>
<?php else : // No search results ?>
	<header class="archive-block-header home-block-header search-title">
		<h1 title="<?php esc_attr_e( sprintf( __( 'Search results for \'%s\'', 'modern-estate' ), get_search_query() ) ); ?>" class="page-title"><?php printf( __( 'Search results for "%s"', 'modern-estate' ), get_search_query() ); ?></h1>
	</header>

	<section class="no-results no-posts no-search-results latest-post">
		<?php sds_no_posts(); ?>

		<section id="search-again" class="search-again search-block no-posts no-search-results">
			<p><?php _e( 'Would you like to search again?', 'modern-estate' ); ?></p>
			<?php echo get_search_form(); ?>
		</section>
	</section>
<?php endif; ?>