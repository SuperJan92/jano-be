<?php
/**
 * Plugin Name: Headless Jano
 * Description: Custom functionality for the headless WordPress backend.
 * Version: 1.0
 * Author: Jan van Erkel
 */

// Redirect de hele site naar de admin loginpagina
add_action('template_redirect', function() {
      // Controleer of de gebruiker niet al op de loginpagina is
      if (!is_admin() && !is_login_page()) {
            wp_redirect(admin_url());
            exit;
      }
});

// Controleer of de gebruiker op de loginpagina is
function is_login_page() {
      return isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false;
}

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

// Voeg het aangepaste logo toe aan de loginpagina
// Voeg het aangepaste logo toe aan de loginpagina
add_action('login_enqueue_scripts', function() {
      // Vervang het logo
      echo '<style>
        .login h1 a {
            background-image: url("https://admin.janvanerkel.nl/Jano-be/wp-content/uploads/login-logo.svg") !important;
            background-size: contain;
            width: 100%;
            height: 80px; /* Pas de hoogte aan naar wens */
            background-repeat: no-repeat;
            display: block; /* Zorgt ervoor dat de link een block-element is */
            margin: 0 auto; /* Zorgt ervoor dat het logo in het midden komt */
        }

        /* Achtergrondkleur voor de loginpagina */
        body.login {
            background-color: #101418;
        }
    </style>';
});