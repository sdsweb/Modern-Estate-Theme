<?php
	// Loop through posts
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
?>
	<?php tha_entry_before(); ?>
	<section id="post-<?php the_ID(); ?>" <?php post_class( ( has_post_thumbnail() ) ? 'post post-block has-post-thumbnail news-block' : 'post post-block no-post-thumbnail news-block' ); ?>>
		<?php tha_entry_top(); ?>

		<?php if ( has_post_thumbnail() ) : // Featured Image ?>
			<section class="news-thumb">
				<?php sds_featured_image( true ); ?>
			</section>
		<?php endif; ?>
		<section class="news-block-info blog-post-content cf <?php echo ( has_post_thumbnail() ) ? 'news-block-info-featured-image' : 'news-block-info-no-image'; ?>">
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
			<h2 class="block-news-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

			<?php the_excerpt(); ?>
			<p><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="more read-more more-link">Read More</a></p>
		</section>

		<?php tha_entry_bottom(); ?>
	</section>
	<?php tha_entry_after(); ?>
<?php
		endwhile;
	else : // No posts
?>
	<section class="no-results no-posts no-search-results latest-post">
		<?php sds_no_posts(); ?>
	</section>
<?php endif; ?>