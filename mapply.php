<?php
/*
Plugin Name: Mapply
Plugin URI: https://github.com/BOLDInnovationGroup/Mapply-WordPress-Plugin
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

// Add actions
add_action( 'wp_mapply_api', 'get_mapply_api' );
add_action( 'wp_google_gapi', 'get_google_api' );

add_action( 'wp_set_google_gapi', 'save_google_api' );
add_action( 'wp_set_mapply_gapi', 'save_mapply_api' );

// Install functions
register_activation_hook( __FILE__, 'jal_install' );

global $mapply_db_version;
$mapply_db_version = "1.0";

function jal_install () {
   global $wpdb;

   $installed_ver = get_option( "mapply_db_version" );
   $table_name = $wpdb->prefix . "mapply";

  if( $installed_ver != $mapply_db_version ) {

    $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      mapply_api VARCHAR(255) DEFAULT '' NOT NULL,
      google_api VARCHAR(255) DEFAULT '' NOT NULL,
      UNIQUE KEY id (id)
    );";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    update_option( "mapply_db_version", $jal_db_version );

  }
}

// End of Install functions

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

// Save functions for API Keys
function save_mapply_api($api){
  global $wpdb;

}

function save_google_api($gapi){
  global $wpdb;

}

function get_mapply_api(){
  global $wpdb;

  $api = "";
  return $api;
}

function get_google_api(){
  global $wpdb;

  $gapi = "";
  return $gapi;
}

?>
