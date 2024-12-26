<?php
function register_hero_block() {
      if ( function_exists( 'acf_register_block' ) ) {
            acf_register_block(array(
                  'name'            => 'heroblock', // Dit is de naam van je blok
                  'title'           => __('Hero Block'),
                  'description'     => __('Een hero block met ACF-velden'),
                  'render_template' => 'block-hero.php', // Dit is het bestand waarin je blok wordt gerenderd
                  'category'        => 'common',
                  'icon'            => 'alignfull', // Of een ander icoon
                  'keywords'        => array( 'hero', 'header' ),
                  'render_callback' => 'render_hero_block_editor', // Voeg een aangepaste render callback toe
            ));
      }
}
add_action('acf/init', 'register_hero_block');

// Functie voor het weergeven van een blok in de editor
function render_hero_block_editor( $block ) {
      // Zorg ervoor dat je hier een voorbeeld geeft van wat je in de editor wilt tonen
      echo '<div class="hero-block-editor-preview">';
      echo '<h2>Hero Block Preview</h2>';
      echo '<p>Je kunt hier een preview van het hero block tonen.</p>';
      echo '</div>';
}