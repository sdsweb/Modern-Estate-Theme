<?php
	global $multipage;

	// Loop through posts
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
?>
	<?php tha_entry_before(); ?>
	<section id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post cf' ); ?>>
		<?php tha_entry_top(); ?>

		<?php if ( has_post_thumbnail() ) : // Featured Image ?>
			<header class="blog-post-header">
				<?php sds_featured_image( false, 'me-685x300' ); ?>
			</header>
		<?php endif; ?>

		<section class="page-content blog-post-content cf">
			<section class="post-title-wrap page-title-wrap cf <?php echo ( has_post_thumbnail() ) ? 'post-title-wrap-featured-image' : 'post-title-wrap-no-image'; ?>">
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
				<h1 class="title"><?php the_title(); ?></h1>
			</section>

			<?php the_content(); ?>

			<section class="clear"></section>

			<?php edit_post_link( __( 'Edit Post', 'modern-estate' ) ); // Allow logged in users to edit ?>
		</section>

		<section class="clear"></section>

		<?php if ( $multipage ) : ?>
			<section class="single-post-navigation single-post-pagination wp-link-pages cf">
				<?php wp_link_pages(); ?>
			</section>
		<?php endif; ?>

		<footer class="post-footer blog-post-footer">
			<section class="author-avatar author-thumb">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 128 ); ?>
			</section>

			<section class="author-info">
				<p>Posted by <span class="author-name"><?php echo get_the_author_meta( 'display_name' ); ?></span></p>
				<p><?php echo get_the_author_meta( 'description' ); ?></p>
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php _e( 'View more posts from this author', 'modern-estate' ); ?></a>
			</section>

			<section class="clear"></section>
			
			<?php if ( $post->post_type !== 'attachment' ) : // Post Meta Data (tags, categories, etc...) ?>
				<section class="post-meta single-post-meta">
					<?php sds_post_meta(); ?>
				</section>
			<?php endif ?>
		</footer>

		<?php tha_entry_bottom(); ?>
	</section>
	<?php tha_entry_after(); ?>

	<section class="after-posts-widgets <?php echo ( is_active_sidebar( 'after-posts-sidebar' ) ) ? 'after-posts-widgets-active widgets' : 'no-widgets'; ?> cf">
		<?php sds_after_posts_sidebar(); ?>
	</section>

	<?php sds_single_post_navigation(); ?>
<?php
		endwhile;
	endif;
?>