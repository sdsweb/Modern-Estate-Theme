		</div>

		<!-- Footer -->
		<?php tha_footer_before(); ?>
		<footer id="footer">
			<?php tha_footer_top(); ?>

			<div class="in cf">
				<section class="footer-blocks footer-block-1 <?php echo ( is_active_sidebar( 'footer-left-sidebar' ) ) ? 'widgets' : 'no-widgets'; ?>">
					<?php me_footer_left_sidebar(); // Footer (vertical) ?>
				</section>

				<section class="footer-blocks footer-block-2 <?php echo ( is_active_sidebar( 'footer-sidebar' ) ) ? 'widgets' : 'no-widgets'; ?>">
					<?php sds_footer_sidebar(); // Footer (2 columns) ?>
				</section>

				<section class="clear"></section>

				<section class="copyright-area <?php echo ( is_active_sidebar( 'copyright-area-sidebar' ) ) ? 'widgets' : 'no-widgets'; ?>">
					<?php sds_copyright_area_sidebar(); ?>
				</section>
			</div>

			<section class="copyright">
				<div class="in">
					<?php sds_copyright( 'Modern Estate' ); ?>
				</div>
			</section>

			<?php tha_footer_bottom(); ?>
		</footer>
		<?php tha_footer_after(); ?>

		<?php tha_body_bottom(); ?>
		<?php wp_footer(); ?>
	</body>
</html>