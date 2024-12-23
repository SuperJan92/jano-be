<?php
/**
 * Plugin Name: headless-jano
 * Description: Custom functionality for the headless WordPress backend.
 * Version: 1.0
 * Author: Jan van Erkel
 */

add_filter('template', function() {
      return '__no_theme__';
});

add_filter('stylesheet', function() {
      return '__no_theme__';
});

// SVG-bestanden toestaan in WordPress Media Library
function allow_svg_uploads($mimes) {
      $mimes['svg'] = 'image/svg+xml';
      return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

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

// Voeg het custom logo toe aan de loginpagina
add_action('login_enqueue_scripts', function () {
      ?>
        <style>
            .login h1 a {
                background-image: url('<?php echo esc_url( home_url( '/wp-content/uploads/login-logo.svg' ) ); ?>');
                background-size: contain;
                background-repeat: no-repeat;
                width: 200px;
                height: 80px;
                margin-bottom: 20px;
            }
        </style>
      <?php
});