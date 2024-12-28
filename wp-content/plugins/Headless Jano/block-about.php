<?php
function register_hero_block() {
      if ( function_exists( 'acf_register_block' ) ) {
            acf_register_block(array(
                  'name'            => 'aboutblock',
                  'title'           => __('About Block'),
                  'description'     => __('Een block block met afbeelding'),
                  'category'        => 'common',
                  'icon'            => 'superhero',
                  'keywords'        => array( 'hero', 'header' ),
                  'mode'            => 'edit',
            ));
      }
}
add_action('acf/init', 'register_hero_block');