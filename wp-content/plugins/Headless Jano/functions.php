<?php
/**
 * Plugin Name: Headless Jano
 * Description: Custom functionality for the headless WordPress backend.
 * Version: 1.0
 * Author: Jan van Erkel
 */

require_once __DIR__ . '/vendor/autoload.php'; // Zorg ervoor dat Composer autoloader is ingeladen

use Dotenv\Dotenv;

// Controleer of Dotenv geladen is
if (class_exists('Dotenv\Dotenv')) {
      echo 'Dotenv is geladen!';
} else {
      echo 'Dotenv is niet geladen!';
}

if (file_exists(ABSPATH . '.env')) {
      echo '.env bestand gevonden!';
} else {
      echo '.env bestand niet gevonden!';
}

// Laad het .env bestand vanuit de root van de WordPress installatie
$dotenv = Dotenv::createImmutable(ABSPATH);
$dotenv->load();

$api_key = getenv('MY_API_KEY'); // Lees de API-sleutel uit .env bestand

// Log de API-sleutel naar de debug.log
if ($api_key) {
      add_action('admin_footer', function() use ($api_key) {
            ?>
              <script type="text/javascript">
                  alert("API Key Loaded: <?php echo esc_js($api_key); ?>");
              </script>
            <?php
      });
} else {
      add_action('admin_footer', function() {
            ?>
              <script type="text/javascript">
                  alert("API Key is not set or not found!");
              </script>
            <?php
      });
}

// Zorg ervoor dat je debugging aanzet
if ( ! defined( 'WP_DEBUG' ) ) {
      define( 'WP_DEBUG', true );
}

if ( ! defined( 'WP_DEBUG_LOG' ) ) {
      define( 'WP_DEBUG_LOG', true );
}

if ( ! defined( 'WP_DEBUG_DISPLAY' ) ) {
      define( 'WP_DEBUG_DISPLAY', false ); // Fouten niet op de pagina tonen
}

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
        border: none !important;
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
        padding: 4px !important; /* Aangepaste padding */
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

    /* Specifieke stijl voor de forgetmenot paragraph */
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

// Voeg aangepaste CSS toe aan het WordPress-dashboard
add_action('admin_head', function () {
      ?>
        <style>
            #adminmenu li a:hover, .wp-core-ui .button-primary:hover, .wp-core-ui .button:hover {
                background-color: #ff961a !important;
                color: white !important;
            }

            #adminmenu li.current a, #adminmenu li.current a:focus, #adminmenu li.current a:hover {
                background-color: #72aee6 !important; /* Of je kunt dit aanpassen naar een andere kleur */
                color: white !important;
            }

            /* Pas de kleur van de links in het dashboard aan */
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

$api_key = getenv('MY_API_KEY');
echo 'API Key: ' . $api_key;