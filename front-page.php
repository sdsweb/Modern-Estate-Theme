<?php
/*
 * This template is used for displaying the Front Page (when selected in Settings > Reading).
 *
 * This template is used even when the option is selected, but a page is not. It contains fallback functionality
 * to ensure content is still displayed.
 */

get_header(); ?>
	<?php
		// Front page is active
		if ( get_option( 'show_on_front' ) === 'page' && get_option( 'page_on_front' ) ) :
			sds_front_page_slider_sidebar(); // Front Page Slider Sidebar
	?>
		<section class="home-content inner-content front-page-content front-page cf">
			<section class="<?php echo ( ! is_active_sidebar( 'front-page-sidebar' ) ) ? 'inner-block': false; ?> cf">
				<?php if ( is_active_sidebar( 'front-page-sidebar' ) ) : // Front Page Sidebar ?>
					<section id="front-page-sidebar" class="front-page-sidebar">
						<?php dynamic_sidebar( 'front-page-sidebar' ); ?>
					</section>
				<?php else: ?>
					<?php get_template_part( 'loop', 'page' ); // Loop - Page ?>
				<?php endif; ?>
			</section>
	<?php
		// No "Front Page" Selected, show posts
		else:
	?>
		<section class="home-content inner-content front-page-content front-page cf">
			<section class="inner-block cf">
				<?php
					get_template_part( 'loop', 'home' ); // Loop - Home
					get_template_part( 'post', 'navigation' ); // Post Navigation
				?>
			</section>
	<?php
		endif;

		// Front page and front page sidebar are not active
		if ( ( get_option( 'show_on_front' ) !== 'page' || ! get_option( 'page_on_front' ) ) || ! is_active_sidebar( 'front-page-sidebar' ) )
			get_sidebar(); 
	?>
	</section>

<?php get_footer(); ?>
