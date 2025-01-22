<?php
function wpdocs_allowed_block_types( $block_editor_context, $editor_context ) {
      if ( ! empty( $editor_context->post ) ) {
            return array(
                  'acf/heroblock',
                  'acf/aboutblock',
            );
      }

      return $block_editor_context;
}

add_filter( 'allowed_block_types_all', 'wpdocs_allowed_block_types', 10, 2 );

// Verwijder de submenu's (Blocks, Patterns, Media) uit de admin sidebar
function remove_gutenberg_admin_menu_items() {
      remove_submenu_page( 'edit.php?post_type=wp_block', 'edit.php?post_type=wp_block' );
      remove_submenu_page( 'edit.php?post_type=wp_pattern', 'edit.php?post_type=wp_pattern' );
      remove_submenu_page( 'upload.php', 'upload.php' );
}
add_action( 'admin_menu', 'remove_gutenberg_admin_menu_items', 999 );

// Verberg de tabjes (Blocks, Patterns, Media) in de Gutenberg editor
function remove_gutenberg_sidebar_tabs($editor_settings) {
      $editor_settings['disableTabs'] = ['blocks', 'patterns', 'media'];
      return $editor_settings;
}
add_filter( 'block_editor_settings_all', 'remove_gutenberg_sidebar_tabs' );

// Verberg de tabjes met CSS
function remove_gutenberg_sidebar_tabs_css() {
      ?>
        <style>
            .block-editor-tabbed-sidebar__tablist {
                display: none !important;
            }
            .block-editor-tabbed-sidebar__tab {
                display: none !important;
            }
        </style>
      <?php
}
add_action( 'admin_head', 'remove_gutenberg_sidebar_tabs_css' );

function get_gutenberg_blocks($data)
{
    $post_id = $data['id'];
    $post = get_post($post_id);
    $blocks = parse_blocks($post->post_content);

    $block_data = [];
    foreach ($blocks as $block) {
        if ($block['blockName']) {
            $block_info = [
                'blockName' => $block['blockName'],
                'content' => $block['innerHTML'],
                'attributes' => $block['attrs'],
            ];

            // Specifieke aanpassing voor 'acf/aboutblock'
            if ($block['blockName'] === 'acf/aboutblock' && !empty($block['attrs']['data']['about_image'])) {
                $image_id = $block['attrs']['data']['about_image'];
                $image_url = wp_get_attachment_image_url($image_id, 'full');

                // Voeg de afbeelding-URL toe
                $block_info['attributes']['data']['about_image_url'] = $image_url;
            }

            $block_data[] = $block_info;
        }
    }

    return $block_data;
}

add_action('rest_api_init', function () {
      register_rest_route('custom/v1', '/blocks/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => 'get_gutenberg_blocks',
            'args' => array(
                  'id' => array(
                        'validate_callback' => function ($param) {
                              return is_numeric($param);
                        }
                  ),
            ),
      ));
});