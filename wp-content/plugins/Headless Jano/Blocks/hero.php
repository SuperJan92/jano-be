<?php
function register_acf_block_types() {
      // Hero Block
      acf_register_block_type(array(
            'name'              => 'hero',
            'title'             => __('Hero Block'),
            'description'       => __('Een Hero block met een titel en tekst'),
            'render_template'   => plugin_dir_path(__FILE__) . 'blocks/hero.php',
            'category'          => 'formatting',
            'icon'              => 'editor-alignleft', // Je kunt hier ook een icon kiezen
            'keywords'          => array('hero', 'intro', 'cover'),
      ));
}

add_action('acf/init', 'register_acf_block_types');