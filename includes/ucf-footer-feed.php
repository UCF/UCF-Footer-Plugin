<?php
/**
 * Handles all feed related code.
 **/

if ( ! class_exists( 'UCF_Footer_Feed' ) ) {
	class UCF_Footer_Feed {
		public static function get_remote_menu( $option_name ) {
			global $wp_customize;
			$customizing    = isset( $wp_customize );
			$feed_url       = UCF_Footer_Config::get_option_or_default( $option_name );
			$transient_name = $option_name . '_json';
			$result         = get_transient( $transient_name );

			if ( empty( $result ) || $customizing ) {

				$response = wp_remote_get( $feed_url, array( 'timeout' => 15 ) );

				if ( is_array( $response ) ) {
					$result = json_decode( wp_remote_retrieve_body( $response ) );
				}
				else {
					$result = false;
				}

				if ( ! $customizing ) {
					set_transient( $transient_name, $result, (60 * 60 * 24) );
				}
			}

			return $result;
		}
	}
}
