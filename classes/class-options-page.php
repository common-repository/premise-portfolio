<?php
/**
 * Build and display the options page
 *
 * @package premise-portfolio\classes
 */



/**
* This class displays the options page in the backend.
*/
class PWPP_Options_Page {

	/**
	 * Plugin instance.
	 *
	 * @see get_instance()
	 *
	 * @var object
	 */
	protected static $instance = null;




	/**
	 * Plugin url
	 *
	 * @var string
	 */
	public $plugin_url = PWPP_URL;




	/**
	 * Plugin path
	 *
	 * @var strin
	 */
	public $plugin_path = PWPP_PATH;





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
	 * initiate our plugin
	 *
	 * @return void does not return anything
	 */
	public function init() {
		new Premise_Options(
			array(                   // pass the arguments expected by add_menu_page()
				'title'      => 'Premise Portfolio Options Page',
				'menu_title' => 'Portfolio Settings',
				'menu_slug'  => 'premise-portfolio',
				'callback'   => array( $this, 'render_page' )
			),
			'',                      // pass empty fields so nothign displays and we control render via callback
			'pwpp_portfolio',        // pass key for our options to be created in the database (option name)
			'pwpp_portfolio_options' // pass an options group for our option name
		);
	}


	/**
	 * render the content for our options page
	 *
	 * @todo add options for portfolio options page
	 *
	 * @return string the html for the options page
	 */
	public static function render_page() {
		// the loop
		echo '<h2>Project Loop</h2>
		<p>Control how projects from your portfolio are displayed in a loop - such as a category of projects or using a shortcode to insert more than one project.</p><div class="span4">', premise_field_section( array(
			array(
				'type'    => 'select',
				'name'    => 'pwpp_portfolio[loop][cols]',
				'label'   => 'Default number of columns',
				'options' => array(
					'Select an option' => '',
					'1 Column'         => 'span12',
					'2 Columns'        => 'col2',
					'3 Columns'        => 'col3',
					'4 Columns'        => 'col4',
					'5 Columns'        => 'col5',
					'6 Columns'        => 'col6',
				),
			),
			array(
				'type'        => 'text',
				'name'        => 'pwpp_portfolio[loop][excerpt]',
				'label'       => 'Excerpt',
				'tooltip'     => 'Enter word count. If left blank, you can control where the excerpt breaks by inserting the "read more" tags from the Wordpress Editor.',
				'placeholder' => '22',
				'style'       => 'width:60px;',
			),
			// hide content
			array(
				'type'  => 'checkbox',
				'name'  => 'pwpp_portfolio[loop][hide][title]',
				'label' => 'hide the title',
			),
			array(
				'type'  => 'checkbox',
				'name'  => 'pwpp_portfolio[loop][hide][thumbnail]',
				'label' => 'hide the thumbnail',
			),
			array(
				'type'  => 'checkbox',
				'name'  => 'pwpp_portfolio[loop][hide][excerpt]',
				'label' => 'hide the excerpt',
			),
			array(
				'type'  => 'checkbox',
				'name'  => 'pwpp_portfolio[loop][hide][meta]',
				'label' => 'hide meta data',
			),
			array( 'type' => 'submit' ),
		), false ), '</div>';
	}
}

?>
