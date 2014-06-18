<?php

function handle_mapply_shortcode__bam() {
  add_shortcode("mapply", "mapply_handler");
}

// The function that actually handles replacing the short code
function mapply_handler($incomingfrompost) {
  $settings = get_settings__bam();

  if ($settings[ 'mapply_api' ] == "" || $settings[ 'google_api' ] == ""){
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
  $settings = get_settings__bam();

  $script = '<script id="locator" type="text/javascript" src="//app.mapply.net/front-end/js/locator.js" data-api-key="store_locator.';
  $script .= $settings[ 'mapply_api' ];
  $script .= '" data-path="//app.mapply.net/front-end/" data-maps-api-key="';
  $script .= $settings[ 'google_api' ];
  $script .= '" ></script>';

  // If the user has selected display ref link, add it.
  if ($settings[ 'display_referral' ] == "1"){
    $script .= '<a href="http://mapply.net">Store Finder Powered by Mapply</a>';
  }

  return $script;
}

// build the script to replace the short code
// TODO: This is probably all unused shortcode attributes
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
