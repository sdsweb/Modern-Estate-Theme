<?php
/*
 * This class manages all functionality with our Modern Estate theme.
 */
class ModernEstate {
	const ME_VERSION = '1.1.9';

	private static $instance; // Keep track of the instance

	/*
	 * Function used to create instance of class.
	 * This is used to prevent over-writing of a variable (old method), i.e. $me = new ModernEstate();
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) )
			self::$instance = new ModernEstate;

		return self::$instance;
	}



	/**
	 * This function sets up all of the actions and filters on instance
	 */
	function __construct() {
		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ), 20 ); // Enable Featured Images, Specify additional image sizes
		add_action( 'widgets_init', array( $this, 'widgets_init' ) ); // Register sidebars
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) ); // Add Meta Boxes
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) ); // Enqueue all stylesheets (Main Stylesheet, Fonts, etc...)
		add_action( 'wp_footer', array( $this, 'wp_footer' ) ); // Responsive navigation functionality

		// TGM Plugin Activation
		add_action( 'sds_tgmpa_plugins', array( $this, 'sds_tgmpa_plugins' ) );

		// Theme Customizer
		add_action( 'customize_register', array( $this, 'customize_register' ), 20 ); // Switch background properties to use refresh transport method
		add_action( 'customize_controls_print_styles', array( $this, 'customize_controls_print_styles' ), 20 ); // Customizer Styles
		add_filter( 'theme_mod_content_color', array( $this, 'theme_mod_content_color' ) ); // Set the default content color

		// Gravity Forms
		add_filter( 'gform_field_input', array( $this, 'gform_field_input' ), 10, 5 ); // Add placholder to newsletter form
		add_filter( 'gform_confirmation', array( $this, 'gform_confirmation' ), 10, 4 ); // Change confirmation message on newsletter form
	}


	/************************************************************************************
	 *    Functions to correspond with actions above (attempting to keep same order)    *
	 ************************************************************************************/

	/*
	 * This function specifies additional image sizes.
	 */
	function after_setup_theme() {
		global $content_width;

		/**
		 * Set the Content Width for embeded items.
		 */
		if ( ! isset( $content_width ) )
			$content_width = 685;

		// Theme Hook Alliance support
		add_theme_support( 'tha_hooks', array( 'all' ) );

		add_image_size( 'me-200x300', 200, 300, true ); // Used on the front page, blog page, and archive page
		add_image_size( 'me-685x300', 685, 300, true ); // Used on single posts and pages
		add_image_size( 'me-1022x300', 1022, 300, true ); // Used on full width and landing page templates

		// Remove footer nav which is registered in options panel
		unregister_nav_menu( 'footer_nav' );

		// Change default core markup for search form, comment form, and comments, etc... to HTML5
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list'
		) );

		// Custom Background (color/image)
		$custom_background_args = array();

		// Check for color scheme default value
		if ( ( $selected_color_scheme = sds_get_color_scheme( false ) ) && isset( $selected_color_scheme['background_color'] ) )
			$custom_background_args['default-color'] = $selected_color_scheme['background_color'];

		add_theme_support( 'custom-background', $custom_background_args );

		// Theme textdomain
		load_theme_textdomain( 'modern-estate', get_template_directory() . '/languages' );
	}

	/*
	 * This function registers extra sidebars used in this theme.
	 *
	 * Uses functionality similar to register_sidebar() to "insert" sidebars into correct order or registered sidebars.
	 */
	function widgets_init() {
		global $wp_registered_sidebars;

		// Remove secondary sidebar registered in options panel
		unregister_sidebar( 'secondary-sidebar' );

		// Footer Left (insert after 'after-posts-sidebar')
		$footer_left_sidebar = array(
			'name'          => __( 'Footer Left', 'modern-estate' ),
			'id'            => 'footer-left-sidebar',
			'description'   => __( 'This widget area is displayed to the left of the Footer sidebar in the footer of all pages.', 'modern-estate' ),
			'class'         => '',
			'before_widget' => '<section id="footer-left-widget-%1$s" class="widget footer-left-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widgettitle widget-title footer-left-widget-title">',
			'after_title'   => '</h3>'
		);

		$wp_registered_sidebars = $this->array_insert_after( $wp_registered_sidebars, 'after-posts-sidebar', 'footer-left-sidebar', $footer_left_sidebar );
		do_action( 'register_sidebar', $footer_left_sidebar );
	}

	/**
	 * This function runs when meta boxes are added.
	 */
	function add_meta_boxes() {
		// Post types
		$post_types = get_post_types(
			array(
				'public' => true,
				'_builtin' => false
			)
		);
		$post_types[] = 'post';
		$post_types[] = 'page';

		// Add the metabox for each type
		foreach ( $post_types as $type ) {
			add_meta_box(
				'modern-estate-us-metabox',
				__( 'Layout Settings', 'modern-estate' ),
				array( $this, 'modern_estate_us_metabox' ),
				$type,
				'side',
				'default'
			);
		}
	}

	/**
	 * This function renders a metabox.
	 */
	function modern_estate_us_metabox( $post ) {
		// Get the post type label
		$post_type = get_post_type_object( $post->post_type );
		$label = ( isset( $post_type->labels->singular_name ) ) ? $post_type->labels->singular_name : __( 'Post' );

		echo '<p class="howto">';
		printf(
			__( 'Looking to configure a unique layout for this %1$s? %2$s.', 'modern-estate' ),
			esc_html( strtolower( $label ) ),
			sprintf(
				'<a href="%1$s" target="_blank">Upgrade to Pro</a>',
				esc_url( sds_get_pro_link( 'metabox-layout-settings' ) )
			)
		);
		echo '</p>';
	}

	/*
	 * This function enqueues all styles and scripts (Main Stylesheet, Fonts, etc...). Stylesheets can be conditionally included if needed
	 */
	function wp_enqueue_scripts() {
		global $sds_theme_options;

		$protocol = is_ssl() ? 'https' : 'http'; // Determine current protocol

		// Modern Estate (main stylesheet)
		wp_enqueue_style( 'modern-estate', get_template_directory_uri() . '/style.css', false, self::ME_VERSION );

		// Enqueue the child theme stylesheet only if a child theme is active
		if ( is_child_theme() )
			wp_enqueue_style( 'modern-estate-child', get_stylesheet_uri(), array( 'modern-estate' ), self::ME_VERSION );

		// IE Stylesheet (conditional)
		wp_enqueue_style( 'modern-estate-ie', get_template_directory_uri() . '/css/ie.css', false, self::ME_VERSION );
		$GLOBALS['wp_styles']->add_data( 'modern-estate-ie', 'conditional', 'lte IE 9' );

		// Open Sans/Oswald (include only if a web font is not selected in Theme Options)
		if ( ! function_exists( 'sds_web_fonts' ) || empty( $sds_theme_options['web_font'] ) )
			wp_enqueue_style( 'open-sans-oswald-web-fonts', $protocol . '://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700|Oswald:400,300', false, self::ME_VERSION ); // Google WebFonts (Open Sans & Oswald)

		// Ensure jQuery is loaded on the front end for our footer script (@see wp_footer() below)
		wp_enqueue_script( 'jquery' );
	}

	/**
	 * This function outputs the necessary javascript for the responsive menus.
	 */
	function wp_footer() {
	?>
		<script type="text/javascript">
			// <![CDATA[
				jQuery( function( $ ) {
					// Top Nav
					$( '.nav-button' ).on( 'click', function ( e ) {
						e.stopPropagation();
						$( '.nav-button, .top-nav' ).toggleClass( 'open' );
					} );

					// Primary Nav
					$( '.primary-nav-button' ).on( 'click', function ( e ) {
						e.stopPropagation();
						$( '.primary-nav-button, .primary-nav' ).toggleClass( 'open' );
					} );

					$( document ).on( 'click touch', function() {
						$( '.nav-button, .top-nav, .primary-nav-button, .primary-nav' ).removeClass( 'open' );
						
					} );
				} );
			// ]]>
		</script>
	<?php
	}

	/********************
	 * Theme Customizer *
	 ********************/

	/**
	 * This function is run when the Theme Customizer is loaded.
	 */
	function customize_register( $wp_customize ) {
		$wp_customize->add_section( 'modern_estate_us', array(
			'title' => __( 'Upgrade Modern Estate', 'modern-estate' ),
			'priority' => 1
		) );

		$wp_customize->add_setting(
			'modern_estate_us', // IDs can have nested array keys
			array(
				'default' => false,
				'type' => 'modern_estate_us'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_US_Control(
				$wp_customize,
				'modern_estate_us',
				array(
					'content'  => sprintf(
						__( '<strong>Premium support</strong>, more Customizer options, color schemes, web fonts, and more! %s.', 'modern-estate' ),
						sprintf(
							'<a href="%1$s" target="_blank">%2$s</a>',
							esc_url( sds_get_pro_link( 'customizer' ) ),
							__( 'Upgrade to Pro', 'modern-estate' )
						)
					),
					'section' => 'modern_estate_us',
				)
			)
		);

		$wp_customize->get_section( 'colors' )->description = sprintf(
			__( 'Looking for more color customizations? %s.', 'modern-estate' ),
			sprintf(
				'<a href="%1$s" target="_blank">%2$s</a>',
				esc_url( sds_get_pro_link( 'customizer-colors' ) ),
				__( 'Upgrade to Pro', 'modern-estate' )
			)
		);
	}

	/**
	 * This function is run when the Theme Customizer is printing styles.
	 */
	function customize_controls_print_styles() {
	?>
		<style type="text/css">
			#accordion-section-modern_estate_us .accordion-section-title,
			#customize-theme-controls #accordion-section-modern_estate_us .accordion-section-title:focus,
			#customize-theme-controls #accordion-section-modern_estate_us .accordion-section-title:hover,
			#customize-theme-controls #accordion-section-modern_estate_us .control-section.open .accordion-section-title,
			#customize-theme-controls #accordion-section-modern_estate_us:hover .accordion-section-title,
			#accordion-section-modern_estate_us .accordion-section-title:active {
				background: #444;
				color: #fff;
			}

			#accordion-section-modern_estate_us .accordion-section-title:after,
			#customize-theme-controls #accordion-section-modern_estate_us .accordion-section-title:focus::after,
			#customize-theme-controls #accordion-section-modern_estate_us .accordion-section-title:hover::after,
			#customize-theme-controls #accordion-section-modern_estate_us.open .accordion-section-title::after,
			#customize-theme-controls #accordion-section-modern_estate_us:hover .accordion-section-title::after {
				color: #fff;
			}
		</style>
	<?php
	}

	/**
	 * This function sets the default color for the content area in the Theme Customizer.
	 */
	function theme_mod_content_color( $color ) {
		// Return the current color if set
		if ( $color )
			return $color;

		// Return the selected color scheme content color if set
		if ( $selected_color_scheme = sds_get_color_scheme() )
			return $selected_color_scheme['content_color'];

		// Load all color schemes for this theme
		$color_schemes = sds_color_schemes();

		// Return the default color scheme content color
		return $color_schemes['default']['content_color'];
	}

	/**
	 * Internal Functions (functions used internally throughout this class)
	 */

	/**
	 * This function inserts a value into an array after a specified key.
	 *
	 * @param $array The array to insert values into (passed as a reference).
	 * @param $key The key to search for.
	 * @param $new_key The new key name to insert.
	 * @param $new_value The new value to insert.
	 */
	public static function array_insert_after( array &$array, $key, $new_key, $new_value) {
		// Check to see if the array key exists in the current array
		if ( array_key_exists( $key, $array ) ) {
			$new = array();

			foreach ( $array as $k => $v ) {
				$new[$k] = $v;
				if ( $k === $key )
					$new[$new_key] = $new_value;
			}

			return $new;
		}

		// No key found, return the original array
		return $array;
	}


	/*************************
	 * TGM Plugin Activation *
	 *************************/

	/**
	 * This function ties into the TGM Plugin Activation Class and recommends plugins to the user.
	 */
	function sds_tgmpa_plugins( $plugins ) {
		// Easy Real Estate
		$plugins[] = array(
			'name' => 'Easy Real Estate',
			'slug' => 'easy-real-rstate-plugin-master',
			'source' => 'https://github.com/sdsweb/easy-real-rstate-plugin/archive/master.zip',
			'required' => false,
			'force_activation' => false,
			'force_deactivation' => false,
			'external_url' => 'https://github.com/sdsweb/easy-real-rstate-plugin/'
		);

		return $plugins;
	}


	/*****************
	 * Gravity Forms *
	 *****************/

	/**
	 * This function adds the HTML5 placeholder attribute to forms with a CSS class of the following:
	 * .mc-gravity, .mc_gravity, .mc-newsletter, .mc_newsletter classes
	 */
	function gform_field_input( $input, $field, $value, $lead_id, $form_id ) {
		$form_meta = RGFormsModel::get_form_meta( $form_id );

		// Ensure the current form has one of our supported classes and alter the field accordingly if we're not on admin
		if ( isset( $form['cssClass'] ) && ! is_admin() && in_array( $form_meta['cssClass'], array( 'mc-gravity', 'mc_gravity', 'mc-newsletter', 'mc_newsletter' ) ) )
			$input = '<div class="ginput_container"><input name="input_' . $field['id'] . '" id="input_' . $form_id . '_' . $field['id'] . '" type="text" value="" class="large" placeholder="' . $field['label'] . '" /></div>';

		return $input;
	}

	/**
	 * This function alters the confirmation message on forms with a CSS class of the following:
	 * .mc-gravity, .mc_gravity, .mc-newsletter, .mc_newsletter classes
	 */
	function gform_confirmation( $confirmation, $form, $lead, $ajax ) {
		// Confirmation message is set and form has one of our supported classes (alter the confirmation accordingly)
		if ( isset( $form['cssClass'] ) && $form['confirmation']['type'] === 'message' && in_array( $form['cssClass'], array( 'mc-gravity', 'mc_gravity', 'mc-newsletter', 'mc_newsletter' ) ) )
			$confirmation = '<section class="mc-gravity-confirmation mc_gravity-confirmation mc-newsletter-confirmation mc_newsletter-confirmation">' . $confirmation . '</section>';

		return $confirmation;
	}
}


function ModernEstateInstance() {
	return ModernEstate::instance();
}

// Starts ModernEstate
ModernEstateInstance();