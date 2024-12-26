<?php
// Functie om het hero blok te registreren
function register_hero_block() {
      // Controleer of ACF beschikbaar is
      if( function_exists('acf_register_block') ) {
            acf_register_block(array(
                  'name'            => 'hero',
                  'title'           => __('Hero Block'),
                  'description'     => __('Een hero block met ACF-velden'),
                  'render_template' => 'path_to_your_template.php', // Geef hier de juiste pad naar je template
                  'category'        => 'common',
                  'icon'            => 'alignfull',
                  'keywords'        => array( 'hero', 'header' ),
            ));
      }
}

// Zorg ervoor dat de functie geladen wordt bij de juiste hook
add_action('acf/init', 'register_hero_block');