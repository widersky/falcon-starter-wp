<?php

  class Section
  {

    private static array $subpage_builder_acf_structure;
    private static array $registered_sections;

    function __construct() {
      self::$subpage_builder_acf_structure = [
        'key' => '_site_options',
        'title' => __('Subpage options', 'falcon-theme'),
        'fields' => [
          [
            'key' => 'components',
            'label' => 'Components',
            'name' => 'components',
            'aria-label' => '',
            'type' => 'flexible_content',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'layouts' => [], // Here blocks data is added
            'button_label' => __('Add section', 'falcon-theme'),
          ]
        ],
        'location' => [
          [
            [
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'page',
            ]
          ]
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => [
          0 => 'the_content',
        ],
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
      ];
    }

    /**
     * Display a message if the section config file is missing.
     * This is not a fatal error.
     * The page will still load but block not.
     *
     * @param string $section_slug The section slug.
     */
    private static function display_missing_section_data_structure_info ( string $section_slug ) : void {
      echo '<div class="p-4 border border-red-500 bg-red-200 text-red-800 rounded text-sm m-1">';
        echo '<p>ERROR: There is no config file for the section <code class="bg-white/50 p-1 rounded text-xs">' . $section_slug . '</code> in the <code class="bg-white/50 p-1 rounded text-xs">partials/sections</code> directory.</p>';
      echo '</div>';
    }


    /**
     * Register single block using its config file.
     * Config file must be located in the partials/sections/{section_slug}/{section_slug}.config.php
     *
     * @param string $section_slug The section slug.
     */
    public static function register ( $section_slug ) : void {
      if ( ! file_exists( get_template_directory() . '/partials/sections/' . $section_slug . '/' . $section_slug . '.config.php' ) ) :
        self::display_missing_section_data_structure_info( $section_slug );
        return;
      endif;

      require get_template_directory() . '/partials/sections/' . $section_slug . '/' . $section_slug . '.config.php';

      if (!$section_config) return;

      if ( ! is_array( $section_config ) ) :
        self::display_missing_section_data_structure_info( $section_slug );
        return;
      endif;

      array_push( self::$subpage_builder_acf_structure['fields'][0]['layouts'], $section_config );
    }


    /**
     * Load every single registered section.
     */
    public function load_all () : void {
      add_action( 'acf/include_fields', function() {
        if ( ! function_exists( 'acf_add_local_field_group' ) ) {
          return;
        }

        acf_add_local_field_group( self::$subpage_builder_acf_structure );
      });
    }
  }
