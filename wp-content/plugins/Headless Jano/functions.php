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
        /* Algemene achtergrondkleur voor de loginpagina in dark mode */
        body.login {
            background-color: #121212 !important; /* Donkere achtergrond voor de hele pagina */
            color: #e0e0e0 !important; /* Lichte tekstkleur */
        }

        /* Aangepast logo */
        .login h1 a {
            background-image: url("https://admin.janvanerkel.nl/Jano-be/wp-content/uploads/login-logo.svg") !important;
            background-size: contain !important;
            width: 100% !important;
            height: 80px !important; /* Pas de hoogte aan naar wens */
            background-repeat: no-repeat !important;
            display: block;
            margin: 0 auto;
        }

        /* Stijl voor de login container (formulair) */
        .login form {
            background-color: #1e1e1e !important; /* Donkere achtergrond voor het formulier */
            border-radius: 8px !important;
            padding: 30px !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5) !important; /* Zachte schaduw voor diepte */
        }

        /* Stijl voor de invoervelden */
        .login input[type="text"],
        .login input[type="password"] {
            background-color: #333333 !important; /* Donkere achtergrond voor de velden */
            color: #e0e0e0 !important; /* Lichte tekst in de invoervelden */
            border: 1px solid #555555 !important; /* Lichte rand om velden */
            border-radius: 4px !important;
            padding: 12px 10px !important;
            width: 100% !important;
            font-size: 16px !important;
        }

        /* Stijl voor de login knop (oranje) */
        .login .button-primary {
            background-color: #ff961a !important; /* Oranje achtergrond */
            border-color: #e68800 !important; /* Oranje rand */
            color: #fff !important;
            padding: 12px 20px !important;
            font-size: 16px !important;
            width: 100% !important;
            border-radius: 4px !important;
            transition: background-color 0.3s ease !important;
        }

        .login .button-primary:hover {
            background-color: #e68800 !important; /* Donkerder oranje bij hover */
            border-color: #d77c00 !important;
        }

        .login #nav a,
        .login #backtoblog a {
            color: #ff961a !important; /* Oranje kleur voor links */
            text-decoration: none !important;
        }

        .login #nav a:hover,
        .login #backtoblog a:hover {
            color: #e68800 !important; /* Donkerder oranje bij hover */
        }

        /* Style voor de "Wachtwoord vergeten" link */
        .login #nav {
            text-align: center !important; /* Centraal uitlijnen van de link */
        }

        /* Foutmeldingen of succesberichten */
        .login .error,
        .login .success {
            background-color: #1e1e1e !important;
            color: #f44336 !important; /* Foutmeldingen in rood */
            border-left: 3px solid #f44336 !important; /* Rood accent voor foutmeldingen */
        }
    </style>';
});