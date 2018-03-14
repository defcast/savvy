<?php
/**
 * The template for displaying 404 pages (not found)
 *
 *
 * @package copywriter
 */
get_header(); ?>
<div class="sub-nav">
    <?php esc_html_e( "Oops! That page can't be found.", "copywriter" ); ?>
</div>
<div class="animated fadeIn">
    <div class="page-not-found">
        <p><?php esc_html_e( "Epic 404 - Article Not Found", "copywriter" ); ?></p>
        <p><?php esc_html_e( "This is embarassing. We can't find what you were looking for.", "copywriter" ); ?></p>
        <p><?php esc_html_e( "Whatever you were looking for was not found, but maybe try looking again or search using the form below.", "copywriter" ); ?></p>
    </div>
    <?php get_search_form(); ?>
</div>        
<?php get_footer();