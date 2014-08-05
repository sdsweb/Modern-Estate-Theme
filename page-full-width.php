<?php
/*
 * Template Name: Full Width
 * This template is used for the display of full width single pages.
 */

get_header(); ?>

	<?php get_template_part( 'yoast', 'breadcrumbs' ); // Yoast Breadcrumbs ?>

	<section class="inner-content blog-post-full-width cf">
		<?php tha_content_before(); ?>
		<section class="content-wrapper cf">
			<?php tha_content_top(); ?>

			<?php get_template_part( 'loop', 'page-full-width' ); // Loop - Full Width ?>

			<section class="clear"></section>

			<?php comments_template(); // Comments ?>
		</section>
		<?php tha_content_after(); ?>
	</section>

<?php get_footer(); ?>