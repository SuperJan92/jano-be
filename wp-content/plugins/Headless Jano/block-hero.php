<?php
function register_hero_block() {
      if ( function_exists( 'acf_register_block' ) ) {
            // Echo de padlocatie om te zien of het blok correct is ingesteld
            echo '<p>Het pad voor de hero.php is: ' . plugin_dir_path( __FILE__ ) . 'hero.php</p>';

            acf_register_block(array(
                  'name'            => 'heroblock',
                  'title'           => __('Hero Block'),
                  'description'     => __('Een hero block met ACF-velden'),
                  'render_template' => plugin_dir_path( __FILE__ ) . 'hero.php',
                  'category'        => 'common',
                  'icon'            => 'alignfull',
                  'keywords'        => array( 'hero', 'header' ),
            ));
      }
}
add_action('acf/init', 'register_hero_block');