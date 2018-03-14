<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 *
 * @package copywriter
 */ ?>
<div class="sub-nav">
    <?php esc_html_e( 'Nothing Found', 'copywriter' ); ?>
</div>
<div class="animated fadeIn">    
    <div class="search-title">
        <h3><?php printf( esc_html__( 'Search Results for: %s', 'copywriter' ), '<span>' . get_search_query() . '</span>' ); ?></h3>
    </div>
    <div class="search-result">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p><?php printf( wp_kses_post( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'copywriter' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
		<?php elseif ( is_search() ) : ?>
				<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'copywriter' ); ?></p>
			<div class="search-input">
            <?php get_search_form(); ?>
            </div>    
			<?php else : ?>
				<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'copywriter' ); ?></p>
			<div class="search-input">
                <?php get_search_form(); ?>
		    </div>      
        <?php endif; ?>
	</div>
</div>