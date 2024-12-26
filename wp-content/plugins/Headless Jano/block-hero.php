<?php
function register_hero_block() {
      if ( function_exists( 'acf_register_block' ) ) {
            acf_register_block(array(
                  'name'            => 'heroblock',
                  'title'           => __('Hero Block'),
                  'description'     => __('Een hero block met ACF-velden'),
                  'category'        => 'common',
                  'icon'            => 'superhero',
                  'keywords'        => array( 'hero', 'header' ),
                  'mode' => 'edit',
            ));
      }
}
add_action('acf/init', 'register_hero_block');