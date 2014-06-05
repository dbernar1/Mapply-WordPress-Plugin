<?php
/*
Plugin Name: Mapply
Plugin URI: http://www.mapply.new/wordpress-app
Description: Dislay a map of your stores on your WordPress site!
Version: 1.0
Author: Mapply
Author URI: http://www.mapply.net
*/

// Originally developed by Dann Blair
// boldinnovationgroup.net

// Defaults
DEFINE("DEMOLP_HEADINGSTART", "<h4>Mapplyß</h4>");

// Shortcodes
add_shortcode("mapply", "mapply_handler");

function mapply_handler($incomingfrompost) {

  $incomingfrompost=shortcode_atts(array(
    "headingstart" => DEMOLP_HEADINGSTART
  ), $incomingfrompost);

  $demolph_output = demolistposts_function($incomingfrompost);
  return $demolph_output;
}

function get_mapply_refferal_url(){

}

function demolistposts_function($incomingfromhandler) {
  $demolp_output = wp_specialchars_decode($incomingfromhandler["headingstart"]);
  $demolp_output .= wp_specialchars_decode($incomingfromhandler["liststart"]);

  for ($demolp_count = 1; $demolp_count <= $incomingfromhandler["categorylist"]; $demolp_count++) {
    $demolp_output .= wp_specialchars_decode($incomingfromhandler["itemstart"]);
    $demolp_output .= $demolp_count;
    $demolp_output .= " of ";
    $demolp_output .= wp_specialchars($incomingfromhandler["categorylist"]);
    $demolp_output .= wp_specialchars_decode($incomingfromhandler["itemend"]);
  }

  $demolp_output .= wp_specialchars_decode($incomingfromhandler["listend"]);
  $demolp_output .= wp_specialchars_decode($incomingfromhandler["headingend"]);
  return $demolp_output;
}

?>
