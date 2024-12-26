<?php
echo 'HAfdkljshflkjsdhO';
function register_hero_block() {
      if ( function_exists( 'acf_register_block' ) ) {
            acf_register_block(array(
                  'name'            => 'hero-block', // Hier gebruik je een specifieke naam die niet conflicteert
                  'title'           => __('Hero Block'),
                  'description'     => __('Een hero block met ACF-velden'),
                  'render_template' => 'hero.php', // Zorg ervoor dat dit pad klopt
                  'category'        => 'common',
                  'icon'            => 'alignfull',
                  'keywords'        => array( 'hero', 'header' ),
            ));
      }
}
add_action('acf/init', 'register_hero_block');