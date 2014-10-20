<!-- Page Sidebar-->
<?php tha_sidebars_before(); ?>
<aside id="sidebar" class="sidebar <?php echo ( is_active_sidebar( 'primary-sidebar' ) ) ? 'widgets' : 'no-widgets'; ?>">
	<?php tha_sidebar_top(); ?>

	<?php
		// Primary Sidebar
		if ( is_active_sidebar( 'primary-sidebar' ) )
			sds_primary_sidebar();
		// Social Media Fallback
		else
			sds_social_media();
	?>

	<?php tha_sidebar_bottom(); ?>
</aside>
<?php tha_sidebars_after(); ?>