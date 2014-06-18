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

require dirname( __FILE__ ) . '/includes/shortcode.php';
require dirname( __FILE__ ) . '/includes/settings.php';

handle_mapply_shortcode__bam();
provide_a_settings_page__bam();
enable_saving_settings__bam();
