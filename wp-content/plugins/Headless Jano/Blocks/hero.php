<?php
// Register de REST API route
function register_hero_rest_route() {
      register_rest_route('my_namespace/v1', '/hero/', array(
            'methods' => 'GET',
            'callback' => 'get_hero_block',
      ));
}

// Haal de ACF velden op
function get_hero_block() {
      $hero_title = get_field('hero_title', 'option');
      $hero_text = get_field('hero_text', 'option');

      return rest_ensure_response(array(
            'hero_title' => $hero_title,
            'hero_text' => $hero_text,
      ));
}

// Voeg de registratie toe aan 'rest_api_init' hook
add_action('rest_api_init', 'register_hero_rest_route');