<?php
function register_hero_block() {
      if ( function_exists( 'acf_register_block' ) ) {
            acf_register_block( array(
                  'name'            => 'acf/heroblock', // Voeg 'acf/' prefix toe
                  'title'           => __('Hero Block'),
                  'description'     => __('Een hero block met ACF-velden'),
                  'category'        => 'common',
                  'icon'            => 'alignfull',
                  'keywords'        => array( 'hero', 'header' ),
            ));
      }
}
add_action( 'acf/init', 'register_hero_block' );