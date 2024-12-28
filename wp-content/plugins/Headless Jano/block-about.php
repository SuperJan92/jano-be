<?php
function register_hero_block() {
      if ( function_exists( 'acf_register_block' ) ) {
            acf_register_block(array(
                  'name'            => 'aboutblock',
                  'title'           => __('About Block'),
                  'description'     => __('About text en image'),
                  'category'        => 'common',
                  'icon'            => 'id',
                  'keywords'        => array( 'about' ),
                  'mode'            => 'edit',
            ));
      }
}
add_action('acf/init', 'register_hero_block');