<?php
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