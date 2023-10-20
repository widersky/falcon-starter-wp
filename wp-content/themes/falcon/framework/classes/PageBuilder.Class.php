<?php

  class PageBuilder
  {

    /**
     * Display a message if the section file is missing.
     * This is a fallback in case the file is missing.
     * This is not a fatal error.
     * The page will still load.
     *
     * @param string $section_slug The section slug.
     */
    private static function display_missing_section_file_info ( string $section_slug) : void {
      echo '<div class="p-4 border border-red-500 bg-red-200 text-red-800 rounded text-sm m-1">';
        echo '<p>ERROR: There is no markup file for the section <code class="bg-white/50 p-1 rounded text-xs">' . $section_slug . '</code> in the <code class="bg-white/50 p-1 rounded text-xs">partials/sections</code> directory.</p>';
      echo '</div>';
    }


    /**
     * Match the section slug to the file name and include the file.
     * If the file does not exist, display a message.
     *
     * @param string $section_slug The section slug.
     * @param array  $section_data The section data from database.
     */
    private static function get_section ( string $section_slug, array $section_data) : void {
      if (file_exists(get_template_directory() . '/partials/sections/' . $section_slug . '/' . $section_slug . '.php')) :
        get_template_part('partials/sections/' . $section_slug . '/' . $section_slug, '', [ 'data' => $section_data ]);
      else :
        self::display_missing_section_file_info($section_slug);
      endif;
    }


    /**
     * Get the page structure from the ACF fields set in ACF Pro elastic content.
     * Loop through the sections and match the section slug to the file name.
     */
    public static function get_structure () : void {
      if (function_exists('get_field')) :
        $sections = get_field('components', get_the_ID());

        if (!is_array($sections)) return;

        foreach ($sections as $section) :
          self::get_section($section['acf_fc_layout'], $section);
        endforeach;
      endif;
    }


  }
