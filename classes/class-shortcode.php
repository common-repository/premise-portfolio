<?php
/**
 * Create and handle our shortcde to display portfolio items.
 *
 * @package premise-portfolio\classes
 */

/**
 * This class handles our shortcode. It displays and registers the shortcode.
 */
class PWPP_Shortcode {

	/**
	 * Plugin instance.
	 *
	 * @see get_instance()
	 *
	 * @var object
	 */
	protected static $instance = null;


	/**
	 * Holds the shortcode params for public use. This is useful for templating.
	 *
	 * @var array
	 */
	public static $params = array();


	/**
	 * The shortcode defaults
	 *
	 * Defaults can be change via a filter pwp_portfolio_sc_defaults
	 *
	 * @var array
	 */
	public $defaults = array(
		'grid'    => 'row',
		'columns' => '4',
		'class'   => '',
		'cat'     => '',
	);


	protected  static $query_args = array(
		'post_type' => 'premise_portfolio',
		'posts_per_page' => -1,
	);


	/**
	 * Save the wp query
	 *
	 * @var null
	 */
	protected static $query = null;


	/**
	 * begin with a default template.
	 *
	 * @var string
	 */
	public $loop_tmpl = PWPP_PATH . '/view/loop-premise-portfolio.php';



	/**
	 * creates our custom post type. The custom post type class neeeds to be initiated on init. so we run it here.
	 *
	 * @see 	init()
	 * @since 	1.0.0
	 */
	public function __construct() {

		/**
		 * pwp_portfolio_sc_defaults filter allows you to change the default settings for the shortcode.
		 *
		 * @see https://developer.wordpress.org/reference/functions/add_filter/ for info on how to use filters
		 *
		 * @var array
		 */
		$this->defaults = apply_filters( 'pwp_portfolio_sc_defaults', $this->defaults );

		self::$query_args = array(
			'post_type' => 'premise_portfolio',
			'posts_per_page' => -1,
		);
	}



	/**
	 * Access this plugin’s working instance
	 *
	 * @since   1.0.0
	 * @return  object instance of this class
	 */
	public static function get_instance() {
		null === self::$instance and self::$instance = new self;

		return self::$instance;
	}



	/**
	 * initiate our plugin and registers the necessary hooks for our custom post type to work properly
	 *
	 * @return void does not return anything
	 */
	public function init( $atts ) {
		// get these params and sve them in our object for public use.
		self::$params = shortcode_atts( $this->defaults, $atts, 'pwp_portfolio' );

		// normalize columns param
		self::$params['columns'] =  (string) ( 6 >= (int) self::$params['columns']
									&& 2 <= (int) self::$params['columns'] )
									? self::$params['columns']
									: self::$params['columns'];

		// normalize categories
		if ( isset( self::$params['cat'] )
			 && ! empty( self::$params['cat'] ) ) {

			self::$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'premise-portfolio-category',
					'field'    => ( preg_match( '/[^0-9,]/', self::$params['cat'] ) ) ? 'slug'                    : 'term_id',
					'terms'    => ( preg_match( '/,/', self::$params['cat'] ) )       ? explode( ',', self::$params['cat'] ) : self::$params['cat'],
				),
			);
		}

		// Allow themes to override the tamplate that gets loaded
		if ( '' !== ( $new_loop_tmpl = locate_template( 'loop-premise-portfolio.php' ) ) ) {
			$this->loop_tmpl = $new_loop_tmpl;
		}

		return $this->do_loop();
	}



	/**
	 * performs the loop. returns the html for the posts grid
	 *
	 * @return string html for posts grid
	 */
	protected function do_loop() {
		$_html = '';

		// get the portfolio items
		self::$query = new WP_query( self::$query_args );

		// Get the template
		ob_start();
			include $this->loop_tmpl;
		$_html = ob_get_clean();

		return (string) $_html;
	}


	/*
		Helpers
	 */


	/**
	 * returns the shortcode grid param. called from our template pwpp_get_shortcode_atts().
	 *
	 * @see pwpp_get_shortcode_atts uses this function. located in lib/functions.php
	 *
	 * @return string column class to set the number of columns 1-6. defaults to 4. returns value already escaped using esc_attr();
	 */
	public static function get_shortcode_atts() {
		return self::$params;
	}


	/**
	 * return the query's have_posts() function
	 *
	 * @return mix return the wp have_posts() function scoped to our query of portfolio items
	 */
	public static function have_posts() {
		return self::$query->have_posts();
	}


	/**
	 * return the query's the_post() function
	 *
	 * @return mix return the wp the_post() function scoped to our query of portfolio items
	 */
	public static function the_post() {
		return self::$query->the_post();
	}
}

?>
