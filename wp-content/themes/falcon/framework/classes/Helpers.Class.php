<?php

  class Helpers
  {
    /**
   * Nicely show PHP object / array
   *
   * @param array $what Array to dump
   * @param string $label Label for dump
   */

  public static function localDump ( array $what, string $label ) : void
  {
    if ( SHOW_SECTIONS_DATA ) :
      echo '<div class="text-xs flex gap-3 p-6 m-2 border-2 border-slate-300 rounded bg-slate-200 overflow-scroll max-h-72">';
        echo '<svg class="w-6 flex-shrink-0" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M7.52999 8.53001L4.05999 12L7.52999 15.47C7.82299 15.763 7.82299 16.238 7.52999 16.531C7.38399 16.677 7.19199 16.751 6.99999 16.751C6.80799 16.751 6.61599 16.678 6.46999 16.531L2.46999 12.531C2.17699 12.238 2.17699 11.763 2.46999 11.47L6.46999 7.47001C6.76299 7.17701 7.238 7.17701 7.531 7.47001C7.823 7.76201 7.82299 8.23801 7.52999 8.53001ZM21.53 11.47L17.53 7.47001C17.237 7.17701 16.762 7.17701 16.469 7.47001C16.176 7.76301 16.176 8.23802 16.469 8.53102L19.939 12.001L16.469 15.471C16.176 15.764 16.176 16.239 16.469 16.532C16.615 16.678 16.807 16.752 16.999 16.752C17.191 16.752 17.383 16.679 17.529 16.532L21.529 12.532C21.823 12.238 21.823 11.762 21.53 11.47ZM15.263 3.29801C14.877 3.15101 14.443 3.34901 14.298 3.73701L8.298 19.737C8.152 20.125 8.34899 20.557 8.73699 20.703C8.82299 20.736 8.91299 20.751 8.99999 20.751C9.30399 20.751 9.58899 20.565 9.70199 20.264L15.702 4.26402C15.848 3.87502 15.651 3.44301 15.263 3.29801Z" fill="#25314C"/>
              </svg>';
          echo '<div class="flex flex-1 flex-col">';
          echo '<h6 class="font-mono pt-1">' . $label . ':</h6>';
          echo '<pre>';
          highlight_string ( "<?php\n\$data = " . var_export ( $what, true ) . ";\n?>" );
          echo '</pre>';
          echo '</div>';
      echo '</div>';
    endif;
  }
  }
