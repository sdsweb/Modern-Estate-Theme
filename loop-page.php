<?php
	global $multipage; // Used to determine if the current post has multiple pages

	// Loop through posts
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
?>
	<?php tha_entry_before(); ?>
	<section id="post-<?php the_ID(); ?>" <?php post_class( ( has_post_thumbnail() ) ? 'post post-block has-post-thumbnail blog-post' : 'post post-block no-post-thumbnail blog-post' ); ?>>
		<?php tha_entry_top(); ?>

		<?php if ( has_post_thumbnail() ) : // Featured Image ?>
			<header class="blog-post-header">
				<?php sds_featured_image( false, 'me-685x300' ); ?>
			</header>
		<?php endif; ?>

		<section class="page-content blog-post-content cf">
			<section class="post-title-wrap page-title-wrap cf <?php echo ( has_post_thumbnail() ) ? 'post-title-wrap-featured-image' : 'post-title-wrap-no-image'; ?>">
				<h1 class="title"><?php the_title(); ?></h1>
			</section>

			<?php the_content(); ?>

			<section class="clear"></section>

			<?php edit_post_link( __( 'Edit Page', 'modern-estate' ) ); // Allow logged in users to edit ?>

			<?php if ( $multipage ) : ?>
				<section class="single-post-navigation single-post-pagination wp-link-pages">
					<?php wp_link_pages(); ?>
				</section>
			<?php endif; ?>
		</section>

		<?php tha_entry_bottom(); ?>
	</section>
	<?php tha_entry_after(); ?>
<?php
		endwhile;
	endif;
?>