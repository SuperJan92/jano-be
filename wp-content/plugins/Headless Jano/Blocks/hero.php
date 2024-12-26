<?php
add_filter('allowed_block_types_all', function($allowed_blocks, $block_editor_context) {
      // Controleer of we in de blokeditor zijn
      if (!empty($block_editor_context->post)) {
            return [
                  'custom/hero', // Voeg hier je eigen blokken toe
                  'custom/ander-block', // Voeg meer blokken toe als je wilt
            ];
      }

      return $allowed_blocks;
}, 10, 2);
add_action('init', function() {
      register_block_type('custom/hero', array(
            'attributes' => array(
                  'title' => array('type' => 'string', 'default' => 'Welkom op mijn site!'),
                  'subtitle' => array('type' => 'string', 'default' => 'Dit is een ondertitel.'),
                  'backgroundImage' => array('type' => 'string', 'default' => ''),
            ),
            'render_callback' => 'render_hero_block',
      ));
});

// De render_callback is hier optioneel voor een headless setup
function render_hero_block($attributes) {
      // Data alleen formatteren voor de REST API
      return json_encode($attributes);
}
?>