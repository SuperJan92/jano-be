<?php

function disable_all_gutenberg_blocks_except_own( $allowed_blocks ) {
      return array( 'heroo' ); // Zorg ervoor dat dit overeenkomt met de naam die je in acf_register_block gebruikt
}
add_filter( 'allowed_block_types_all', 'disable_all_gutenberg_blocks_except_own' );

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