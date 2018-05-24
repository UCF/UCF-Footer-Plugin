<?php
/**
 * Handles plugin configuration
 */

if ( !class_exists( 'UCF_Footer_Config' ) ) {

	class UCF_Footer_Config {
		public static
			$option_prefix = 'ucf_footer_',
			$option_defaults = array(
				'include_css'     => true,
				'social_menu_url' => 'https://www.ucf.edu/wp-json/ucf-rest-menus/v1/menus/26',
				'nav_menu_url'    => 'https://www.ucf.edu/wp-json/ucf-rest-menus/v1/menus/24'
			);

		/**
		 * Creates options via the WP Options API that are utilized by the
		 * plugin.  Intended to be run on plugin activation.
		 *
		 * @return void
		 **/
		public static function add_options() {
			$defaults = self::$option_defaults; // don't use self::get_option_defaults() here (default options haven't been set yet)

			add_option( self::$option_prefix . 'include_css', $defaults['include_css'] );
			add_option( self::$option_prefix . 'social_menu_url', $defaults['social_menu_url'] );
			add_option( self::$option_prefix . 'nav_menu_url', $defaults['nav_menu_url'] );
		}

		/**
		 * Deletes options via the WP Options API that are utilized by the
		 * plugin.  Intended to be run on plugin uninstallation.
		 *
		 * @return void
		 **/
		public static function delete_options() {
			delete_option( self::$option_prefix . 'include_css' );
			delete_option( self::$option_prefix . 'social_menu_url' );
			delete_option( self::$option_prefix . 'nav_menu_url' );
		}

		/**
		 * Returns a list of default plugin options. Applies any overridden
		 * default values set within the options page.
		 *
		 * @return array
		 **/
		public static function get_option_defaults() {
			$defaults = self::$option_defaults;

			// Apply default values configurable within the options page:
			$configurable_defaults = array(
				'include_css'     => get_option( self::$option_prefix . 'include_css' ),
				'social_menu_url' => get_option( self::$option_prefix . 'social_menu_url' ),
				'nav_menu_url'    => get_option( self::$option_prefix . 'nav_menu_url' ),
			);

			$configurable_defaults = self::format_options( $configurable_defaults );

			// Force configurable options to override $defaults, even if they are empty:
			$defaults = array_merge( $defaults, $configurable_defaults );

			return $defaults;
		}

		/**
		 * Returns an array with plugin defaults applied.
		 *
		 * @param array $list
		 * @param boolean $list_keys_only Modifies results to only return array key
		 *                                values present in $list.
		 * @return array
		 **/
		public static function apply_option_defaults( $list, $list_keys_only=false ) {
			$defaults = self::get_option_defaults();
			$options = array();

			if ( $list_keys_only ) {
				foreach ( $list as $key => $val ) {
					$options[$key] = !empty( $val ) ? $val : $defaults[$key];
				}
			}
			else {
				$options = array_merge( $defaults, $list );
			}

			$options = self::format_options( $options );

			return $options;
		}

		/**
		 * Performs typecasting, sanitization, etc on an array of plugin options.
		 *
		 * @param array $list
		 * @return array
		 **/
		public static function format_options( $list ) {
			foreach ( $list as $key => $val ) {
				switch ( $key ) {
					case 'include_css':
						$list[$key] = filter_var( $val, FILTER_VALIDATE_BOOLEAN );
						break;
					default:
						break;
				}
			}

			return $list;
		}

		/**
		 * Convenience method for returning an option from the WP Options API
		 * or a plugin option default.
		 *
		 * @param $option_name
		 * @return mixed
		 **/
		public static function get_option_or_default( $option_name ) {
			// Handle $option_name passed in with or without self::$option_prefix applied:
			$option_name_no_prefix = str_replace( self::$option_prefix, '', $option_name );
			$option_name = self::$option_prefix . $option_name_no_prefix;

			$option = get_option( $option_name );
			$option_formatted = self::apply_option_defaults( array(
				$option_name_no_prefix => $option
			), true );

			return $option_formatted[$option_name_no_prefix];
		}

		/**
		 * Initializes setting registration with the Settings API.
		 **/
		public static function settings_init() {
			// Register settings
			register_setting( 'ucf_footer', self::$option_prefix . 'include_css' );
			register_setting( 'ucf_footer', self::$option_prefix . 'social_menu_url' );
			register_setting( 'ucf_footer', self::$option_prefix . 'nav_menu_url' );

			// Register setting sections
			add_settings_section(
				'ucf_footer_section_general', // option section slug
				'General Settings', // formatted title
				'', // callback that echoes any content at the top of the section
				'ucf_footer' // settings page slug
			);

			// Register fields
			add_settings_field(
				self::$option_prefix . 'include_css',
				'Include Default CSS',  // formatted field title
				array( 'UCF_Footer_Config', 'display_settings_field' ),  // display callback
				'ucf_footer',  // settings page slug
				'ucf_footer_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'include_css',
					'description' => 'Register the stylesheet for the UCF footer styles in the document head for this theme.<br>Leave this checkbox checked unless your theme contains a copy of the footer styles in its stylesheet.',
					'type'        => 'checkbox'
				)
			);
			add_settings_field(
				self::$option_prefix . 'social_menu_url',
				'Social Link Menu Feed URL',  // formatted field title
				array( 'UCF_Footer_Config', 'display_settings_field' ),  // display callback
				'ucf_footer',  // settings page slug
				'ucf_footer_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'social_menu_url',
					'description' => 'URL to the WP Rest API representation of the ucf.edu social link menu.',
					'type'        => 'text'
				)
			);
			add_settings_field(
				self::$option_prefix . 'nav_menu_url',
				'Footer Navigation Menu Feed URL',  // formatted field title
				array( 'UCF_Footer_Config', 'display_settings_field' ),  // display callback
				'ucf_footer',  // settings page slug
				'ucf_footer_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'nav_menu_url',
					'description' => 'URL to the WP Rest API representation of the ucf.edu footer navigation menu.',
					'type'        => 'text'
				)
			);
		}

		/**
		 * Displays an individual setting's field markup.
		 **/
		public static function display_settings_field( $args ) {
			$option_name   = $args['label_for'];
			$description   = $args['description'];
			$field_type    = $args['type'];
			$current_value = self::get_option_or_default( $option_name );
			$markup        = '';

			switch ( $field_type ) {
				case 'checkbox':
					ob_start();
				?>
					<input type="checkbox" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" <?php echo ( $current_value == true ) ? 'checked' : ''; ?>>
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;

				case 'text':
				default:
					ob_start();
				?>
					<input type="text" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" value="<?php echo $current_value; ?>">
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;
			}
		?>

		<?php
			echo $markup;
		}


		/**
		 * Registers the settings page to display in the WordPress admin.
		 **/
		public static function add_options_page() {
			$page_title = 'UCF Footer Settings';
			$menu_title = 'UCF Footer';
			$capability = 'manage_options';
			$menu_slug  = 'ucf_footer';
			$callback   = array( 'UCF_Footer_Config', 'options_page_html' );

			return add_options_page(
				$page_title,
				$menu_title,
				$capability,
				$menu_slug,
				$callback
			);
		}


		/**
		 * Displays the plugin's settings page form.
		 **/
		public static function options_page_html() {
			ob_start();
		?>

		<div class="wrap">
			<h1><?php echo get_admin_page_title(); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'ucf_footer' );
				do_settings_sections( 'ucf_footer' );
				submit_button();
				?>
			</form>
		</div>

		<?php
			echo ob_get_clean();
		}

	}

	add_action( 'admin_init', array( 'UCF_Footer_Config', 'settings_init' ) );
	add_action( 'admin_menu', array( 'UCF_Footer_Config', 'add_options_page' ) );

}
