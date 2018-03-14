<?php
/**
 * The template for displaying Comments.
 **/
if ( post_password_required() ) return; 
if ( have_comments() ): ?>
<div class="row">
    <div class="col-xs-12">
        <div class="comment-area">
            <?php wp_list_comments(array('avatar_size' => 80,'status' => 'approve', 'style' => 'div', 'short_ping' => true,)); 
             the_comments_navigation(); ?>
        </div>
    </div>
</div>
<?php endif; 
if ( comments_open()) { ?>
<div class="row">
    <div class="col-md-12">
        <div class="comments-count">
            <h5><?php comments_number(); ?></h5>
        </div>
    </div>
</div>    
<div class="post-comment-form">
    <?php comment_form(); ?>
</div>
<?php } 