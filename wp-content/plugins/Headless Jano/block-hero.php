<?php
function register_hero_block() {
      if ( function_exists( 'acf_register_block' ) ) {
            acf_register_block(array(
                  'name'            => 'heroblock', // Dit is de naam van je blok
                  'title'           => __('Hero Block'),
                  'description'     => __('Een hero block met ACF-velden'),
                  'category'        => 'common',
                  'icon'            => 'superhero', // Of een ander icoon
                  'keywords'        => array( 'hero', 'header' ),
            ));
      }
}
add_action('acf/init', 'register_hero_block');