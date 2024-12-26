<?php
// Zet alle Gutenberg blokken uit
function disable_all_gutenberg_blocks() {
      // Haal alle geregistreerde blokken op
      global $wp_registered_blocks;

      // Verwijder alle geregistreerde blokken
      foreach ( $wp_registered_blocks as $block_name => $block ) {
            unregister_block_type( $block_name );
      }
}
add_action( 'init', 'disable_all_gutenberg_blocks', 100 );