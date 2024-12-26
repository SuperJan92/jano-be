<?php
function register_hero_block() {
      if ( function_exists( 'acf_register_block' ) ) {
            acf_register_block(array(
                  'name'            => 'heroblock',
                  'title'           => __('Hero Block'),
                  'description'     => __('Een hero block met ACF-velden'),
                  'render_template' => 'block-hero.php',
                  'category'        => 'common',
                  'icon'            => 'alignfull',
                  'keywords'        => array( 'hero', 'header' ),
                  'editor_script'   => 'empty-preview', // Specificeer een lege preview
            ));
      }
}
add_action('acf/init', 'register_hero_block');

function empty_preview_script() {
      ?>
      <script>
          wp.blocks.registerBlockType('acf/heroblock', {
              title: 'Hero Block',
              icon: 'alignfull',
              category: 'common',
              edit: function() {
                  return wp.element.createElement(
                      'p',
                      {},
                      ' ' // Lege inhoud voor de preview
                  );
              },
          });
      </script>
      <?php
}

add_action('admin_footer', 'empty_preview_script');