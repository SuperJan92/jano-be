<?php
// Dit is een debugregel
echo 'REMOVE';

// Alleen je eigen blokken toestaan in de editor
function disable_all_gutenberg_blocks_except_own( $allowed_blocks ) {
      // Voeg je eigen blokken toe aan de lijst van toegestane blokken
      // Vervang 'my-plugin/hero' door de naam van je eigen blok
      return array(
            'my-plugin/hero', // Voeg hier je eigen blokken toe
      );
}

add_filter( 'allowed_block_types_all', 'disable_all_gutenberg_blocks_except_own', 10, 1 );