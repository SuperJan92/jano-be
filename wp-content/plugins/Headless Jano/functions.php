<?php
/**
 * Plugin Name: Headless Jano
 * Description: Custom functionality for the headless WordPress backend.
 * Version: 1.0
 * Author: Jan van Erkel
 */

add_action('template_redirect', function() {
      if (!is_admin() && !defined('DOING_AJAX') && !is_user_logged_in()) {
            wp_redirect(site_url('wp-login.php'));
            exit;
      }
});

add_filter('template', function() {
      return '__no_theme__';
});

add_filter('stylesheet', function() {
      return '__no_theme__';
});

// Redirect frontend requests to the admin login page
add_action('template_redirect', function() {
      if (!is_admin()) {
            wp_redirect(admin_url());
            exit;
      }
});