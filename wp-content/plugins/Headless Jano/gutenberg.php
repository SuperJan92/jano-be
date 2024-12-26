<?php
// Dit is een debugregel
echo 'TAaaaaaaaBS';

// Alleen je eigen blokken toestaan in de editor
function disable_all_gutenberg_blocks_except_own( $allowed_blocks ) {
      // Voeg je eigen blokken toe aan de lijst van toegestane blokken
      return array(
            'blocks/hero', // Voeg hier je eigen blokken toe
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