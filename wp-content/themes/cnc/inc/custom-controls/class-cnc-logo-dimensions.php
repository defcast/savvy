<?php

class CNC_Logo_Dimensions extends WP_Customize_Control {

	public $type = 'CNC-logo-dimension';

	public function __construct( WP_Customize_Manager $manager, $id, array $args ) {
		parent::__construct( $manager, $id, $args );
		$manager->register_control_type( 'CNC_Logo_Dimensions' );
	}

	public function get_dimensions() {

		$current_value = $this->value();

		if ( ! $current_value ) {
			$current_value = array(
				'width'  => '',
				'height' => '',
				'ratio'  => 1,
			);

			$custom_logo = get_theme_mod( 'custom_logo' );
			if ( $custom_logo ) {
				$logo = wp_get_attachment_image_src( $custom_logo, 'full' );
				if ( is_array( $logo ) ) {

					$current_value['width']  = $logo[1];
					$current_value['height'] = $logo[2];

				}
			}
		}

		return $current_value;

	}

	public function json() {
		$json                   = parent::json();
		$json['id']             = $this->id;
		$json['link']           = $this->get_link();
		$json['value']          = $this->get_dimensions();
		$json['widthLabel']     = esc_attr__( 'Logo Width:', 'CNC' );
		$json['heightLabel']    = esc_attr__( 'Logo Height:', 'CNC' );
		$json['checkboxtLabel'] = esc_attr__( 'Keep logo ratio.', 'CNC' );

		return $json;

	}

	public function content_template() {
	?>

		<div class="CNC-logo-dimension">
			<div class="half">
				<label for="{{{ data.id }}}-width">{{ data.widthLabel }}</label>
				<input type="text" id="{{{ data.id }}}-width" value="{{ data.value.width }}" class="CNC-dimension">
			</div>
			<div class="half">
				<label for="{{{ data.id }}}-height">{{ data.heightLabel }}</label>
				<input type="text" id="{{{ data.id }}}-height" value="{{ data.value.height }}" class="CNC-dimension">
			</div>
			<div class="ratio">
				<label>
					<input class="CNC-ratio" type="checkbox" id="{{{ data.id }}}-ration" <# if( data.value.ratio ) { #> checked="checked" <# } #> value="1">
					{{ data.checkboxtLabel }}
				</label>
			</div>
		</div>

	<?php
	}

}
