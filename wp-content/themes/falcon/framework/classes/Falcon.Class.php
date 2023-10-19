<?php

  class Falcon {

    public function load_textdomain () : void {
      add_action( 'after_setup_theme', function () {
        load_theme_textdomain( 'falcon-theme', get_template_directory() . '/languages' );
      });
    }

  }
