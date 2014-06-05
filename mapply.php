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
// https://github.com/BOLDInnovationGroup/Mapply-WordPress-Plugin


// Save functions to catch the API keys
if ($_POST){
  if (isset($_POST['google_api_key'])){
    save_google_api($_POST['google_api_key']);
  }

  if (isset($_POST['mapply_api_key'])){
    save_mapply_api($_POST['mapply_api_key']);
  }
}

// Shortcodes
add_shortcode("mapply", "mapply_handler");

// Add actions
add_action('admin_menu', 'mapply_create_menu');
add_action( 'wp_mapply_api', 'get_mapply_api' );
add_action( 'wp_google_gapi', 'get_google_api' );
add_action( 'wp_set_google_gapi', 'save_google_api' );
add_action( 'wp_set_mapply_gapi', 'save_mapply_api' );

// Activiation Hook
register_activation_hook( __FILE__, 'mapply_install' );

// Install functions
global $mapply_db_version;
$mapply_db_version = "1.0";

// Create the table to hold the API keys
function mapply_install () {
   global $wpdb;

   $installed_ver = get_option( "mapply_db_version" );
   $table_name = get_table_name();

  if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name || $installed_ver != $mapply_db_version ) {

    $sql = 'CREATE TABLE ' .$table_name. ' (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      mapply_api VARCHAR(255) DEFAULT "" NOT NULL,
      google_api VARCHAR(255) DEFAULT "" NOT NULL,
      UNIQUE KEY id (id)
    );';

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    update_option( "mapply_db_version", $mapply_db_version );
    create_first_row();
  }
}

// Get the table prefix and return the name
function get_table_name(){
  global $wpdb;
  return $wpdb->prefix . "mapply";
}

// End of Install functions
// The function that actually handles replacing the short code
function mapply_handler($incomingfrompost) {

  $api = get_mapply_api();
  $gapi = get_google_api();
  $script_text = "";

  if ($api == "" || $gapi == ""){
    $script_text = "<p>You need to save your Mapply API key and Google API key in the settings page.";
  } else {
    $script_text = build_script_text();
  }

  $incomingfrompost=shortcode_atts(array(
    "headingstart" => $script_text
  ), $incomingfrompost);

  $demolph_output = script_output($incomingfrompost);
  return $demolph_output;
}

function build_script_text(){
  $api = get_mapply_api();
  $gapi = get_google_api();

  $script = '<script id="locator" type="text/javascript" src="//app.mapply.net/front-end/js/locator.js" data-api-key="store_locator.';
  $script .= $api;
  $script .= '" data-path="//app.mapply.net/front-end/" data-maps-api-key="';
  $script .= $gapi;
  $script .= '" ></script>';

  return $script;
}

function get_mapply_refferal_url(){

}

// build the script to replace the short code
function script_output($incomingfromhandler) {
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

function create_first_row(){
  global $wpdb;
  $table_name = get_table_name();
  $wpdb->insert( $table_name, array('mapply_api' => '', 'google_api' => ''), array());
}

// Save the mapply API key
function save_mapply_api($api){
  global $wpdb;
  $table_name = get_table_name();
  $wpdb->query($wpdb->prepare("UPDATE ".$table_name." SET mapply_api='$api' WHERE id=1"));
}

// Save the Google API key
function save_google_api($gapi){
  global $wpdb;
  $table_name = get_table_name();
  $wpdb->query($wpdb->prepare("UPDATE ".$table_name." SET google_api='$gapi' WHERE id=1"));
}


// Get the mapply api from the db
function get_mapply_api(){
  global $wpdb;
  $table_name = get_table_name();
  $api = $wpdb->get_row( $wpdb->prepare( "SELECT mapply_api FROM " .$table_name. " WHERE ID = 1" ));
  return $api->mapply_api;
}


// Get the google API from the db
function get_google_api(){
  global $wpdb;
  $table_name = get_table_name();
  $gapi = $wpdb->get_row( $wpdb->prepare( "SELECT google_api FROM " .$table_name. " WHERE ID = 1" ));
  return $gapi->google_api;
}

// create custom plugin settings menu


function mapply_create_menu() {

	//create new top-level menu
	add_menu_page('Mapply Settings', 'Mapply', 'administrator', __FILE__, 'mapply_settings_page',plugins_url('/images/icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'mapply-settings-group', 'mapply_api_key' );
	register_setting( 'mapply-settings-group', 'some_other_option' );
}

function mapply_settings_page() {
?>
<div class="wrap">
<h2>Mapply</h2>
<p>Save your Mapply and Google API keys.
<form method="post" action="mapply.php">
    <?php settings_fields( 'baw-settings-group' ); ?>
    <?php do_settings_sections( 'baw-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Mapply API</th>
        <td><input type="text" name="mapply_api_key" value="<?php echo get_option('mapply_api_key'); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Google API</th>
        <td><input type="text" name="google_api_key" value="<?php echo get_option('some_other_option'); ?>" /></td>
        </tr>
    </table>

    <?php submit_button(); ?>

</form>
</div>
<?php } ?>
