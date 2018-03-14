<?php
/**
 * The template for displaying the footer
 *
 */ 
?>
</div>
<!--Contain-End-->
</div>
<?php $footer_copyrights = esc_html(get_theme_mod('footer_copyrights')); ?>
<footer class="footer">
    <div class="footer-area">
        <?php $social_icon_area = esc_html(get_theme_mod('social_icon_area', 1)); 
        if($social_icon_area == 1){ ?>
        <div class="social-links">
            <ul class="list-inline">
            <?php for($copywriter_i=1;$copywriter_i<=10;$copywriter_i++):
                if (get_theme_mod('copywriter_social_icon'.$copywriter_i) != '' && get_theme_mod('copywriter_social_icon_link'.$copywriter_i) != '') {
                $copywriter_social_icon_link = esc_url(get_theme_mod('copywriter_social_icon_link'.$copywriter_i));
                $copywriter_social_icon = esc_attr(get_theme_mod('copywriter_social_icon'.$copywriter_i)); ?>	
                <li><a href="<?php echo $copywriter_social_icon_link; ?>" target="_blank"><i class="fa <?php echo $copywriter_social_icon; ?>"></i></a></li>
            <?php } 
            endfor; ?>    
        	</ul>
        </div>
        <?php } ?>
        <div class="copy-right-area">
            <h4><?php if($footer_copyrights != ''){
                echo wp_kses_post(get_theme_mod('footer_copyrights')).' | '; 
            } ?> <?php echo esc_html__('Powered By ','copywriter'); ?> <a href="<?php echo esc_url('https://vaultthemes.com/wordpress-themes/copywriter/','copywriter'); ?>" target="_blank"><?php esc_html_e('Copywriter WordPress Theme.','copywriter'); ?></a></h4>
        </div>
    </div>
</footer>
</main>
<?php wp_footer(); ?> 
</body>
</html>