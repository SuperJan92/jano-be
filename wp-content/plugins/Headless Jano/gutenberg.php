<?php
// Dit is een debugregel
echo 'TABS';

// Alleen je eigen blokken toestaan in de editor
function disable_all_gutenberg_blocks_except_own( $allowed_blocks ) {
      // Voeg je eigen blokken toe aan de lijst van toegestane blokken
      return array(
            'my-plugin/hero', // Voeg hier je eigen blokken toe
      );
}

add_filter( 'allowed_block_types_all', 'disable_all_gutenberg_blocks_except_own' );

// Verwijder de tabjes (Blocks, Patterns, Media) uit de Gutenberg zijbalk
function remove_gutenberg_sidebar_tabs($editor_settings) {
      // Verberg de 'Blocks', 'Patterns' en 'Media' tabs in de zijbalk
      if ( isset( $editor_settings['sidebar'] ) ) {
            $editor_settings['sidebar']['blocks'] = false;  // Verberg de Blocks tab
            $editor_settings['sidebar']['patterns'] = false; // Verberg de Patterns tab
            $editor_settings['sidebar']['media'] = false; // Verberg de Media tab
      }
      return $editor_settings;
}

add_filter( 'block_editor_settings_all', 'remove_gutenberg_sidebar_tabs' );

// Verwijder de submenu's (Blocks, Patterns, Media) uit de admin sidebar
function remove_gutenberg_admin_menu_items() {
      // Verwijder de submenu items voor Gutenberg
      remove_submenu_page( 'edit.php?post_type=wp_block', 'edit.php?post_type=wp_block' ); // Blokken
      remove_submenu_page( 'edit.php?post_type=wp_pattern', 'edit.php?post_type=wp_pattern' ); // Patronen
      remove_submenu_page( 'upload.php', 'upload.php' ); // Media
}

add_action( 'admin_menu', 'remove_gutenberg_admin_menu_items', 999 );