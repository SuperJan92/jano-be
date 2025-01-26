<?php
function register_custom_blocks() {
      if ( function_exists( 'acf_register_block' ) ) {

            acf_register_block(array(
                  'name'            => 'aboutblock',
                  'title'           => __('About Block'),
                  'description'     => __('Een about block'),
                  'category'        => 'common',
                  'icon'            => 'id',
                  'keywords'        => array( 'hero', 'header' ),
                  'mode'            => 'edit',
            ));

            acf_register_block(array(
                  'name'            => 'heroblock',
                  'title'           => __('Hero Block'),
                  'description'     => __('Een hero block'),
                  'category'        => 'common',
                  'icon'            => 'superhero',
                  'keywords'        => array( 'hero', 'header' ),
                  'mode'            => 'edit',
            ));

            acf_register_block(array(
                  'name'            => 'contactblock',
                  'title'           => __('Contact Block'),
                  'description'     => __('Een contact block'),
                  'category'        => 'common',
                  'icon'            => 'info',
                  'keywords'        => array( 'hero', 'header' ),
                  'mode'            => 'edit',
              ));
      }
}
add_action('acf/init', 'register_custom_blocks');