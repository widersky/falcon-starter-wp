<?php

  // Exit if accessed directly
  if ( !defined('ABSPATH') )
    exit;

  const DIST_FOLDER = 'dist';
  const JS_DEPENDENCY = [];          // ['jquery'] as example
  const JS_LOAD_IN_FOOTER = true;    // load scripts in footer?
  const VITE_SERVER = 'http://localhost:3000';
  const VITE_ENTRY_POINT = '/main.js';

  define('DIST_URI', get_template_directory_uri() . '/' . DIST_FOLDER);
  define('DIST_PATH', get_template_directory() . '/' . DIST_FOLDER);

  class AssetsLoader {

    public function load_whats_needed () : void {
      add_action('wp_enqueue_scripts', function () {

        if ( defined('IS_VITE_DEVELOPMENT') && IS_VITE_DEVELOPMENT === true ) {
          add_action('wp_head', function () {
            echo '<script type="module" crossorigin src="' . VITE_SERVER . VITE_ENTRY_POINT . '"></script>';
          });
        } else {
          $manifest = json_decode(file_get_contents(DIST_PATH . '/manifest.json'), true);

          if ( is_array($manifest) ) {

            // get first key, by default is 'main.js' but it can change
            $manifest_key = array_keys($manifest);

            if ( isset($manifest_key[1]) ) {

              // echo '<pre>';
              // print_r(@$manifest[$manifest_key[1]]);
              // echo '</pre>';

              // Enqueue CSS files
              foreach ( @$manifest[$manifest_key[1]]['css'] as $css_file ) {
                wp_enqueue_style('main', DIST_URI . '/' . $css_file);
              }

              // Enqueue main JS file
              $js_file = @$manifest[$manifest_key[1]]['file'];

              if ( !empty($js_file) ) {
                wp_enqueue_script('main', DIST_URI . '/' . $js_file, JS_DEPENDENCY, '', JS_LOAD_IN_FOOTER);
              }

            }

          }
        }

      });
    }

  }
