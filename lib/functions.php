<?php
/**
 * Global functions library
 *
 * @package premise-portfolio\lib
 */

/**
 * Displays the post thumbnail for the premise protfolio plugin
 *
 * @return string html for featured image in remise prtfolio single post
 */
function pwpp_the_thumbnail( $view = 'post' ) {
	global $post;
	$url   = '';
	$bg    = '';
	$_html = '';

	if ( has_post_thumbnail() ) {
		$url = (string) wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
		$bg = 'background-image: url( ' . esc_url( $url ) . ' );';
	}

	$_html = '<div class="pwpp-post-thumbnail-wrapper premise-aspect-ratio-16-9">
				<div class="pwpp-post-thumbnail" style="' . $bg . '"></div>
			</div>';
	echo $_html;
}



/**
 * outputs the html required for us to use a ligthbox
 *
 * @return string  html necessary for lightbox element
 */
function pwpp_init_lightbox() {
	// Main Wrapper
	$lightbox = '<div id="pwpp-lightbox-wrapper">
		<div id="pwpp-lightbox-inner">
			<div id="pwpp-lightbox-container">
				<i class="fa fa-spin fa-spinner pwpp-loading-icon"></i>
			</div>
		</div>
	</div>';

	echo (string) $lightbox;
}

/**
 * Outputs the classes for the loop grid
 *
 * @param  string $classes additional classes. Optional
 *
 * @return string          classes to display
 */
function pwpp_loop_class( $classes = '' ) {
	$atts = PWPP_Shortcode::get_shortcode_atts();
	echo 'class="' . esc_attr( 'pwp-'.$atts['grid'] . ' force-columns ' . $classes ) . '"';
}

/**
 * Outputs the classes for each portfolio item
 *
 * @param  string $classes additional classes. Optional
 *
 * @return string classes for item in loop
 */
function pwpp_loop_item_class( $classes = '' ) {
	$atts = PWPP_Shortcode::get_shortcode_atts();
	$col = 'col'.$atts['columns'];
	echo 'class="' . esc_attr( $col . ' ' . $atts['class'] . ' ' . $classes ) . '"';
}


/**
 * returns the have posts() function from our query
 *
 * @return boolean checks if there are any posts in our loop
 */
function pwpp_have_posts() {
	return PWPP_Shortcode::have_posts();
}


/**
 * prepares the post within our loop
 *
 * @return void makes global functions and variable available for us.
 */
function pwpp_the_post() {
	return PWPP_Shortcode::the_post();
}


/**
 * return the cta url or false
 *
 * @return mix the url or false
 */
function pwpp_get_cta_url() {
	global $post;
	return premise_get_value( 'premise_portfolio[cta-url]', array( 'context' => 'post', 'id' => $post->ID ) );
}


/**
 * return the cta text or false
 *
 * @return mix the text or false
 */
function pwpp_get_cta_text() {
	global $post;
	return premise_get_value( 'premise_portfolio[cta-text]', array( 'context' => 'post', 'id' => $post->ID ) );
}


/**
 * get the custom fields for a portfolio item. must be called within the loop
 *
 * @return array|boolean array of custom field keys and values ( key => value ). false if nothing is found
 */
function pwpp_get_custom_fields() {
	$_cust_fields = premise_get_value( '', 'post' );

	if( ! $_cust_fields )
		return false;

	$cust_fields = array();
	foreach ( (array) $_cust_fields as $k => $v ) {
		if ( preg_match( '/^_/', $k )
			|| 'premise_portfolio' == $k )
				continue;

		$cust_fields[esc_html( $k )] = esc_html( $v[0] );
	}

	return $_cust_fields ? $cust_fields : false;
}



function pwpp_the_custom_fields( $format = 'dl' ) {

	if ( $cf = premise_get_value( 'pwpp_portfolio[pwp_custom_fields]', 'post' ) ) {

		$list = '<div class="pwpp-custom-fields-container">';

			$list .= ( 'dl' !== $format ) ? '<table>' : '<dl>';
			foreach ( (array) $cf as $k => $v ) {
				$key   = strip_tags( $v['key'], '<a>,<p>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<b>,<strong>,<span>' );
				$value = strip_tags( $v['value'], '<a>,<p>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<b>,<strong>,<span>' );

				$tags = ( 'dl' !== $format ) ? array( 'td', 'td' ) : array( 'dt', 'dd' );

				$list .= ( 'dl' !== $format ) ? '<tr>' : '';

				$list .= '<'.$tags[0].'>'.$key.'</'.$tags[0].'>
				  	<'.$tags[1].'>'.$value.'</'.$tags[1].'>';

				$list .= ( 'dl' !== $format ) ? '</tr>' : '';

			}
			$list .= ( 'dl' !== $format ) ? '</table>' : '</dl>';

		$list .= '</div>';

		echo $list;
	}
}