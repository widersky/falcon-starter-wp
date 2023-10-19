<?php

  class Customizer {

    public function disable_gutenberg_editor () : void {
      add_filter('use_block_editor_for_post', '__return_false');
    }

    public function enable_wp_feature ( string $feature_slug ) : void {
      add_theme_support($feature_slug);
    }

    /**
     * Disable default gutenberg blocks styles (- ~79KB)
     *
     * @return void
     */
    public function disable_gutenberg_styles (): void
    {
      add_action('wp_print_styles', function () {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style');             // Remove WooCommerce blocks CSS
        wp_dequeue_style('global-styles');              // Remove theme.json
      }, 100);
    }


    /**
     * Disable XML-RPC
     *
     * @return void
     */
    public function disable_xml_rpc (): void
    {
      add_filter('xmlrpc_enabled', '__return_false');
      remove_action('wp_head', 'rsd_link');
      remove_action('wp_head', 'wlwmanifest_link');
    }


    /**
     * Remove WP Embed from footer
     *
     * @return void
     */
    public function disable_wp_embed (): void
    {
      add_action('wp_footer', function () {
        wp_deregister_script('wp-embed');
      });
    }


    /**
     * Remove emojis from WP frontend (-18KB)
     *
     * @return void
     */
    public function disable_emojis (): void
    {
      remove_action('wp_head', 'print_emoji_detection_script', 7);
      remove_action('admin_print_scripts', 'print_emoji_detection_script');
      remove_action('wp_print_styles', 'print_emoji_styles');
      remove_action('admin_print_styles', 'print_emoji_styles');
      remove_filter('the_content_feed', 'wp_staticize_emoji');
      remove_filter('comment_text_rss', 'wp_staticize_emoji');
      remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
      add_filter('emoji_svg_url', '__return_false');
      add_filter('tiny_mce_plugins', function ( $plugins ) {
        return array_diff($plugins, ['wpemoji']);
      });
    }


    /**
     * Clean head section from unnecessary code
     *
     * @return void
     */
    public function clean_mess_in_head (): void
    {
      remove_action('wp_head', 'rsd_link');                                   // Windows Live Writer remove
      remove_action('wp_head', 'wlwmanifest_link');                           // Windows Live Writer remove
      remove_action('wp_head', 'wp_generator');                               // Remove WP version
      remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);                // removes rel=shortlink from head that google ignores
      remove_action('template_redirect', 'wp_shortlink_header', 11, 0);
      // remove_action('wp_head', 'feed_links', 2);                              // remove RSS feed links
      // remove_action('wp_head', 'feed_links_extra', 3);                        // removes all extra RSS feed links
      remove_action('wp_head', 'index_rel_link');                             // remove link to index page
      remove_action('wp_head', 'start_post_rel_link', 10, 0);                 // remove random post link
      remove_action('wp_head', 'parent_post_rel_link', 10, 0);                // remove parent post link
      remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);             // remove the next and previous post links

      add_filter('the_generator', function () {
        return '';
      });

      // add_action('template_redirect', function () {
      //   if ( !is_feed() || is_404() ) {
      //     return;
      //   }
      //   if ( isset ($_GET ['feed']) ) {
      //     wp_redirect(esc_url_raw(remove_query_arg('feed')), 301);
      //     exit;
      //   }
      //   if ( get_query_var('feed') !== 'old' ) {
      //     set_query_var('feed', '');
      //   }
      //   redirect_canonical();
      //   wp_die(sprintf(__("RSS Feeds disabled, please visit the <a href='%s'>homepage</a>!"), esc_url(home_url('/'))));
      // }, 1);
    }


    public function move_scripts_to_footer (): void
    {
      add_action('init', function () {
        remove_action('wp_head', 'wp_print_scripts');
        remove_action('wp_head', 'wp_print_head_scripts', 9);
        add_action('wp_footer', 'wp_print_scripts', 5);
        add_action('wp_footer', 'wp_print_head_scripts', 5);
      });
    }


    public function clean_admin_panel (): void
    {
      // Remove unnecessary menu items from dashboard
      add_action('admin_menu', function () {
        remove_menu_page('edit-comments.php');
        remove_menu_page('tools.php');
        remove_submenu_page('plugins.php', 'plugin-editor.php');
        remove_submenu_page('themes.php', 'theme-editor.php');
        remove_submenu_page('themes.php', 'customize.php?return=%2Fwp-admin%2Fthemes.php');
        remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');

        // Remove ACF builder page for users other than superadmin
        if ( is_admin() && get_current_user_id() != '1' ) {
          remove_menu_page('edit.php?post_type=acf-field-group');
        }
      }, 999);

      add_filter('contextual_help_list', function () {
        global $current_screen;
        $current_screen -> remove_help_tabs();
      });

      add_filter('admin_footer_text', '__return_empty_string', 11);

      // Remove unnecessary widgets from dashboard admin menu bar
      add_action('admin_bar_menu', function ( $wp_admin_bar ) {
        global $wp_admin_bar;

        $wp_admin_bar -> remove_node('wp-logo');
        $wp_admin_bar -> remove_node('comments');
        $wp_admin_bar -> remove_node('updates');
        $wp_admin_bar -> remove_node('appearance');
      }, 999);

      add_action('wp_dashboard_setup', function () {
        remove_meta_box('dashboard_quick_press', 'dashboard', 'side');      // Quick Press widget
        remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');    // Recent Drafts
        remove_meta_box('dashboard_primary', 'dashboard', 'side');          // WordPress.com Blog
        remove_meta_box('dashboard_secondary', 'dashboard', 'side');        // Other WordPress News
        remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal'); // Incoming Links
        remove_meta_box('dashboard_right_now', 'dashboard', 'normal');      // Right Now
        remove_meta_box('dashboard_activity', 'dashboard', 'normal');       // Activity
        remove_action('welcome_panel', 'wp_welcome_panel');                 // Remove Welcome Panel
      });
    }


    public function disable_pre_ping (): void
    {
      add_filter('pre_ping', '__return_false');
    }

    public function disable_capital_p_dangit (): void
    {
      remove_filter('the_content', 'capital_P_dangit', 11);
      remove_filter('the_title', 'capital_P_dangit', 11);
      remove_filter('comment_text', 'capital_P_dangit', 31);
    }


    public function disable_versions_in_assets (): void
    {
      add_filter('script_loader_src', function ( $src ) {
        return remove_query_arg('ver', $src);
      }, 15, 1);

      add_filter('style_loader_src', function ( $src ) {
        return remove_query_arg('ver', $src);
      }, 15, 1);
    }


    public function disable_file_editing (): void
    {
      if ( !defined('DISALLOW_FILE_EDIT') ) {
        define('DISALLOW_FILE_EDIT', true);
      }
    }

    public function disable_remote_block_patterns (): void
    {
      add_filter('should_load_remote_block_patterns', function () {
        return false;
      });
    }

    public function disable_duotone_svgs (): void
    {
      add_action('after_setup_theme', function () {
        remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
        remove_action('in_admin_header', 'wp_global_styles_render_svg_filters');
      }, 10, 0);
    }

  }
