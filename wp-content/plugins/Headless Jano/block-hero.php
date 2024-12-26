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
                  'editor_script'   => 'empty-preview', // Specificeer een lege preview
            ));
      }
}