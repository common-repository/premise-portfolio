<?php
/**
 * Plugin Name: Premise Portfolio
 * Description: Display a modern and minimalistic portfolio on your site. This is the official portfolio plugin used across http://premisewp.com to display the themes and plugins that we build. The main idea of this plugin is to offer an easy solution that looks beautiful out of the box, but that also allows you to fully customize the look and behaviour of your portfolio.
 * Plugin URI:  https://plugins.premisewp.com/wordpress-portfolio-plugin
 * Version:     1.2.3
 * Author:      Premise WP <info@premisewp.com> by: Mario Vallejo
 * Author URI:  http://premisewp.com
 * License:     GPL
 *
 * @prefix PWPP - Premise WP Portfolio
 *
 * @package premise-portfolio
 */

// Block direct access to this file.
defined( 'ABSPATH' ) or die();

/**
 * Define plugin path
 */
define( 'PWPP_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Define plugin url
 */
define( 'PWPP_URL', plugin_dir_url( __FILE__ ) );

// Instantiate our main class and setup plugin
// Must use 'plugins_loaded' hook.
add_action( 'plugins_loaded', array( Premise_Portfolio::get_instance(), 'init' ) );

// Install Plugin
register_activation_hook( __FILE__, array( 'Premise_Portfolio', 'do_install' ) );

// Uninstall Plugin.
register_uninstall_hook( __FILE__, array( 'Premise_Portfolio', 'do_uninstall' ) );

/**
 * Load Plugin!
 *
 * This is plugin main class.
 */
class Premise_Portfolio {

	/**
	 * Plugin instance.
	 *
	 * @see get_instance()
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Constructor. Intentionally left empty and public.
	 *
	 * @see 	init()
	 * @since 	1.0
	 */
	public function __construct() {}

	/**
	 * Access this plugin’s working instance
	 *
	 * @since   1.0
	 * @return  object instance of this class
	 */
	public static function get_instance() {
		null === self::$instance and self::$instance = new self;

		return self::$instance;
	}

	/**
	 * Setup Premise
	 *
	 * Does includes and registers hooks.
	 *
	 * @since   1.0
	 */
	public function init() {
		$this->do_includes();
		$this->do_hooks();
	}

	/**
	 * Includes
	 *
	 * @since 1.0
	 */
	protected function do_includes() {

		// Require Premise WP.
		if ( ! class_exists( 'Premise_WP' ) ) {

			// Require Premise WP plugin with the help of TGM Plugin Activation.
			require_once PWPP_PATH . 'lib/class-tgm-plugin-activation.php';

			add_action( 'tgmpa_register', array( $this, 'require_premise' ) );

			return;
		}

		require_once 'classes/class-options-page.php';

		require_once 'classes/class-portfolio-cpt.php';

		require_once 'classes/class-shortcode.php';

		require_once 'lib/functions.php';

	}

	/**
	 * Premise Hooks
	 *
	 * Registers and enqueues scripts, adds classes to the body of DOM
	 */
	public function do_hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts_n_styles' ) );
		// register our shortcode
		add_shortcode( 'pwp_portfolio', array( PWPP_Shortcode::get_instance(), 'init' ) );
		// Add rewrite flush rules on init with a higher priority than 10.
		add_action( 'init', array( $this, 'maybe_flush_rules' ), 11 );
		// portfolio CPT related hooks
		if ( class_exists( 'PWPP_Portfolio_CPT' ) ) {
			// Initiate and register our custom post type
			$portfolio_cpt = PWPP_Portfolio_CPT::get_instance();
			// filter the content for each portfolio item
			add_filter( 'the_content', array( 'PWPP_Portfolio_CPT', 'portfolio_content_filter' ), 99 );
			// filter the excerpt
			add_filter( 'excerpt_length', array( 'PWPP_Portfolio_CPT', 'portfolio_excerpt_trim' ) );
		}
	}

	/**
	 * Flush rewrite rules if our plugin was just activated.
	 */
	public function maybe_flush_rules() {
		// If this option exists we just activated the plugin,
		// And if Premise-WP plugin activated too, flush rewrite rules.
		if ( get_option( '_pwpp_activation_happened' )
			&& class_exists( 'PremiseCPT' ) ) {

			flush_rewrite_rules();

			// Delete the option so we dont flush rules again.
			delete_option( '_pwpp_activation_happened' );
		}
	}

	/**
	 * Install
	 *
	 * @param boolean $networkwide Network wide?.
	 */
	static function do_install( $networkwide ) {

		// Save an option in the DB when this plugin gets installed to flush rewrite rules on init.
		if ( ! get_option( '_pwpp_activation_happened' ) ) {

			add_option( '_pwpp_activation_happened', true );
		}
	}

	/**
	 * Uninstall
	 *
	 * @param boolean $networkwide Network wide?.
	 */
	static function do_uninstall( $networkwide ) {

		// Remove rewrite rules check from DB.
		delete_option( '_pwpp_activation_happened' );

		// Flush rewrite rules.
		// https://codex.wordpress.org/Function_Reference/flush_rewrite_rules
		flush_rewrite_rules();
	}

	/**
	 * Require Premise WP if the class Premise_WP does not exist.
	 *
	 * @wp_hook tgmpa_register
	 * @see  do_includes()
	 *
	 * @return void does not return anything
	 */
	public function require_premise() {

		$plugins = array(
			array(
				'name'               => 'Premise WP',
				'slug'               => 'Premise-WP',
				'source'             => 'https://github.com/PremiseWP/Premise-WP/archive/master.zip',
				'required'           => true,
				'version'            => '2.0.2',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
				'is_callable'        => '',
			),
		);

		$config = array(
			'id'           => 'pwpp-portfolio',
			'default_path' => '',
			'menu'         => 'pwpp-portfolio-install-plugins',
			'parent_slug'  => 'themes.php',
			'capability'   => 'edit_theme_options',
			'has_notices'  => true,
			'dismissable'  => true,
			'dismiss_msg'  => '',
			'is_automatic' => false,
			'message'      => '',
		);

		tgmpa( $plugins, $config );

	}

	/**
	 * output the scripts and styles for the portfolio
	 *
	 * @return void does not return anything. enqueues files
	 */
	public function scripts_n_styles() {
		wp_register_style( 'pwpp_css', PWPP_URL . '/css/style.min.css' );
		wp_register_script( 'pwpp_js', PWPP_URL . '/js/script.min.js' );

		if ( ! is_admin() ) {
			wp_enqueue_style( 'pwpp_css' );
			wp_enqueue_script( 'pwpp_js' );
		}
	}
}