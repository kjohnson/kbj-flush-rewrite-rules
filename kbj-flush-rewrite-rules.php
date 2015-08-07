<?php if ( ! defined( 'ABSPATH' ) ) exit;

/*
Plugin Name: Flush Rewrite Rules
Description: Adds a quick tool to manually flush the rewrite rules.
Version: 1.0.0

Author: Kyle B. Johnson
Author URI: http://kylebjohnson.me/
*/

final class KBJ_FlushRewriteRules
{
  const SLUG = 'kbj-flush-rewrite-rules';

  public function __construct()
  {
    add_action( 'init', array( $this, 'flush_rewrite_rules') );
    add_action( 'admin_menu', array( $this, 'register_submenu_page' ) );
    add_action( 'admin_notices', array( $this, 'admin_notice' ) );
  }

  /**
   * Register Submenu Page
   *
   * Adds a submenu page under the `tools.php` menu page.
   */
  public function register_submenu_page()
  {
    $parent_slug = 'tools.php';
    $page_title  = __( 'Flush Rewrite Rules' );
    $menu_title  = __( 'Flush Rewrite Rules' );
    $capability  = 'manage_options';
    $menu_slug   = self::SLUG;

    add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug );
  }

  /**
   * Flush Rewrite Rules
   *
   * A wrapper for the WordPress flush_rewrite_rules() function.
   * Redirects to the admin index with query string flag for the admin notice.
   */
  public function flush_rewrite_rules()
  {
    if( $_GET['page'] && self::SLUG == $_GET['page']){

      flush_rewrite_rules();

      wp_redirect( admin_url( '?kbj-flush-rewrite-rules=true' ) );
      exit;
    }
  }

  /**
   * Admin Notice
   *
   * Adds an admin notice if the Rewrite Rules were successfully flushed.
   */
  public function admin_notice()
  {
      if( $_GET[ self::SLUG ] ){
        ?>
        <div class="updated">
            <p><?php _e( 'Rewrite Rules were Flushed' ); ?></p>
        </div>
        <?php
      }
  }

}

// Self instatiate the KBJ_FlushRewriteRules Class.
new KBJ_FlushRewriteRules();
