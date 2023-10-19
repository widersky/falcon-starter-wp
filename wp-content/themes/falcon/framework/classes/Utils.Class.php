<?php
  
  class Utils {
    
    public static function add_image_size ($name, $size_x, $size_y) : void {
      add_image_size($name . '-cropped', $size_x, $size_y, true);
      add_image_size($name, $size_x, $size_y);
    }
    
  }