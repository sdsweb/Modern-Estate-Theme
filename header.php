<?php tha_html_before(); ?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8"> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html><!--<![endif]-->
	<head>
		<?php tha_head_top(); ?>
		<?php tha_head_bottom(); ?>
		<?php wp_head(); ?>		
	</head>

	<body <?php language_attributes(); ?> <?php body_class(); ?>>
		<?php tha_body_top(); ?>

		<!-- Header	-->
		<?php tha_header_before(); ?>
		<header id="header" class="cf">
			<?php tha_header_top(); ?>
			<div class="in">
				<!-- Social Media Navigation -->
				<nav class="social-media <?php echo ( has_nav_menu( 'top_nav' ) ) ? 'has-top-nav' : false; ?>">
					<?php sds_social_media(); ?>			
				</nav>

				<!-- Top Navigation	-->
				<?php if( has_nav_menu( 'top_nav' ) ) : // Top Navigation Area ?>
					<button class="nav-button"><?php _e( 'Toggle Navigation', 'modern-estate' ); ?></button>
					<nav class="top-nav">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'top_nav',
								'container' => false,
								'menu_class' => 'top-nav topbar-nav secondary-nav menu',
								'menu_id' => 'top-nav',
							) );
						?>
					</nav>
					<section class="clear"></section>
				<?php endif; ?>
			</div>

			<section class="header-middle">
				<div class="in">
					<!-- Logo -->
					<section class="logo-container">
						<?php sds_logo(); ?>
						<?php sds_tagline(); ?>
					</section>

					<!-- Header CTA Block -->
					<?php if ( is_active_sidebar( 'header-call-to-action-sidebar' ) ) : ?>
						<section class="header-cta-container">
							<?php sds_header_call_to_action_sidebar(); // Header CTA Sidebar ?>
						</section>
					<?php endif; ?>
				</div>
			</section>
				<!-- Primary Navigation -->
				<nav class="header-bottom">
					<div class="in">
						<button class="primary-nav-button"><?php _e( 'Navigation', 'modern-estate' ); ?></button>
						<?php
							// Primary Navigation Area
							wp_nav_menu( array(
								'theme_location' => 'primary_nav',
								'container' => false,
								'menu_class' => 'primary-nav menu',
								'menu_id' => 'primary-nav',
								'fallback_cb' => 'sds_primary_menu_fallback'
							) );
						?>
					</div>
				</nav>
				<?php tha_header_bottom(); ?>
		</header>
		<?php tha_header_after(); ?>

		<div class="in">