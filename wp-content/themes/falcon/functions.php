<?php

  // Exit if accessed directly
  if ( ! defined( 'ABSPATH' ) )
    exit;

  const IS_VITE_DEVELOPMENT = true;
  const SHOW_SECTIONS_DATA = false;

  // Load Falcon classes
  require get_template_directory () . '/framework/classes/AssetsLoader.Class.php';
  require get_template_directory () . '/framework/classes/Customizer.Class.php';
  require get_template_directory () . '/framework/classes/Utils.Class.php';
  require get_template_directory () . '/framework/classes/Falcon.Class.php';
  require get_template_directory () . '/framework/classes/PageBuilder.Class.php';
  require get_template_directory () . '/framework/classes/Helpers.Class.php';
  require get_template_directory () . '/framework/classes/Section.Class.php';

  $falcon = new Falcon();
  $customize = new Customizer();
  $assets = new AssetsLoader();

  // Load sections
  $section = new Section();
  $section -> register('example');
  $section -> register('hero_slider');
  $section -> load_all();

  // Load Falcon foundation
  $falcon -> load_textdomain();

  // Customize WP installation - disable or enable helpful options
  $customize -> clean_admin_panel();
  $customize -> clean_mess_in_head();
  $customize -> disable_file_editing();
  $customize -> disable_remote_block_patterns();
  $customize -> disable_capital_p_dangit();
  $customize -> disable_duotone_svgs();
  $customize -> disable_emojis();
  $customize -> disable_gutenberg_editor();
  $customize -> disable_gutenberg_styles();
  $customize -> disable_pre_ping();
  $customize -> disable_wp_embed();
  $customize -> disable_xml_rpc();
  $customize -> disable_versions_in_assets();
  $customize -> move_scripts_to_footer();

  // Enable extrsa supports
  $customize -> enable_wp_feature( 'title-tag' );
  $customize -> enable_wp_feature( 'post-thumbnails' );

  // Load assets
  $assets -> load_whats_needed();

  // Utils
  Utils ::add_image_size ('size-4k', '3840', '2160');
  Utils ::add_image_size ('size-qhd', '2560', '1440');
  Utils ::add_image_size ('size-fullhd', '1920', '1080');
  Utils ::add_image_size ('size-hd', '1366', '768');
  Utils ::add_image_size ('size-xga', '1024', '768');
  Utils ::add_image_size ('size-svga', '800', '600');
  Utils ::add_image_size ('size-small', '640', '480');
  Utils ::add_image_size ('size-verysmall', '320', '240');

  // Custom code for WP
  require get_template_directory () . '/inc/wp/hooks.php';
  require get_template_directory () . '/inc/wp/cpts.php';

  // Custom code for WooCommerce
  require get_template_directory () . '/inc/woo/hooks.php';
