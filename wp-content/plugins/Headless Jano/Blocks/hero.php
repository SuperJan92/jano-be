<?php
echo 'aaaa';
function register_hero_block() {
      // Controleer of ACF aanwezig is
      if( function_exists('acf_register_block') ) {
            acf_register_block(array(
                  'name'            => 'hero',
                  'title'           => __('Hero Block'),
                  'description'     => __('Een hero block met ACF-velden'),
                  'render_template' => '', // Geen template renderen, wordt later ingevuld via ACF
                  'category'        => 'common',
                  'icon'            => 'alignfull',
                  'keywords'        => array( 'hero', 'header' ),
            ));
      }
}
add_action('acf/init', 'register_hero_block');