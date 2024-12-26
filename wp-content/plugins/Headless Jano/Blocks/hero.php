<?php
function register_hero_block() {
      if (function_exists('acf_register_block')) {
            acf_register_block(array(
                  'name'            => 'hero',
                  'title'           => __('Hero Block'),
                  'description'     => __('Een hero block met ACF-velden'),
                  'render_template' => 'template-parts/blocks/hero.php', // Pas aan waar je je block template hebt
                  'category'        => 'common',
                  'icon'            => 'alignfull',
                  'keywords'        => array( 'hero', 'header' ),
            ));
      }
}
add_action('acf/init', 'register_hero_block');