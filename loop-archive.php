<header class="archive-block-header home-block-header archive-title cf">
	<?php sds_archive_title(); ?>
</header>
<?php
	// Loop through posts
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
?>
	<?php tha_entry_before(); ?>
	<section id="post-<?php the_ID(); ?>" <?php post_class( ( has_post_thumbnail() ) ? 'post post-block has-post-thumbnail news-block cf' : 'post post-block no-post-thumbnail news-block cf' ); ?>>
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
						the_time( 'F j, Y' );
					else: // No title
				?>
					<a href="<?php the_permalink(); ?>"><?php the_time( 'F j, Y' ); ?></a>
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
	else:
?>
	<section class="no-posts no-archive-results latest-post">
		<?php sds_no_posts(); ?>
	</section>
<?php
	endif;
?>