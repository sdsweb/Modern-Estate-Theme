<?php
/*
 * This template is used for the display of archives.
 */

get_header(); ?>

	<?php get_template_part( 'yoast', 'breadcrumbs' ); // Yoast Breadcrumbs ?>

	<section class="inner-content">
		<?php tha_content_before(); ?>
		<section class="inner-block cf">
			<?php tha_content_top(); ?>

			<?php
				get_template_part( 'loop', 'archive' ); // Loop - Archive
				get_template_part( 'post', 'navigation' ); // Post Navigation
			?>

			<?php tha_content_bottom(); ?>
		</section>
		<?php tha_content_after(); ?>

		<?php get_sidebar(); ?>
	</section>

<?php get_footer(); ?>
