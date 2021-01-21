<?php
/**
 * Place common functions here.
 **/

if ( !class_exists( 'UCF_Footer_Common' ) ) {

	class UCF_Footer_Common {
		public static function enqueue_styles() {
			$include_css = UCF_Footer_Config::get_option_or_default( 'include_css' );

			if ( $include_css ) {
				$plugin_data   = get_plugin_data( UCF_FOOTER__PLUGIN_FILE, false, false );
				$version       = $plugin_data['Version'];
				wp_enqueue_style( 'ucf_footer_css', plugins_url( 'static/css/ucf-footer.min.css', UCF_FOOTER__PLUGIN_FILE ), false, $version, 'all' );
			}
		}

		public static function async_load_styles( $html, $handle, $href, $media ) {
			if ( $handle === 'ucf_footer_css' ) {
				$html = str_replace( 'media=\'' . $media . '\'', 'media=\'print\' onload=\'this.media="' . $media . '"\'', $html );
			}
			return $html;
		}

		public static function display_social_links() {
			$menu = UCF_Footer_Feed::get_remote_menu( 'social_menu_url' );
			if ( !$menu ) { return; }

			ob_start();
		?>
			<ul class="ucf-footer-social">
			<?php foreach ( $menu->items as $item ): ?>
				<li class="ucf-footer-social-item">
					<a class="ucf-footer-social-link" href="<?php echo $item->url; ?>" target="<?php echo $item->target; ?>">
						<?php echo $item->title; ?>
					</a>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php
			return ob_get_clean();
		}

		public static function display_nav_links() {
			$menu = UCF_Footer_Feed::get_remote_menu( 'nav_menu_url' );
			if ( !$menu ) { return; }

			ob_start();
		?>
			<ul class="ucf-footer-nav">
			<?php foreach ( $menu->items as $item ): ?>
				<li class="ucf-footer-nav-item">
					<a class="ucf-footer-nav-link" href="<?php echo $item->url; ?>" target="<?php echo $item->target; ?>">
						<?php echo $item->title; ?>
					</a>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php
			return ob_get_clean();
		}

		public static function display_footer() {
			$display = apply_filters( 'ucf_footer_display_footer', true );
			if ( $display ) :
			ob_start();
		?>
			<footer class="ucf-footer" aria-label="University of Central Florida footer">
				<a class="ucf-footer-title" href="https://www.ucf.edu/">University of Central Florida</a>
				<?php echo self::display_social_links(); ?>
				<?php echo self::display_nav_links(); ?>
				<p class="ucf-footer-address">
					4000 Central Florida Blvd. Orlando, Florida, 32816 | <a rel="nofollow" class="ucf-footer-underline-link" href="tel:4078232000">407.823.2000</a>
					<br>
					&copy; <a class="ucf-footer-underline-link" href="https://www.ucf.edu/">University of Central Florida</a>
				</p>
			</footer>
		<?php
			echo ob_get_clean();
			endif;
		}
	}

	add_action( 'wp_enqueue_scripts', array( 'UCF_Footer_Common', 'enqueue_styles' ), 99 );
	add_action( 'style_loader_tag', array( 'UCF_Footer_Common', 'async_load_styles' ), 99, 4 );
	add_action( 'wp_footer', array( 'UCF_Footer_Common', 'display_footer' ) );

}

if ( ! function_exists( 'ucf_footer_display_footer' ) ) {
	function ucf_footer_display_footer() {
		return true;
	}

	add_filter( 'ucf_footer_display_footer', 'ucf_footer_display_footer' );
}
