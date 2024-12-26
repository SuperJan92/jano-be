<?php
// Registreer het Hero block
function register_hero_block() {
      // Zorg ervoor dat Gutenberg beschikbaar is
      if( ! function_exists('register_block_type') ) {
            return;
      }

      // Registreer het block zonder render callback
      register_block_type('my_namespace/hero', array(
            'editor_script' => 'hero-block-editor',  // Dit is je editor script als je dat gebruikt
            'category' => 'common',                   // Je kunt dit aanpassen aan de gewenste categorie in Gutenberg
            'icon' => 'star-filled',                  // Je kunt hier een ander icoon gebruiken
            'keywords' => array( 'hero', 'intro' ),  // Dit zijn de zoekwoorden in de editor
      ));
}

// Voeg de registratie toe aan de init hook
add_action('init', 'register_hero_block');