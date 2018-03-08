<?php
/**
 * Plugin Name: Client Portal
 * Plugin URI: http://www.cozmoslabs.com/
 * Description:  Build a company site with a client portal where clients login and see a restricted-access, personalized page of content with links and downloads.
 * Version: 1.0.4
 * Author: Cozmoslabs, Madalin Ungureanu, Antohe Cristian
 * Author URI: http://www.cozmoslabs.com
 * License: GPL2
 */
/*  Copyright 2015 Cozmoslabs (www.cozmoslabs.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/*
* Define plugin path
*/

define( 'CP_URL', plugin_dir_url( __FILE__ ) );

class CL_Client_Portal
{
    private $slug;
    private $defaults;
    public $options;


    function __construct()
    {
        $this->slug = 'cp-options';
        $this->options = get_option( $this->slug );
        $this->defaults = array(
                                'page-slug' => 'private-page',
                                'support-comments' => 'no',
                                'restricted-message' => __( 'You do not have permission to view this page.', 'client-portal' ),
                                'portal-log-in-message' => __( 'Please log in in order to access the client portal.', 'client-portal' ),
                                'default-page-content' => ''
                                );

        /* register the post type */
        add_action( 'init', array( $this, 'cp_create_post_type' ) );
        /* action to create a private page when a user registers */
        add_action( 'user_register', array( $this, 'cp_create_private_page' ) );
        /* remove the page when a user is deleted */
        add_action( 'deleted_user', array( $this, 'cp_delete_private_page' ), 10, 2 );
        /* restrict the content of the page only to the user */
        add_filter( 'the_content', array( $this, 'cp_restrict_content' ) );
        /* add a link in the Users List Table in admin area to access the page */
        add_filter( 'user_row_actions', array( $this, 'cp_add_link_to_private_page' ), 10, 2);

        /* add bulk action to create private user pages */
        add_filter( 'admin_footer-users.php', array( $this, 'cp_create_private_page_bulk_actions' ) );
        add_action( 'admin_action_create_private_page', array( $this, 'cp_create_private_pages_in_bulk' ) );

        /* create client portal extra information */
        add_filter('the_content', array( $this, 'cp_add_private_page_info'));

        /* create the shortcode for the main page */
        add_shortcode( 'client-portal', array( $this, 'cp_shortcode' ) );

        /* create the settings page */
        add_action( 'admin_menu', array( $this, 'cp_add_settings_page' ) );
        /* register the settings */
        add_action( 'admin_init', array( $this, 'cp_register_settings' ) );
        /* show notices on the admin settings page */
        add_action( 'admin_notices', array( $this, 'cp_admin_notices' ) );
        // Enqueue scripts on the admin side
        add_action( 'admin_enqueue_scripts', array( $this, 'cp_enqueue_admin_scripts' ) );
        /* flush the rewrite rules when settings saved in case page slug was changed */
        add_action('init', array( $this, 'cp_flush_rules' ), 20 );

        /* make sure we don't have post navigation on the private pages */
        add_filter( "get_previous_post_where", array( $this, 'cp_exclude_from_post_navigation' ), 10, 5 );
        add_filter( "get_next_post_where", array( $this, 'cp_exclude_from_post_navigation' ), 10, 5 );

    }

    /**
     * Function that registers the post type
     */
    function cp_create_post_type() {

        $labels = array(
            'name'               => _x( 'Private Pages', 'post type general name', 'client-portal' ),
            'singular_name'      => _x( 'Private Page', 'post type singular name', 'client-portal' ),
            'menu_name'          => _x( 'Private Page', 'admin menu', 'client-portal' ),
            'name_admin_bar'     => _x( 'Private Page', 'add new on admin bar', 'client-portal' ),
            'add_new'            => _x( 'Add New', 'private Page', 'client-portal' ),
            'add_new_item'       => __( 'Add New Private Page', 'client-portal' ),
            'new_item'           => __( 'New Private Page', 'client-portal' ),
            'edit_item'          => __( 'Edit Private Page', 'client-portal' ),
            'view_item'          => __( 'View Private Page', 'client-portal' ),
            'all_items'          => __( 'All Private Pages', 'client-portal' ),
            'search_items'       => __( 'Search Private Pages', 'client-portal' ),
            'parent_item_colon'  => __( 'Parent Private Page:', 'client-portal' ),
            'not_found'          => __( 'No Private Pages found.', 'client-portal' ),
            'not_found_in_trash' => __( 'No Private Pages found in Trash.', 'client-portal' )
        );

        $args = array(
            'labels'                => $labels,
            'description'           => __( 'Description.', 'client-portal' ),
            'public'                => true,
            'publicly_queryable'    => true,
            'show_ui'               => true,
            'show_in_menu'          => false,
            'query_var'             => true,
            'capability_type'       => 'post',
            'has_archive'           => false,
            'hierarchical'          => true,
            'supports'              => array( 'title', 'editor', 'thumbnail' ),
            'exclude_from_search'   => true
        );

        if( !empty( $this->options['page-slug'] ) ){
            $args['rewrite'] = array( 'slug' => $this->options['page-slug'] );
        }
        else{
            $args['rewrite'] = array( 'slug' => $this->defaults['page-slug'] );
        }

        if( !empty( $this->options['support-comments'] ) && $this->options['support-comments'] == 'yes' )
            $args['supports'][] = 'comments';

        register_post_type( 'private-page', $args );
    }

    /**
     * Function that creates the private page for a user
     * @param $user_id the id of the user for which to create the page
     */
    function cp_create_private_page( $user_id ){

        /* check to see if we already have a page for the user */
        $users_private_pages = $this->cp_get_private_page_for_user( $user_id );
        if( !empty( $users_private_pages ) )
            return;

        /* make sure get_userdata() is available at this point */
        if(is_admin()) require_once( ABSPATH . 'wp-includes/pluggable.php' );

        $user = get_userdata( $user_id );
        $display_name = '';
        if( $user ){
            $display_name = ($user->display_name) ? ($user->display_name) : ($user->user_login);
        }

        if( !empty( $this->options['default-page-content'] ) )
            $post_content = $this->options['default-page-content'];
        else
            $post_content = $this->defaults['default-page-content'];

        $private_page = array(
            'post_title'    => $display_name,
            'post_status'   => 'publish',
            'post_type'     => 'private-page',
            'post_author'   => $user_id,
            'post_content'  => $post_content
        );

        // Insert the post into the database
        wp_insert_post( $private_page );
    }

    /**
     * Function that deletes the private page when the user is deleted
     * @param $id the id of the user which page we are deleting
     * @param $reassign
     */
    function cp_delete_private_page( $id, $reassign ){
        $private_page_id = $this->cp_get_private_page_for_user( $id );
        if( !empty( $private_page_id ) ){
            wp_delete_post( $private_page_id, true );
        }
    }

    /**
     * Function that restricts the content only to the author of the page
     * @param $content the content of the page
     * @return mixed
     */
    function cp_restrict_content( $content ){
        global $post;
        if( $post->post_type == 'private-page' ){

            if( !empty( $this->options['restricted-message'] ) )
                $message = $this->options['restricted-message'];
            else
                $message = $this->defaults['restricted-message'];

            if( is_user_logged_in() ){
                if( ( get_current_user_id() == $post->post_author ) || current_user_can('delete_user') ){
                    return $content;
                }
                else return $message;
            }
            else return $message;

        }
        return $content;
    }

    /**
     * Function that adds a link in the user listing in admin area to access the private page
     * @param $actions The actions available on the user listing in admin area
     * @param $user_object The user object
     * @return mixed
     */
    function cp_add_link_to_private_page( $actions, $user_object ){
        $private_page_id = $this->cp_get_private_page_for_user( $user_object->ID );
        if( !empty( $private_page_id ) ){
            $actions['private_page_link'] = "<a class='cp_private_page' href='" . admin_url( "post.php?post=$private_page_id&action=edit") . "'>" . __( 'Private Page', 'client-portal' ) . "</a>";
        }

        return $actions;
    }

    /**
     * Function that creates a private page extra information div
     * @param $content the content of the private page
     * @return mixed
     */
    function cp_add_private_page_info( $content ){
        global $post;
        if ( is_singular('private-page') && is_user_logged_in() ){
            // logout link
            $logout_link = wp_loginout( home_url(), false);

            // author display name. Fallback to username if no display name is set.
            $author_id=$post->post_author;
            $user = get_user_by('id', $author_id);
            $display_name = '';
            if( $user ){
                $display_name = ($user->display_name) ? ($user->display_name) : ($user->user_login);
            }

            $extra_info = "<p class='cp-logout' style='border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; padding: 0.5rem 0; text-align: right'> $logout_link - $display_name </p>";

            return  $extra_info . $content;
        }

        return $content;
    }

    /**
     * Function that creates a shortcode which redirects the user to its private page
     * @param $atts the shortcode attributes
     */
    function cp_shortcode( $atts ){
        if( !is_user_logged_in() ){
            if( !empty( $this->options['portal-log-in-message'] ) )
                $message = $this->options['portal-log-in-message'];
            else
                $message = $this->defaults['portal-log-in-message'];

            return $message;
        }
        else{
            $user_id = get_current_user_id();
            $private_page_id = $this->cp_get_private_page_for_user( $user_id );
            if( $private_page_id ) {
                $private_page_link = get_permalink($private_page_id);
                ?>
                <script>
                    window.location.replace("<?php echo $private_page_link ?>");
                </script>
                <?php
            }
        }
    }

    /**
     * Function that creates the admin settings page under the Users menu
     */
    function cp_add_settings_page(){
        add_users_page( 'Client Portal Settings', 'Client Portal Settings', 'manage_options', 'client_portal_settings', array( $this, 'cp_settings_page_content' ) );
    }

    /**
     * Function that outputs the content for the settings page
     */
    function cp_settings_page_content(){
        /* if the user pressed the generate button then generate pages for existing users */
        if( !empty( $_GET[ 'cp_generate_for_all' ] ) && $_GET[ 'cp_generate_for_all' ] == true ){
            $this->cp_create_private_pages_for_all_users();
        }

        ?>
        <div class="wrap">

            <h2><?php _e( 'Client Portal Settings', 'client-portal'); ?></h2>

            <?php settings_errors(); ?>

            <div class="cl-grid">
                <div class="cl-grid-item">
                    <form method="POST" action="options.php">

                    <?php settings_fields( $this->slug ); ?>

                        <table class="form-table">
                        <tbody>
                            <tr class="scp-form-field-wrapper">
                                <th scope="row"><label class="scp-form-field-label" for="page-slug"><?php echo __( 'Page Slug' , 'client-portal' ) ?></label></th>
                                <td>
                                    <input type="text" class="regular-text" id="page-slug" name="cp-options[page-slug]" value="<?php echo ( isset( $this->options['page-slug'] ) ? esc_attr( $this->options['page-slug'] ) : 'private-page' ); ?>" />
                                    <p class="description"><?php echo __( 'The slug of the pages.', 'client-portal' ); ?></p>
                                </td>
                            </tr>

                            <tr class="scp-form-field-wrapper">
                                <th scope="row"><?php echo __( 'Support Comments' , 'client-portal' ) ?></th>
                                <td>
                                    <label><input type="radio" id="support-comments" name="cp-options[support-comments]" value="no"  <?php if( ( isset( $this->options['support-comments'] ) && $this->options['support-comments'] == 'no' ) || !isset( $this->options['support-comments'] ) ) echo 'checked="checked"' ?> /><?php _e( 'No', 'client-portal' ) ?></label><br />
                                    <label><input type="radio" id="support-comments" name="cp-options[support-comments]" value="yes" <?php if( isset( $this->options['support-comments'] ) && $this->options['support-comments'] == 'yes' ) echo 'checked="checked"' ?> /><?php _e( 'Yes', 'client-portal' ) ?></label>
                                    <p class="description"><?php echo __( 'Add comment support to the private page', 'client-portal' ); ?></p>
                                </td>
                            </tr>

                            <tr class="scp-form-field-wrapper">
                                <th scope="row"><?php echo __( 'Generate pages' , 'client-portal' ) ?></th>
                                <td>
                                    <a class="button" href="<?php echo add_query_arg( 'cp_generate_for_all', 'true', admin_url("/users.php?page=client_portal_settings") ) ?>"><?php _e( 'Generate pages for existing users' ); ?></a>
                                    <p class="description"><?php echo __( 'Generate pages for already existing users.', 'client-portal' ); ?></p>
                                </td>
                            </tr>

                            <tr class="scp-form-field-wrapper">
                                <th scope="row"><label class="scp-form-field-label" for="restricted-message"><?php echo __( 'Restricted Message' , 'client-portal' ) ?></label></th>
                                <td>
                                    <textarea name="cp-options[restricted-message]" id="restricted-message" class="large-text" rows="10"><?php echo ( isset( $this->options['restricted-message'] ) ? esc_textarea( $this->options['restricted-message'] ) : $this->defaults['restricted-message'] ); ?></textarea>
                                    <p class="description"><?php echo __( 'The default message showed on pages that are restricted.', 'client-portal' ); ?></p>
                                </td>
                            </tr>

                            <tr class="scp-form-field-wrapper">
                                <th scope="row"><label class="scp-form-field-label" for="portal-log-in-message"><?php echo __( 'Portal Log In Message' , 'client-portal' ) ?></label></th>
                                <td>
                                    <textarea name="cp-options[portal-log-in-message]" id="portal-log-in-message" class="large-text" rows="10"><?php echo ( isset( $this->options['portal-log-in-message'] ) ? esc_textarea( $this->options['portal-log-in-message'] ) : $this->defaults['portal-log-in-message'] ); ?></textarea>
                                    <p class="description"><?php echo __( 'The default message showed on pages that are restricted.', 'client-portal' ); ?></p>
                                </td>
                            </tr>

                            <tr class="scp-form-field-wrapper">
                                <th scope="row"><label class="scp-form-field-label" for="default-page-content"><?php echo __( 'Default Page Content' , 'client-portal' ) ?></label></th>
                                <td>
                                    <textarea name="cp-options[default-page-content]" id="default-page-content" class="large-text" rows="10"><?php echo ( isset( $this->options['default-page-content'] ) ? esc_textarea( $this->options['default-page-content'] ) : $this->defaults['default-page-content'] ); ?></textarea>
                                    <p class="description"><?php echo __( 'The default content on the private page.', 'client-portal' ); ?></p>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                        <?php submit_button( __( 'Save Settings', 'client_portal_settings' ) ); ?>

                    </form>
                </div>

                <div class="cl-grid-item pb-pitch">
                    <h2>Get the most out of Client Portal</h2>
                    <p>When building a place for your clients to access information, it can take a lot of time simply because there isn't enough flexibility
                    to build exactly what you need.</p>
                    <p>Wouldn't it be nice to be able to build the experience for your clients using simple modules that each does as few things as possible, but well?</p>
                    <p style="text-align: center;"><a href="https://wordpress.org/plugins/profile-builder/"><img src="<?php echo CP_URL; ?>assets/logo_landing_pb_2x_red.png" alt="Profile Builder Logo"/></a></p>
                    <p><strong>Client Portal</strong> was designed to work together with
                        <a href="https://wordpress.org/plugins/profile-builder/"><strong>Profile Builder</strong></a> so you can construct the client experience just as you need it.
                    </p>
                    <ul>
                        <li>add a login form with redirect <br/> <strong>[wppb-login redirect_url="http://www.yourdomain.com/page"]</strong></li>
                        <li>allow users to register <strong>[wppb-register]</strong></li>
                        <li>hide the WordPress admin bar for clients</li>
                    </ul>
                </div>


            </div>

        </div>
    <?php
    }

    /**
     * Function that registers the settings for the settings page with the Settings API
     */
    public function cp_register_settings() {
        register_setting( $this->slug, $this->slug, array( 'sanitize_callback' => array( $this, 'cp_sanitize_options' ) ) );
    }

    /**
     * Function that sanitizes the options of the plugin
     * @param $options
     * @return mixed
     */
    function cp_sanitize_options( $options ){
        if( !empty( $options ) ){
            foreach( $options as $key => $value ){
                if( $key == 'page-slug' || $key == 'support-comments' )
                    $options[$key] = sanitize_text_field( $value );
                elseif( $key == 'restricted-message' || $key == 'portal-log-in-message' )
                    $options[$key] = wp_kses_post( $value );
            }
        }

        return $options;
    }

    /**
     * Function that creates the notice messages on the settings page
     */
    function cp_admin_notices(){
        if( !empty( $_GET['page'] ) && $_GET['page'] == 'client_portal_settings' ) {
            if( !empty( $_GET['cp_generate_for_all'] ) && $_GET['cp_generate_for_all'] == true ) {
                ?>
                <div class="notice notice-success is-dismissible">
                    <p><?php _e( 'Successfully generated private pages for existing users.', 'client-portal'); ?></p>
                </div>
                <?php
                if( !empty( $_REQUEST['settings-updated'] ) && $_GET['settings-updated'] == 'true' ) {
                    ?>
                    <div class="notice notice-success is-dismissible">
                        <p><?php _e( 'Settings saved.', 'client-portal'); ?></p>
                    </div>
                <?php
                }
            }
        }
    }

    /**
     * Function that enqueues the scripts on the admin settings page
     */
    function cp_enqueue_admin_scripts() {
        if( !empty( $_GET['page'] ) && $_GET['page'] == 'client_portal_settings' )
            wp_enqueue_style( 'cp_style-back-end', plugins_url( 'assets/style.css', __FILE__ ) );
    }

    /**
     * Function that flushes the rewrite rules when we save the settings page
     */
    function cp_flush_rules(){
        if( isset( $_GET['page'] ) && $_GET['page'] == 'client_portal_settings' && isset( $_REQUEST['settings-updated'] ) && $_REQUEST['settings-updated'] == 'true' ) {
            flush_rewrite_rules(false);
        }
    }


    /**
     * Function that filters the WHERE clause in the select for adjacent posts so we exclude private pages
     * @param $where
     * @param $in_same_term
     * @param $excluded_terms
     * @param $taxonomy
     * @param $post
     * @return mixed
     */
    function cp_exclude_from_post_navigation( $where, $in_same_term, $excluded_terms, $taxonomy, $post ){
        if( $post->post_type == 'private-page' ){
            $where = str_replace( "'private-page'", "'do not show this'", $where );
        }
        return $where;
    }

    /**
     * Function that returns the id for the private page for the provided user
     * @param $user_id the user id for which we want to get teh private page for
     * @return mixed
     */
    function cp_get_private_page_for_user( $user_id ){
        $args = array(
            'author'            =>  $user_id,
            'posts_per_page'    =>  1,
            'post_type'         => 'private-page',
        );
        $users_private_pages = get_posts( $args );

        if( !empty( $users_private_pages ) ){
            foreach( $users_private_pages as $users_private_page ){
                return $users_private_page->ID;
                break;
            }
        }
        /* we don't have a page */
        return false;
    }

    /**
     * Function that returns all the private pages post objects
     * @return array
     */
    function cp_get_all_private_pages(){
        $args = array(
            'posts_per_page'    =>  -1,
            'numberposts'       =>   -1,
            'post_type'         => 'private-page',
        );

        $users_private_pages = get_posts( $args );
        return $users_private_pages;
    }

    /**
     * Function that creates a custom action in the Bulk Dropdown on the Users screen
     */
    function cp_create_private_page_bulk_actions(){
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('<option>').val('create_private_page').text( '<?php _e( 'Create Private Page', 'client-portal' ) ?>').appendTo("select[name='action'], select[name='action2']");
            });
        </script>
    <?php
    }

    /**
     * Function that creates a private page for the selected users in the bulk action
     */
    function cp_create_private_pages_in_bulk(){
        if ( !empty( $_REQUEST['users'] ) && is_array( $_REQUEST['users'] ) ) {
            $users = array_map( 'absint', $_REQUEST['users'] );
            foreach( $users as $user_id ){
                $this->cp_create_private_page( $user_id );
            }
        }
    }

    /**
     *  Function that creates private pages for all existing users
     */
    function cp_create_private_pages_for_all_users(){
        $all_users = get_users( array(  'fields' => array( 'ID' ) ) );
        if( !empty( $all_users ) ){
            foreach( $all_users as $user ){
                $users_private_pages = $this->cp_get_private_page_for_user( $user->ID );
                if( !$users_private_pages ) {
                    $this->cp_create_private_page( $user->ID );
                }
            }
        }
    }

}

$CP_Object = new CL_Client_Portal();
