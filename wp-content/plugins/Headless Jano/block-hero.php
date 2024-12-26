<?php
function wpdocs_allowed_block_types( $block_editor_context, $editor_context ) {
      if ( ! empty( $editor_context->post ) ) {
            return array(
                  'core/paragraph',
                  'core/heading',
                  'core/list',
                  'hero-block', // Voeg je eigen blok hier toe
            );
      }

      return $block_editor_context;
}

add_filter( 'allowed_block_types_all', 'wpdocs_allowed_block_types', 10, 2 );