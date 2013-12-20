<?php
/*
 * This template is used for the display of 404 (Not Found) errors.
 */

get_header(); ?>

	<section class="inner-content cf">
		<section class="inner-block cf">
			<header class="archive-block-header home-block-header 404-title">
				<h1 title="404 Error" class="page-title"><?php _e( '404 Error', 'modern-estate' ); ?></h1>
			</header>

			<section class="blog-post 404-error no-posts">
				<section class="blog-post-content">
					<p><?php _e( 'We apologize but something went wrong while trying to find what you were looking for. Please use the navigation below to navigate to your destination.', 'modern-estate' ); ?></p>

					<section id="search-again" class="search-again search-block no-posts no-search-results">
						<p><?php _e( 'Search:', 'modern-estate' ); ?></p>
						<?php echo get_search_form(); ?>
					</section>

					<?php sds_sitemap(); ?>
				</section>
			</section>
		</section>

		<?php get_sidebar(); ?>
	</section>

<?php get_footer(); ?>