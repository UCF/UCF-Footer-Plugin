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
				$use_semantic = apply_filters( 'ucf_footer_use_semantic_wrapper', true );
				$open_tag  = $use_semantic ? '<footer class="ucf-footer" aria-label="University of Central Florida footer">' : '<div class="ucf-footer">';
				$close_tag = $use_semantic ? '</footer>' : '</div>';

				ob_start();
		?>
				<?php echo $open_tag; ?>
					<a class="ucf-footer-title" href="https://www.ucf.edu/">University of Central Florida</a>
					<?php echo self::display_social_links(); ?>
					<?php echo self::display_nav_links(); ?>
					<p class="ucf-footer-address">
						4000 Central Florida Blvd. Orlando, Florida, 32816 | <a rel="nofollow" class="ucf-footer-underline-link" href="tel:4078232000">407.823.2000</a>
						<br>
						&copy; <a class="ucf-footer-underline-link" href="https://www.ucf.edu/">University of Central Florida</a>
					</p>
				<?php echo $close_tag; ?>
		<?php
				echo trim( ob_get_clean() );
			endif;
		}

		/**
		 * Registers the UCF Footer display action at the action hook
		 * provided by the `ucf_footer_display_hook_name` filter.
		 *
		 * NOTE: this method must hook into `init` to allow themes to
		 * override the `ucf_footer_display_hook_name` filter in time.
		 */
		public static function add_footer_display_action() {
			$display_hook = trim( apply_filters( 'ucf_footer_display_hook_name', 'wp_footer' ) ) ?: 'wp_footer';
			add_action( $display_hook, array( 'UCF_Footer_Common', 'display_footer' ) );
		}
	}

	add_action( 'wp_enqueue_scripts', array( 'UCF_Footer_Common', 'enqueue_styles' ), 99 );
	add_action( 'style_loader_tag', array( 'UCF_Footer_Common', 'async_load_styles' ), 99, 4 );
	add_action( 'init', array( 'UCF_Footer_Common', 'add_footer_display_action' ) );
}

/**
 * Filter hook that allows themes/plugins to configure if and when
 * to display the UCF Footer.
 */
if ( ! function_exists( 'ucf_footer_display_footer' ) ) {
	function ucf_footer_display_footer() {
		return true;
	}

	add_filter( 'ucf_footer_display_footer', 'ucf_footer_display_footer' );
}

/**
 * Filter hook that allows themes to configure if the
 * UCF Footer contents should be wrapped in a semantic <footer>
 * or a <div>.
 *
 * Themes that use their own semantic <footer> in addition to the
 * UCF Footer should hook into this filter with `__return_false`
 * to avoid more than one `contentinfo` landmark from being rendered
 * on screen at a time.
 * https://dequeuniversity.com/rules/axe/4.3/landmark-no-duplicate-contentinfo
 */
if ( ! function_exists( 'ucf_footer_use_semantic_wrapper' ) ) {
	function ucf_footer_use_semantic_wrapper() {
		return true;
	}

	add_filter( 'ucf_footer_use_semantic_wrapper', 'ucf_footer_use_semantic_wrapper' );
}

/**
 * Filter hook that allows themes to modify what action hook
 * the UCF Header should be displayed with.  By default, the UCF Footer
 * will be displayed via `wp_footer`.
 *
 * Note that the returned value must be an _action_ hook, not a
 * _filter_ hook.
 */
if ( ! function_exists( 'ucf_footer_display_hook_name' ) ) {
	function ucf_footer_display_hook_name( $hook_name ) {
		return 'wp_footer';
	}

	add_filter( 'ucf_footer_display_hook_name', 'ucf_footer_display_hook_name', 10, 1 );
}
