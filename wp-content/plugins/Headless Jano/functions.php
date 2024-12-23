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

// Voeg aangepaste styling toe aan de loginpagina
add_action('login_enqueue_scripts', function() {
      echo '<style>
        /* Algemene achtergrondkleur voor de loginpagina */
        body.login {
            background-color: #101418;
        }

        /* Aangepast logo */
        .login h1 a {
            background-image: url("https://admin.janvanerkel.nl/Jano-be/wp-content/uploads/login-logo.svg");
            background-size: contain;
            width: 100%;
            height: 80px; /* Pas de hoogte aan naar wens */
            background-repeat: no-repeat;
            display: block;
            margin: 0 auto;
        }

        /* Stijl voor de login container */
        .login form {
            background-color: #1b2226; /* Donkere achtergrond voor het formulier */
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        /* Stijl voor de invoervelden */
        .login input[type="text"],
        .login input[type="password"] {
            background-color: #2c353b; /* Donkerder veldachtergrond */
            color: #f1f1f1; /* Witte tekst */
            border: 1px solid #3d464e;
            border-radius: 4px;
            padding: 10px;
            width: 100%;
            font-size: 16px;
        }

        /* Stijl voor de login knop */
        .login .button-primary {
            background-color: #0073aa; /* WordPress-blauw */
            border-color: #006799;
            color: #fff;
            padding: 12px 20px;
            font-size: 16px;
            width: 100%;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .login .button-primary:hover {
            background-color: #006799;
            border-color: #005f8b;
        }

        .login #nav a,
        .login #backtoblog a {
            color: #f1f1f1;
            text-decoration: none;
        }

        .login #nav a:hover,
        .login #backtoblog a:hover {
            color: #0073aa;
        }

        /* Style voor de "Wachtwoord vergeten" link */
        .login .message {
            background-color: #2c353b; /* Zelfde als de invoervelden */
            color: #f1f1f1;
            border-left: 3px solid #0073aa;
        }
    </style>';
});