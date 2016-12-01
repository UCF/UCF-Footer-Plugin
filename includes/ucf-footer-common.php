<?php
/**
 * Place common functions here.
 **/

if ( !class_exists( 'UCF_Footer_Common' ) ) {

	class UCF_Footer_Common {
		public function enqueue_styles() {
			$include_css = UCF_Footer_Config::get_option_or_default( 'include_css' );

			if ( $include_css ) {
				wp_enqueue_style( 'ucf_footer_css', plugins_url( 'static/css/ucf-footer.min.css', UCF_FOOTER__PLUGIN_FILE ), false, false, 'all' );
			}
		}

		public function display_social_links() {
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

		public function display_nav_links() {
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

		public function display_footer() {
			ob_start();
		?>
			<div class="ucf-footer">
				<a class="ucf-footer-title" href="http://www.ucf.edu/">University of Central Florida</a>
				<?php echo self::display_social_links(); ?>
				<?php echo self::display_nav_links(); ?>
				<p class="ucf-footer-address">
					4000 Central Florida Blvd. Orlando, Florida, 32816 | <a href="tel:4078232000">407.823.2000</a>
					<br>
					&copy; <a href="http://www.ucf.edu/">University of Central Florida</a>
				</p>
			</div>
		<?php
			echo ob_get_clean();
		}
	}

	add_action( 'wp_enqueue_scripts', array( 'UCF_Footer_Common', 'enqueue_styles' ), 99 );
	add_action( 'wp_footer', array( 'UCF_Footer_Common', 'display_footer' ) );

}
