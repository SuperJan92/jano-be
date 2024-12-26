<?php
// Dit is een debugregel
echo 'REMOVEeeeeesfhksxfhsdlee';

// Alleen je eigen blokken toestaan in de editor
function disable_all_gutenberg_blocks_except_own( $allowed_blocks ) {
      // Voeg je eigen blokken toe aan de lijst van toegestane blokken
      // Vervang 'my-plugin/hero' door de naam van je eigen blok
      return array(
            'my-plugin/hero', // Voeg hier je eigen blokken toe
      );
}

add_filter( 'allowed_block_types_all', 'disable_all_gutenberg_blocks_except_own', 10, 1 );

// Verwijder de Gutenberg zijbalk items (Blokken, Patronen, Media)
function remove_gutenberg_sidebar_menu_items() {
      // Verwijder het blokken paneel
      remove_meta_box( 'block', 'post', 'normal' ); // Blokken
      remove_meta_box( 'patterns', 'post', 'side' ); // Patronen
      remove_meta_box( 'media-buttons', 'post', 'side' ); // Media

      // Je kunt deze toevoegen voor andere post types indien nodig:
      // remove_meta_box( 'block', 'page', 'normal' ); // Voor pagina's
}
add_action( 'add_meta_boxes', 'remove_gutenberg_sidebar_menu_items', 999 );