/**
 * JS for premise protfolio
 */
( function( $ ) {

	$( document ).ready( function() {

		var pwppLoopHoverAnimation = $ ( '.pwpp-loop-hover-animation' );

		( pwppLoopHoverAnimation.length ) ? pwppLoopAnimateOnHover() : false;


		function pwppLoopAnimateOnHover() {
			var tfgOriginalbackground = '';
			pwppLoopHoverAnimation.mouseenter( function() {
				var hover = $(this).attr( 'data-hover-state' );

				tfgOriginalbackground = $(this).find( '.pwpp-post-thumbnail' ).attr( 'style' );

				console.log( tfgOriginalbackground );

				if ( '' !== hover ) {
					if ( hover.match( '#' ) ) {
						$(this).find( '.pwpp-post-thumbnail' ).css({
							'background-image': '',
							'background-color': hover,
						} );
					}
					else {
						$(this).find( '.pwpp-post-thumbnail' ).css({
							'background-image': 'url('+hover+')',
							'background-color': '',
						} );
					}
				}
			} );

			pwppLoopHoverAnimation.mouseleave( function() {
				var hover = tfgOriginalbackground;

				if ( '' !== tfgOriginalbackground ) {
					if ( tfgOriginalbackground.match( 'background-image' ) ) {
						hover = tfgOriginalbackground.trim().substring( tfgOriginalbackground.indexOf( '(' ) + 1, tfgOriginalbackground.length -2 );
						$(this).find( '.pwpp-post-thumbnail' ).css({
							'background-image': 'url('+hover+')',
							'background-color': '',
						} );
						console.log( hover );
					}
					else {
					}
				}
			} );
		}
	} );

} ( jQuery ) );