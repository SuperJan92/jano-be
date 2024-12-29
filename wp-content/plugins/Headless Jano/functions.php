<?php
/**
 * Plugin Name: Headless Jano
 * Description: Custom functionality for the headless WordPress backend.
 * Version: 1.0
 * Author: Jan van Erkel
 */

require_once __DIR__ . '/vendor/autoload.php'; // Zorg ervoor dat je Composer autoload gebruikt voor eventuele dependencies zoals Dotenv.

use Dotenv\Dotenv;

// Laad de .env file
$dotenv = Dotenv::createImmutable(ABSPATH);
$dotenv->load();

// Haal de API key op uit het .env bestand, of gebruik een fallback als deze niet is gedefinieerd
$api_key = $_ENV['MY_API_KEY'] ?? null;

// Functie om API sleutel te controleren
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

// Voeg de API key verificatie toe aan de REST API voor specifieke endpoints
add_action('rest_api_init', function() {
      add_filter('rest_pre_dispatch', function($response, $server, $request) {
            // Alleen de check uitvoeren voor REST API-aanroepen als de gebruiker niet is ingelogd
            check_api_key();
            return $response;
      }, 10, 3);
});

// Voeg de functionaliteit voor het ophalen van menu's toe
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

// Voeg menu's toe aan de REST API
add_filter('rest_endpoints', function($endpoints) {
      $endpoints['/wp/v2/menus'] = [
            'methods' => 'GET',
            'callback' => 'get_menus_for_api',
            'permission_callback' => '__return_true', // Openbaar maken
      ];
      return $endpoints;
});

// Zorg ervoor dat de menu's correct kunnen worden weergegeven
add_theme_support('menus'); // Zorg ervoor dat menu's werken in WordPress

// Functie om de Netlify build te triggeren
add_action('save_post', 'trigger_netlify_build', 10, 3);
function trigger_netlify_build($post_id, $post, $update) {
      // Controleer of het een bericht is en of de post gepubliceerd is
      if ('post' === $post->post_type && $update) {
            // Haal de Netlify Webhook URL op uit de .env
            $webhook_url = $_ENV['NETLIFY_WEBHOOK_URL'];

            // Zorg ervoor dat de URL beschikbaar is
            if (!empty($webhook_url)) {
                  // Verstuur de webhook naar Netlify om de build te triggeren
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

// Verwijder het standaard WordPress login-scherm en voeg je eigen stijl toe
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

// Hiermee geef je de mogelijkheid om SVG-bestanden te uploaden
function allow_svg_uploads($mimes) {
      $mimes['svg'] = 'image/svg+xml';
      return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

// Functie om de custom login pagina aan te passen
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
    </style>';
});