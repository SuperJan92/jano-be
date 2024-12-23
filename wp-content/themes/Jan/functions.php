<?php
/**
 * Functions for the Jan theme
 */

// Voorkom dat WordPress een thema probeert te laden
add_filter('template', function($template) {
      return '';  // Geen thema voor de front-end
});

add_filter('stylesheet', function($stylesheet) {
      return '';  // Geen stylesheet voor de front-end
});