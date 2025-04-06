/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 */

( function( $ ) {
	// Update the site title in real time
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	
	// Update the site description in real time
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	
	// Update hero section in real time
	wp.customize( 'cuevas_hero_title', function( value ) {
		value.bind( function( to ) {
			$( '.hero-title' ).text( to );
		} );
	} );
	
	wp.customize( 'cuevas_hero_subtitle', function( value ) {
		value.bind( function( to ) {
			$( '.hero-subtitle' ).text( to );
		} );
	} );
	
	wp.customize( 'cuevas_hero_button_text', function( value ) {
		value.bind( function( to ) {
			$( '.hero-button' ).text( to );
		} );
	} );
	
	wp.customize( 'cuevas_hero_button_url', function( value ) {
		value.bind( function( to ) {
			$( '.hero-button' ).attr( 'href', to );
		} );
	} );
	
	// Update featured products section in real time
	wp.customize( 'cuevas_featured_products_title', function( value ) {
		value.bind( function( to ) {
			$( '#featured-products .section-title' ).text( to );
		} );
	} );
	
	wp.customize( 'cuevas_featured_products_subtitle', function( value ) {
		value.bind( function( to ) {
			$( '#featured-products .section-subtitle' ).text( to );
		} );
	} );
	
	// Update shop categories section in real time
	wp.customize( 'cuevas_shop_categories_title', function( value ) {
		value.bind( function( to ) {
			$( '#shop-categories .section-title' ).text( to );
		} );
	} );
	
	wp.customize( 'cuevas_shop_categories_subtitle', function( value ) {
		value.bind( function( to ) {
			$( '#shop-categories .section-subtitle' ).text( to );
		} );
	} );
} )( jQuery ); 