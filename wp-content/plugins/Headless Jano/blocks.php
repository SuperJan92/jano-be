<?php
function register_custom_blocks() {
      if ( function_exists( 'acf_register_block' ) ) {
            // Registratie van About Block
            acf_register_block(array(
                  'name'            => 'aboutblock',
                  'title'           => __('About Block'),
                  'description'     => __('Een block block met afbeelding'),
                  'category'        => 'common',
                  'icon'            => 'id',
                  'keywords'        => array( 'hero', 'header' ),
                  'mode'            => 'edit',
            ));

            // Registratie van Hero Block
            acf_register_block(array(
                  'name'            => 'heroblock',
                  'title'           => __('Hero Block'),
                  'description'     => __('Een hero block met ACF-velden'),
                  'category'        => 'common',
                  'icon'            => 'superhero',
                  'keywords'        => array( 'hero', 'header' ),
                  'mode'            => 'edit',
            ));
      }
}
add_action('acf/init', 'register_custom_blocks');