<?php
/**
 * Plugin Name: Headless Jano
 * Description: Custom functionality for the headless WordPress backend.
 * Version: 1.0
 * Author: Jan van Erkel
 */

// Zet een leeg thema in, zodat WordPress geen thema probeert te laden
add_filter('template', function() {
      return '';
});

add_filter('stylesheet', function() {
      return '';
});

// SVG-bestanden toestaan in de WordPress Media Library
function allow_svg_uploads($mimes) {
      $mimes['svg'] = 'image/svg+xml';
      return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

// Verwijder het "Weergave" menu-item in het admin-dashboard
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
<