<?php

function disable_all_gutenberg_blocks_except_own( $allowed_blocks ) {
      return array( 'heroo' ); // Zorg ervoor dat dit overeenkomt met de naam die je in acf_register_block gebruikt
}
add_filter( 'allowed_block_types_all', 'disable_all_gutenberg_blocks_except_own' );