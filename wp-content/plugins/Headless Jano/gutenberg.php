<?php
// Dit is een debugregel
echo 'REMOVEeeeeeee';

// Alleen je eigen blokken toestaan in de editor
function disable_all_gutenberg_blocks_except_own( $allowed_blocks ) {
      // Voeg je eigen blokken toe aan de lijst van toegestane blokken
      // Vervang 'my-plugin/hero' door de naam van je eigen blok
      return array(
            'my-plugin/hero', // Voeg hier je eigen blokken toe
      );
}

add_filter( 'allowed_block_types_all', 'disable_all_gutenberg_blocks_except_own', 10, 1 );

// Verwijder Blokken, Patronen en Media uit het WordPress menu
function remove_gutenberg_menu_items() {
      // Verwijder de 'Blokken' en andere menu-items
      remove_menu_page( 'edit.php?post_type=wp_block' ); // Blokken
      remove_menu_page( 'edit.php?post_type=wp_pattern' ); // Patronen
      remove_menu_page( 'upload.php' ); // Media
}

add_action( 'admin_menu', 'remove_gutenberg_menu_items', 999 );