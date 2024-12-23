<?php
/**
 * Plugin Name: headless-jano
 * Description: Custom functionality for the headless WordPress backend.
 * Version: 1.0
 * Author: Jan van Erkel
 */

/*
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

// Verwijder het Appearance menu-item
add_action('admin_menu', function () {
      remove_menu_page('themes.php'); // Verwijdert het "Weergave" menu
});

// Verwijder de "Go to [sitenaam]" link op de loginpagina
add_filter('login_footer', function () {
      ?>
      <style>
          .login #backtoblog {
              display: none;
          }
      </style>
      <?php
});
*/
// Voeg het custom logo toe aan de loginpagina
add_action('login_enqueue_scripts', function () {
      ?>
        <style>
            .login h1 a {
                background-image: url('<?php echo content_url('headless/jano/media/login-logo.svg'); ?>');
                background-size: contain; /* Zorg dat het logo goed schaalt */
                background-repeat: no-repeat; /* Zorg dat het logo niet herhaald wordt */
                width: 200px; /* Pas de breedte van het logo aan */
                height: 80px; /* Pas de hoogte van het logo aan */
                margin-bottom: 20px; /* Optioneel: extra ruimte onder het logo */
            }
        </style>
      <?php
});