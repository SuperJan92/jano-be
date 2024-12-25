<?php
/**
 * Plugin Name: Headless Jano
 * Description: Custom functionality for the headless WordPress backend.
 * Version: 1.0
 * Author: Jan van Erkel
 */

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(ABSPATH);
$dotenv->load();

$api_key = $_ENV['MY_API_KEY'] ?? null;

// Controleer de API-sleutel voor elke REST API-aanroep
add_action('rest_api_init', function() {
      add_filter('rest_authentication_errors', function($result) {
            // Haal de API-sleutel uit de HTTP headers
            $api_key = isset($_SERVER['HTTP_X_API_KEY']) ? $_SERVER['HTTP_X_API_KEY'] : null;

            // Als er geen API-sleutel is of deze onjuist is, geef een foutmelding terug
            if (!$api_key || $api_key !== $_ENV['MY_API_KEY']) {
                  return new WP_Error('rest_forbidden', 'Forbidden', array('status' => 403));
            }

            return $result; // Geen fout, door naar de REST API
      });
});

// Redirect alle verzoeken naar de admin pagina, behalve de login
add_action('template_redirect', function() {
      if (!is_admin() && !is_login_page()) {
            wp_redirect(admin_url());
            exit;
      }
});

// Functie om te controleren of het de login-pagina is
function is_login_page() {
      return isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false;
}

add_filter('template', function() {
      return '';
});

add_filter('stylesheet', function() {
      return '';
});

function allow_svg_uploads($mimes) {
      $mimes['svg'] = 'image/svg+xml';
      return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');



add_action('admin_menu', function() {
      add_menu_page(
            'Menu Beheer',       // Titel van de pagina
            'Menu\'s',           // Titel in het admin menu
            'manage_options',    // Vereiste capaciteit
            'nav-menus.php',     // Het bestand dat de pagina laadt
            '',                  // Functie om inhoud te laden (leeg laten)
            'dashicons-menu'     // Icon voor het menu
      );
});

add_filter('login_footer', function () {
      ?>
        <style>
            .login #backtoblog {
                display: none;
            }
        </style>
      <?php
});

add_action('login_enqueue_scripts', function() {
      echo '<style>
        body.login {
            background-color: #121212 !important;
            color: #e0e0e0 !important;
        }
        .login h1 a {
            background-image: url("https://admin.janvanerkel.nl/Jano-be/wp-content/uploads/login-logo.svg") !important;
            background-size: contain !important;
            width: 100% !important;
            height: 80px !important;
            background-repeat: no-repeat !important;
            display: block;
            margin: 0 auto;
        }
        .login form {
            background-color: #1e1e1e !important;
            border-radius: 8px !important;
            padding: 30px !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5) !important;
            border: none !important;
        }
        .login input[type="text"],
        .login input[type="password"] {
            background-color: #333333 !important;
            color: #e0e0e0 !important;
            border: 1px solid #555555 !important;
            border-radius: 4px !important;
            padding: 12px 10px !important;
            width: 100% !important;
            font-size: 16px !important;
        }
        .login .button-primary {
            background-color: #ff961a !important;
            border-color: #e68800 !important;
            color: #fff !important;
            padding: 4px !important;
            font-size: 16px !important;
            width: 100% !important;
            border-radius: 4px !important;
            transition: background-color 0.3s ease !important;
        }
        .login .button-primary:hover {
            background-color: #e68800 !important;
            border-color: #d77c00 !important;
        }
        .login #nav a,
        .login #backtoblog a {
            color: #ff961a !important;
            text-decoration: none !important;
        }
        .login #nav a:hover,
        .login #backtoblog a:hover {
            color: #e68800 !important;
        }
        p.forgetmenot {
            margin-bottom: 10px !important;
        }
        .notice.notice-info.message {
            background: #1e1e1e;
            border-left: 4px solid #ff961a;
            border-radius: 4px;
        }
    </style>';
});

add_action('admin_head', function () {
      ?>
        <style>
            #adminmenu li a:hover, .wp-core-ui .button-primary:hover, .wp-core-ui .button:hover {
                background-color: #ff961a !important;
                color: white !important;
            }
            #adminmenu li.current a, #adminmenu li.current a:focus, #adminmenu li.current a:hover {
                background-color: #72aee6 !important;
                color: white !important;
            }
            #adminmenu a:focus, #adminmenu a:hover {
                color: #ff961a !important;
            }
            .update-plugins, .update-now {
                background-color: #ff961a !important;
            }
            #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head, #adminmenu .wp-menu-arrow, #adminmenu .wp-menu-arrow div, #adminmenu li.current a.menu-top, #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu {
                background: #e08417 !important;
                color: #fff !important;
            }
            #adminmenu li.current a, #adminmenu li.current a:focus, #adminmenu li.current a:hover {
                background-color: #2c3338 !important;
                color: white !important;
            }
            .wp-menu-image.dashicons-before::before {
                color: #ffffff !important;
            }
            .wp-core-ui .button-primary {
                background: #ff961a !important;
                border-color: #ff961a !important;
                color: #fff;
                text-decoration: none;
                text-shadow: none;
            }
            a {
                color: #e18417;
            }
            a:hover {
                color: #ff961a;
            }
            .wp-core-ui .button-link {
                color: #ff961a !important;
            }
            a.ab-item:hover, a.ab-item:hover span {
                color: #ff961a !Important;
            }
            a.ab-item:hover span.ab-icon::before {
                color: #ff961a !important;
            }
            a.ab-item:hover::before {
                color: #ff961a !important;
            }
            #adminmenu li a:hover {
                background: #2c3338 !important;
            }
            #wpadminbar #wp-admin-bar-wp-logo {
                display: none;
            }
        </style>
      <?php
});