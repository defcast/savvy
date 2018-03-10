<?php
/**
 * Getting started template
 */
$customizer_url = admin_url() . 'customize.php';
$count          = $this->count_actions();
?>

	<div class="col">
		<h3><?php esc_html_e( 'Check our documentation', 'CNC' ); ?></h3>
		<p><?php esc_html_e( 'Find out how to take full advantage of CNC.', 'CNC' ); ?></p>
		<p>
			<a target="_blank" href="<?php echo esc_url( 'https://cnc.live/help/' ); ?>"><?php esc_html_e( 'Full documentation', 'CNC' ); ?></a>
		</p>
	</div><!--/.col-->

</div><!--/.feature-section-->
