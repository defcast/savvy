<?php

if ( ! class_exists( 'CNC_Notify_System' ) ) {
	/**
	 * Class CNC_Notify_System
	 */
	class CNC_Notify_System extends Epsilon_Notify_System {
		/**
		 * @param $ver
		 *
		 * @return mixed
		 */
		public static function CNC_version_check( $ver ) {
			$CNC = wp_get_theme();

			return version_compare( $CNC['Version'], $ver, '>=' );
		}

		/**
		 * @return bool
		 */
		public static function CNC_is_not_static_page() {
			return 'page' == get_option( 'show_on_front' ) ? true : false;
		}


		/**
		 * @return bool
		 */
		public static function CNC_has_content() {
			$option = get_option( 'CNC_imported_demo', false );
			if ( $option ) {
				return true;
			};

			return false;
		}

		/**
		 * @return bool|mixed
		 */
		public static function CNC_check_import_req() {
			$needs = array(
				'has_content' => self::CNC_has_content(),
				'has_plugin'  => self::CNC_has_plugin( 'CNC-companion' ),
			);

			if ( $needs['has_content'] ) {
				return true;
			}

			if ( $needs['has_plugin'] ) {
				return false;
			}

			return true;
		}

		/**
		 * @return bool
		 */
		public static function CNC_check_plugin_is_installed( $slug ) {
			$slug2 = $slug;
			if ( 'wordpress-seo' === $slug ) {
				$slug2 = 'wp-seo';
			}

			$path = WPMU_PLUGIN_DIR . '/' . $slug . '/' . $slug2 . '.php';
			if ( ! file_exists( $path ) ) {
				$path = WP_PLUGIN_DIR . '/' . $slug . '/' . $slug2 . '.php';

				if ( ! file_exists( $path ) ) {
					$path = false;
				}
			}

			if ( file_exists( $path ) ) {
				return true;
			}

			return false;
		}

		/**
		 * @return bool
		 */
		public static function CNC_check_plugin_is_active( $slug ) {
			$slug2 = $slug;
			if ( 'wordpress-seo' === $slug ) {
				$slug2 = 'wp-seo';
			}

			$path = WPMU_PLUGIN_DIR . '/' . $slug . '/' . $slug2 . '.php';
			if ( ! file_exists( $path ) ) {
				$path = WP_PLUGIN_DIR . '/' . $slug . '/' . $slug2 . '.php';
				if ( ! file_exists( $path ) ) {
					$path = false;
				}
			}

			if ( file_exists( $path ) ) {
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

				return is_plugin_active( $slug . '/' . $slug2 . '.php' );
			}
		}

		public static function CNC_has_plugin( $slug = null ) {

			$check = array(
				'installed' => self::check_plugin_is_installed( $slug ),
				'active'    => self::check_plugin_is_active( $slug ),
			);

			if ( ! $check['installed'] || ! $check['active'] ) {
				return false;
			}

			return true;
		}

		public static function CNC_companion_title() {
			$installed = self::check_plugin_is_installed( 'CNC-companion' );
			if ( ! $installed ) {
				return esc_html__( 'Install: CNC Companion Plugin', 'CNC' );
			}

			$active = self::check_plugin_is_active( 'CNC-companion' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Activate: CNC Companion Plugin', 'CNC' );
			}

			return esc_html__( 'Install: CNC Companion Plugin', 'CNC' );
		}

		public static function CNC_yoast_title() {
			$installed = self::check_plugin_is_installed( 'wordpress-seo' );
			if ( ! $installed ) {
				return esc_html__( 'Install: Yoast SEO Plugin', 'CNC' );
			}

			$active = self::check_plugin_is_active( 'wordpress-seo' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Activate: Yoast SEO Plugin', 'CNC' );
			}

			return esc_html__( 'Install: Yoast SEO Plugin', 'CNC' );
		}

		public static function CNC_jetpack_title() {
			$installed = self::check_plugin_is_installed( 'jetpack' );
			if ( ! $installed ) {
				return esc_html__( 'Install: Jetpack by WordPress', 'CNC' );
			}

			$active = self::check_plugin_is_active( 'jetpack' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Activate: Jetpack by WordPress', 'CNC' );
			}

			return esc_html__( 'Install: Jetpack by WordPress', 'CNC' );
		}

		public static function CNC_cf7_title() {
			$installed = self::check_plugin_is_installed( 'contac-form-7' );
			if ( ! $installed ) {
				return esc_html__( 'Install: Contact Form 7', 'CNC' );
			}

			$active = self::check_plugin_is_active( 'contac-form-7' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Activate: Contact Form 7', 'CNC' );
			}

			return esc_html__( 'Install: Contact Form 7', 'CNC' );
		}

		/**
		 * @return string
		 */
		public static function CNC_companion_description() {
			$installed = self::check_plugin_is_installed( 'CNC-companion' );

			if ( ! $installed ) {
				return esc_html__( 'Please install CNC Companion plugin.', 'CNC' );
			}

			$active = self::check_plugin_is_active( 'CNC-companion' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Please activate CNC Companion plugin.', 'CNC' );
			}

			return esc_html__( 'Please install CNC Companion plugin.', 'CNC' );
		}

		/**
		 * @return string
		 */
		public static function CNC_jetpack_description() {
			$installed = self::check_plugin_is_installed( 'jetpack' );

			if ( ! $installed ) {
				return esc_html__( 'Please install Jetpack by WordPress. Note that you won\'t be able to use the Testimonials and Portfolio widgets without it.', 'CNC' );
			}

			$active = self::check_plugin_is_active( 'jetpack' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Please activate Jetpack by WordPress. Note that you won\'t be able to use the Testimonials and Portfolio widgets without it.', 'CNC' );
			}

			return esc_html__( 'Please install Jetpack by WordPress. Note that you won\'t be able to use the Testimonials and Portfolio widgets without it.', 'CNC' );
		}

		public static function CNC_cf7_description() {
			$installed = self::check_plugin_is_installed( 'contac-form-7' );

			if ( ! $installed ) {
				return esc_html__( 'Please install Contact Form 7. Note that you won\'t be able to use Contact widget without it.', 'CNC' );
			}

			$active = self::check_plugin_is_active( 'contac-form-7' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Please activate Contact Form 7. Note that you won\'t be able to use Contact widget without it.', 'CNC' );
			}

			return esc_html__( 'Please install Contact Form 7. Note that you won\'t be able to use Contact widget without it.', 'CNC' );
		}

		public static function CNC_yoast_description() {
			$installed = self::check_plugin_is_installed( 'wordpress-seo' );
			if ( ! $installed ) {
				return esc_html__( 'Please install Yoast SEO plugin.', 'CNC' );
			}

			$active = self::check_plugin_is_active( 'wordpress-seo' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Please activate Yoast SEO plugin.', 'CNC' );
			}

			return esc_html__( 'Please install Yoast SEO plugin.', 'CNC' );

		}

		/**
		 * @return bool
		 */
		public static function CNC_is_not_template_front_page() {
			$page_id = get_option( 'page_on_front' );

			return get_page_template_slug( $page_id ) == 'page-templates/frontpage-template.php' ? true : false;
		}
	}
}// End if().
