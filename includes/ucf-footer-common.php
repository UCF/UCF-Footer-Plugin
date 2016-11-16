<?php
/**
 * Place common functions here.
 **/

if ( !class_exists( 'UCF_Footer_Common' ) ) {

	class UCF_Footer_Common {
		public function display_footer() {
			$include_css = UCF_Footer_Config::get_option_or_default( 'include_css' );

			if ( $include_css ) {
				wp_enqueue_style( 'ucf_footer_css', plugins_url( 'static/css/ucf-footer.min.css', UCF_FOOTER__PLUGIN_FILE ), false, false, 'all' );
			}

			// TODO output footer markup
		}
	}

}
