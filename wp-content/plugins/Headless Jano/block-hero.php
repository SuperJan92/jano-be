<?php
function register_hero_block() {
      if ( function_exists( 'acf_register_block' ) ) {
            acf_register_block(array(
                  'name'            => 'heroblock',
                  'title'           => __('Hero Blockk'),
                  'description'     => __('Een hero block met ACF-velden'),
                  'render_template' => 'block-hero.php', // Dit is het bestand voor jouw block-rendering
                  'category'        => 'common',
                  'icon'            => 'alignfull', // Kies een icoon
                  'keywords'        => array( 'hero', 'header' ),
                  'render_callback' => 'render_hero_block_editor', // De render callback om preview te tonen
            ));
      }
}
add_action('acf/init', 'register_hero_block');

// Lege callback voor het verbergen van de preview
function render_hero_block_editor( $block ) {
      // Leeg laten zodat geen preview wordt getoond
      echo '<div class="hero-block-preview"></div>';
}