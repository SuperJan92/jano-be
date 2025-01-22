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

// Haal de API key op uit het .env bestand, of gebruik een fallback als deze niet is gedefinieerd
$api_key = $_ENV['MY_API_KEY'] ?? null;

function check_api_key() {
      // Controleer of het verzoek een REST API-verzoek is
      if (defined('REST_REQUEST') && REST_REQUEST) {
            // Als de gebruiker ingelogd is, doe de API-key check dan niet
            if (!is_user_logged_in()) {
                  // Haal de API key op uit de custom header 'X-API-KEY'
                  $api_key = $_SERVER['HTTP_X_API_KEY'] ?? '';

                  // Controleer of de API key klopt
                  if ($api_key !== $_ENV['MY_API_KEY']) {
                        wp_send_json_error(['message' => 'Unauthorized, invalid API key.'], 401); // Stuur een 401 fout als de sleutel ongeldig is
                  }
            }
      }
}

add_action('rest_api_init', function() {
      // Voeg de API key verificatie toe aan de REST API voor specifieke endpoints
      add_filter('rest_pre_dispatch', function($response, $server, $request) {
            // Alleen de check uitvoeren voor REST API-aanroepen als de gebruiker niet is ingelogd
            check_api_key();
            return $response;
      }, 10, 3);
});

add_action('save_post', 'trigger_netlify_build', 10, 3);

function trigger_netlify_build($post_id, $post, $update) {
    // Controleer of het een bericht of pagina is, en of het een update betreft
    if (in_array($post->post_type, ['post', 'page'], true) && $update) {
        $webhook_url = $_ENV['NETLIFY_WEBHOOK_URL'] ?? '';

        if (!empty($webhook_url)) {
            wp_remote_post($webhook_url, [
                'method'    => 'POST',
                'body'      => json_encode(['trigger' => 'post_update']),
                'headers'   => [
                    'Content-Type' => 'application/json',
                ],
            ]);
        }
    }
}

// Zorg ervoor dat de standaard WordPress backend geen restricties heeft
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

add_action('admin_menu', function () {
      remove_menu_page('themes.php');
});

// Voeg ondersteuning voor menu's toe
add_theme_support('menus');

// Voeg ondersteuning voor widgets toe
add_theme_support('widgets');

// Verberg de "Manage with Live Preview" knop
add_action('admin_footer', function() {
      ?>
      <script type="text/javascript">
          document.addEventListener('DOMContentLoaded', function() {
              var livePreviewButton = document.querySelector('.page-title-action.hide-if-no-customize');
              if (livePreviewButton) {
                  livePreviewButton.style.display = 'none';
              }
          });
      </script>
      <?php
});

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

add_action('admin_menu', function() {
    add_submenu_page(
        'upload.php',           // Slug van het parent menu (Media)
        'Media Overzicht',      // Titel van de subpagina
        'Media Overzicht',      // Titel die in het submenu verschijnt
        'upload_files',         // Vereiste rechten
        'upload.php',           // Slug van de pagina
        ''                      // Callback (geen extra inhoud nodig)
    );
});

add_action('admin_menu', function () {
      // Verwijder het "Comments" menu
      remove_menu_page('edit-comments.php');

      // Verplaats het "Menu's" item naar een hogere positie
      global $menu;

      // Haal het 'Menu's' item uit de array
      $menus = array();
      foreach ($menu as $key => $item) {
            if ($item[2] === 'nav-menus.php') {
                  $menus[] = $menu[$key];
                  unset($menu[$key]);
            }
      }

      // Voeg het 'Menu's' item opnieuw toe op de gewenste positie
      array_splice($menu, 2, 0, $menus); // Dit plaatst 'Menu's' op de tweede positie in het menu
}, 10);

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

include_once(plugin_dir_path(__FILE__) . 'blocks.php');
include_once( plugin_dir_path( __FILE__ ) . 'gutenberg.php' );

function add_menu_to_rest_api() {
      register_rest_route('wp/v2', '/menus', array(
            'methods' => 'GET',
            'callback' => 'get_menus_for_api',
            'permission_callback' => '__return_true', // Openbaar maken
      ));
}

// Functie om menu's beschikbaar te maken in de REST API
function get_menus_for_api() {
      $menus = wp_get_nav_menus(); // Haalt alle menu's op
      $menu_data = [];

      foreach ($menus as $menu) {
            $menu_data[] = [
                  'id'   => $menu->term_id,
                  'name' => $menu->name,
                  'slug' => $menu->slug,
            ];
      }

      return $menu_data; // Retourneer de lijst van menu's
}

// Registreer de REST API route voor het ophalen van menu's
add_action('rest_api_init', function() {
      register_rest_route('wp/v2', '/menus', [
            'methods' => 'GET',
            'callback' => 'get_menus_for_api',
            'permission_callback' => '__return_true', // Openbaar maken
      ]);
});

// Functie voor het ophalen van de menu-items
function get_menu_items_for_api(WP_REST_Request $request) {
      $menu_id = $request->get_param('id');
      $menu_items = wp_get_nav_menu_items($menu_id);
      $menu_items_data = [];

      foreach ($menu_items as $item) {
            $menu_items_data[] = [
                  'id'    => $item->ID,
                  'title' => $item->title,
                  'url'   => $item->url,
            ];
      }

      return $menu_items_data;
}

// Registreer de REST API route voor menu-items
add_action('rest_api_init', function() {
      register_rest_route('wp/v2', '/menus/(?P<id>\d+)/items', [
            'methods' => 'GET',
            'callback' => 'get_menu_items_for_api',
            'permission_callback' => '__return_true', // Openbaar maken
      ]);
});

// API Customizations
add_filter('rest_prepare_block', function ($response, $block, $request) {
    $log_file = __DIR__ . '/api_calls.log'; // Logbestand
    file_put_contents($log_file, "[rest_prepare_block] Filter triggered.\n", FILE_APPEND);

    // Rest van de code
}, 10, 3);