<?php

class CNC {

	public $recommended_plugins = array(
		'simple-custom-post-order' => array(
			'recommended' => false,
		),
		'fancybox-for-wordpress'   => array(
			'recommended' => false,
		),
	);

	public $recommended_actions;

	public $theme_slug = 'CNC';

	function __construct() {

		if ( ! is_admin() && ! is_customize_preview() ) {
			return;
		}

		$this->load_class();

		$this->recommended_actions = apply_filters(
			'CNC_required_actions', array(
				array(
					'id'          => 'CNC-req-import-content',
					'title'       => esc_html__( 'Import Demo Content', 'CNC' ),
					'description' => esc_html__( 'Clicking the button below will install and activate plugins, add widgets and set static front page to your WordPress installation. Click advanced to customize the import process.', 'CNC' ),
					'help'        => $this->generate_action_html(),
					'check'       => CNC_Notify_System::CNC_has_content(),
				),
				array(
					'id'          => 'CNC-req-ac-install-companion-plugin',
					'title'       => CNC_Notify_System::CNC_companion_title(),
					'description' => CNC_Notify_System::CNC_companion_description(),
					'check'       => CNC_Notify_System::CNC_has_plugin( 'CNC-companion' ),
					'plugin_slug' => 'CNC-companion',
				),
				array(
					'id'          => 'CNC-req-ac-install-wp-jetpack-plugin',
					'title'       => CNC_Notify_System::CNC_jetpack_title(),
					'description' => CNC_Notify_System::CNC_jetpack_description(),
					'check'       => CNC_Notify_System::CNC_has_plugin( 'jetpack' ),
					'plugin_slug' => 'jetpack',
				),
				array(
					'id'          => 'CNC-req-ac-install-contact-form-7',
					'title'       => CNC_Notify_System::CNC_cf7_title(),
					'description' => CNC_Notify_System::CNC_cf7_description(),
					'check'       => CNC_Notify_System::CNC_has_plugin( 'contact-form-7' ),
					'plugin_slug' => 'contact-form-7',
				),
			)
		);

		$this->init_epsilon();
		$this->init_welcome_screen();

		// Hooks
		add_action( 'customize_register', array( $this, 'init_customizer' ) );

	}

	public function load_class() {

		if ( ! is_admin() && ! is_customize_preview() ) {
			return;
		}

		require_once get_template_directory() . '/inc/libraries/epsilon-framework/class-epsilon-autoloader.php';
		require_once get_template_directory() . '/inc/class-CNC-notify-system.php';
		require_once get_template_directory() . '/inc/libraries/welcome-screen/class-epsilon-welcome-screen.php';

	}

	public function init_epsilon() {

		$args = array(
			'controls' => array( 'slider', 'toggle' ), // array of controls to load
			'sections' => array( 'recommended-actions', 'pro' ), // array of sections to load
			'backup'   => false,
		);

		new Epsilon_Framework( $args );

	}

	public function init_welcome_screen() {

		Epsilon_Welcome_Screen::get_instance(
			$config = array(
				'theme-name' => 'CNC',
				'theme-slug' => 'CNC',
				'actions'    => $this->recommended_actions,
				'plugins'    => $this->recommended_plugins,
			)
		);

	}

	public function init_customizer( $wp_customize ) {
		$current_theme = wp_get_theme();
		$wp_customize->add_section(
			new Epsilon_Section_Recommended_Actions(
				$wp_customize, 'epsilon_recomended_section', array(
					'title'                        => esc_html__( 'Recomended Actions', 'CNC' ),
					'social_text'                  => esc_html( $current_theme->get( 'Author' ) ) . esc_html__( ' is social :', 'CNC' ),
					'plugin_text'                  => esc_html__( 'Recomended Plugins :', 'CNC' ),
					'actions'                      => $this->recommended_actions,
					'plugins'                      => $this->recommended_plugins,
					'theme_specific_option'        => $this->theme_slug . '_show_required_actions',
					'theme_specific_plugin_option' => $this->theme_slug . '_show_required_plugins',
					'facebook'                     => 'https://www.facebook.com/colorlib',
					'twitter'                      => 'https://twitter.com/colorlib',
					'wp_review'                    => true,
					'priority'                     => 0,
				)
			)
		);

	}

	private function generate_action_html() {

		$import_actions = array(
			'set-frontpage'  => esc_html__( 'Set Static FrontPage', 'CNC' ),
			'import-widgets' => esc_html__( 'Import HomePage Widgets', 'CNC' ),
		);

		$import_plugins = array(
			'CNC-companion' => esc_html__( 'CNC Companion', 'CNC' ),
			'jetpack'           => esc_html__( 'Jetpack', 'CNC' ),
			'contact-form-7'    => esc_html__( 'Contact Form 7', 'CNC' ),
		);

		$plugins_html = '';

		if ( is_customize_preview() ) {
			$url  = 'themes.php?page=%1$s-welcome&tab=%2$s';
			$html = '<a class="button button-primary" id="" href="' . esc_url( admin_url( sprintf( $url, 'CNC', 'recommended-actions' ) ) ) . '">' . __( 'Import Demo Content', 'CNC' ) . '</a>';
		} else {
			$html  = '<p><a class="button button-primary cpo-import-button epsilon-ajax-button" data-action="import_demo" id="add_default_sections" href="#">' . __( 'Import Demo Content', 'CNC' ) . '</a>';
			$html .= '<a class="button epsilon-hidden-content-toggler" href="#welcome-hidden-content">' . __( 'Advanced', 'CNC' ) . '</a></p>';
			$html .= '<div class="import-content-container" id="welcome-hidden-content">';

			foreach ( $import_plugins as $id => $label ) {
				if ( ! CNC_Notify_System::CNC_has_plugin( $id ) ) {
					$plugins_html .= $this->generate_checkbox( $id, $label, 'plugins' );
				}
			}

			if ( '' != $plugins_html ) {
				$html .= '<div class="plugins-container">';
				$html .= '<h4>' . __( 'Plugins', 'CNC' ) . '</h4>';
				$html .= '<div class="checkbox-group">';
				$html .= $plugins_html;
				$html .= '</div>';
				$html .= '</div>';
			}

			$html .= '<div class="demo-content-container">';
			$html .= '<h4>' . __( 'Demo Content', 'CNC' ) . '</h4>';
			$html .= '<div class="checkbox-group">';
			foreach ( $import_actions as $id => $label ) {
				$html .= $this->generate_checkbox( $id, $label );
			}
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
		}

		return $html;

	}

	private function generate_checkbox( $id, $label, $name = 'options', $block = false ) {
		$string = '<label><input checked type="checkbox" name="%1$s" class="demo-checkboxes"' . ( $block ? ' disabled ' : ' ' ) . 'value="%2$s">%3$s</label>';
		return sprintf( $string, $name, $id, $label );
	}

}
new CNC();
