<?php
/**
 * A WC_Accommodation_Dependencies class file.
 *
 * @package woocommerce-accommodation-bookings
 */

/**
 * WC Accommodation Bookings Dependency Checker
 *
 * Checks if WooCommerce Bookings is enabled and if it is the correct
 * version for accommodations to work.
 */
class WC_Accommodation_Dependencies {

	/**
	 * Array of active plugins
	 *
	 * @var array of active plugins
	 */
	private static $active_plugins;

	/**
	 * Load a list of our currently active WordPress plugins
	 */
	public static function init() {
		self::$active_plugins = (array) get_option( 'active_plugins', array() );
		if ( is_multisite() ) {
			self::$active_plugins = array_merge( self::$active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
		}
	}

	/**
	 * Returns true if bookings is installed/active and false if not
	 *
	 * @return boolean
	 */
	private static function is_bookings_installed() {
		// Notice the typo on plugin's file for Bookings <= 1.9.10.
		$old_booking_file = 'woocommerce-bookings/woocommmerce-bookings.php';
		$booking_file     = 'woocommerce-bookings/woocommerce-bookings.php';

		return (
			in_array( $booking_file, self::$active_plugins, true )
			||
			array_key_exists( $booking_file, self::$active_plugins )
			||
			class_exists( 'WC_Bookings' )
			||
			in_array( $old_booking_file, self::$active_plugins, true )
			||
			array_key_exists( $old_booking_file, self::$active_plugins )
		);
	}

	/**
	 * Returns true if bookings is greater than a specific version and false if not
	 *
	 * @param string $version The version to check against.
	 * @return boolean
	 */
	private static function is_bookings_above_or_equal_to_version( $version ) {
		if ( version_compare( get_option( 'wc_bookings_version' ), $version, '>=' ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Check dependencies.
	 *
	 * @throws Exception Show exception on dependencies failure.
	 */
	public static function check_dependencies() {
		if ( ! self::$active_plugins ) {
			self::init();
		}

		if ( ! self::is_bookings_installed() ) {
			throw new Exception( esc_html__( 'Accommodation Bookings requires Bookings plugin activated.', 'woocommerce-accommodation-bookings' ) );
		}

		if ( ! self::is_bookings_above_or_equal_to_version( '1.9.0' ) ) {
			throw new Exception( esc_html__( 'Accommodation Bookings requires Bookings version 1.9+.', 'woocommerce-accommodation-bookings' ) );
		}

		if ( ! version_compare( PHP_VERSION, '7.4', '>=' ) ) {
			throw new Exception( esc_html__( 'Accommodation Bookings requires PHP version 7.4 or above.', 'woocommerce-accommodation-bookings' ) );
		}
	}
}
