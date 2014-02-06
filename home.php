<?php
/*
 * This template is used for the display of blog posts (archive; river).
 */

get_header(); ?>
	<?php get_template_part( 'yoast', 'breadcrumbs' ); // Yoast Breadcrumbs ?>

	<?php
		// Front page is blogroll
		if ( get_option( 'show_on_front' ) === 'page' && ! get_option( 'page_on_front' ) )
			sds_front_page_slider_sidebar(); // Front Page Slider Sidebar
	?>
	<section class="inner-content cf">
		<?php tha_content_before(); ?>
		<section class="inner-block blog-archive content-wrapper cf">
			<?php tha_content_top(); ?>

			<?php
				get_template_part( 'loop', 'home' ); // Loop - Home
				get_template_part( 'post', 'navigation' ); // Post Navigation
			?>

			<?php tha_content_bottom(); ?>
		</section>
		<?php tha_content_after(); ?>

		<?php get_sidebar(); ?>
	</section>

<?php get_footer(); ?>
