<?php
// Dit is een debugregel
echo 'TABS';

// Alleen je eigen blokken toestaan in de editor
function disable_all_gutenberg_blocks_except_own( $allowed_blocks ) {
      // Voeg je eigen blokken toe aan de lijst van toegestane blokken
      // Vervang 'my-plugin/hero' door de naam van je eigen blok
      return array(
            'my-plugin/hero', // Voeg hier je eigen blokken toe
      );
}

// Verwijder de tabjes (Blocks, Patterns, Media) uit de Gutenberg zijbalk
function remove_gutenberg_sidebar_tabs($editor_settings) {
      // Schakel de tabjes uit
      $editor_settings['disableTabs'] = ['blocks', 'patterns', 'media'];

      return $editor_settings;
}

add_filter('block_editor_settings_all', 'remove_gutenberg_sidebar_tabs');