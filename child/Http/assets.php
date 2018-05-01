<?php

namespace Tonik\Theme\Child\Http;

/*
|-----------------------------------------------------------------
| Child Theme Assets
|-----------------------------------------------------------------
|
| This file is for registering your child theme
| stylesheets and scripts, which will be load
| additionaly to the parent theme assets.
|
*/

use function Tonik\Theme\Child\asset_path;

/**
 * Registers child theme stylesheet files.
 *
 * @return void
 */
function register_stylesheets() {
  wp_enqueue_style('tonik-child-theme', asset_path('css/child.css'));
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\register_stylesheets');

/**
 * Registers wordpress built-in script files.
 * We do this to ensure load order (note the wp $priority parameter)
 * 
 * @return void
 */
function register_wp_scripts() {
  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'underscore' );
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\register_wp_scripts', 5);

/**
 * Registers child theme script files.
 *
 * @return void
 */
function register_scripts() {
  wp_enqueue_script( 'tonik-child-theme', asset_path('js/main.js'), ['jquery', 'underscore'], null, true );
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\register_scripts', 10);

/**
 * Removes any <script> element from <head>
 * ...useful for customizing WP Admin screens
 *
 * @return void
 */
function remove_head_scripts() {
  remove_action('wp_head', 'wp_print_scripts');
  remove_action('wp_head', 'wp_print_head_scripts', 9);
  remove_action('wp_head', 'wp_enqueue_scripts', 1);
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\remove_head_scripts', 0);
