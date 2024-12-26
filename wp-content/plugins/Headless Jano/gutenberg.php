<?php
// Alleen je eigen blokken toestaan in de editor
function disable_all_gutenberg_blocks_except_own( $allowed_blocks ) {
      return array(
            'my-plugin/hero', // Voeg hier je eigen blokken toe
      );
}
add_filter( 'allowed_block_types_all', 'disable_all_gutenberg_blocks_except_own' );

// Verwijder de submenu's (Blocks, Patterns, Media) uit de admin sidebar
function remove_gutenberg_admin_menu_items() {
      // Verwijder de submenu's uit de admin sidebar
      remove_submenu_page( 'edit.php?post_type=wp_block', 'edit.php?post_type=wp_block' ); // Blokken
      remove_submenu_page( 'edit.php?post_type=wp_pattern', 'edit.php?post_type=wp_pattern' ); // Patronen
      remove_submenu_page( 'upload.php', 'upload.php' ); // Media
}
add_action( 'admin_menu', 'remove_gutenberg_admin_menu_items', 999 );

// Verberg de tabjes (Blocks, Patterns, Media) in de Gutenberg editor
function remove_gutenberg_sidebar_tabs($editor_settings) {
      // Verberg de tabjes voor Blocks, Patterns en Media
      $editor_settings['disableTabs'] = ['blocks', 'patterns', 'media'];

      return $editor_settings;
}
add_filter( 'block_editor_settings_all', 'remove_gutenberg_sidebar_tabs' );

// Verberg de tabjes met CSS
function remove_gutenberg_sidebar_tabs_css() {
      ?>
      <style>
          /* Verberg de tabjes in de Gutenberg editor */
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