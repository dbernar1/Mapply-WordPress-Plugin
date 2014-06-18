<?php
function provide_a_settings_page__bam() {
  add_action('admin_menu', 'mapply_create_menu');
}

function mapply_create_menu() {
  add_menu_page(
  	$page_title = 'Mapply Settings',
	$menu_title = 'Mapply',
	$capability = 'administrator',
	$menu_slug = __FILE__,
	$function = 'mapply_settings_page',
	$icon_url = plugins_url( '/images/icon.png', __FILE__ )
  );
}

// Build the settings page
function mapply_settings_page() {
  $image    = WP_PLUGIN_URL . '/mapply/images/logo.png';
  $image2   = WP_PLUGIN_URL . '/mapply/images/logo2.png';
  $nav_bg   = WP_PLUGIN_URL . '/mapply/images/banner-bg.jpg';
  $styles   = WP_PLUGIN_URL . '/mapply/css/mapply_styles.css';
  $semantic = WP_PLUGIN_URL . '/mapply/css/semantic.css';

  $settings = get_settings__bam();
?>

<link rel="stylesheet" type="text/css" href="<?php echo $semantic ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo $styles ?>"/>

<div class="navbar" style="background: url('<?php echo $nav_bg ?>') center center #757994 no-repeat;">
    <a class="logo" href="http://mapply.net" target="_blank"><img src="<?php echo $image2 ?>" width="150"></a>
</div>

<div class="wrap ui segment purple">

<?php if ( isset( $_GET[ 'settings-saved' ] ) ): ?>
<div class="updated"><p>class .updated with paragraph</p></div>
<?php endif ?>

<img src="<?php echo $image ?>" width="150">
<hr>
<div class="instructions">
  <p><b>Step 1</b> - First we'll need to have a Mapply account. If you don't have one already, you can sign up for a <a href="http://mapply.net/">free 30 day trial here</a>! :-)</p>
  <p><b>Step 2</b> - Once you're signed up and inside your Mapply account, navigate to the <a href="https://app.mapply.net/settings.php">API setup page</a> to grab your Mapply and Google Map API keys to populate the fields below.</p>
  <p><b>Step 3</b> - Once you have all of your <a href="https://app.mapply.net/admin.php">stores set up</a> in your Mapply account, you can insert your map on any page by using the <b>[mapply]</b> shortcode.</p>
</div>

<form method="post" action="admin-post.php">
    <input type="hidden" name="action" value="mapply_api_keys" />
    <table class="form-table">
        <tr valign="top">
          <th scope="row">Mapply API key</th>
          <td><input id="mapply_api_box" type="text" name="mapply_api_key" class="ui input" value="<?php echo $settings[ 'mapply_api' ] ?>" /></td>
        </tr>

        <tr valign="top">
          <th scope="row">Google API key</th>
          <td><input type="text" name="google_api_key" class="ui input" value="<?php echo $settings[ 'google_api' ] ?>" /></td>
        </tr>

        <tr valign="top">
          <th scope="row">Display Mapply referral link :-)</th>
          <td><input type="checkbox" name="display_ref" <?php if($settings[ 'display_referral' ] == "1"){ echo "checked"; }; ?> value="1"></td>
        </tr>

    </table>

    <?php submit_button(); ?>

</form>
</div>

<?php }

function enable_saving_settings__bam() {
  add_action( 'admin_post_mapply_api_keys', 'process_mapply_keys' );
}

function get_settings__bam() {
  static $settings;

  if ( ! isset( $settings ) ) {
    $default_settings = array(
      'google_api' => '',
      'mapply_api' => '',
      'display_referral' => 0,
    );

    $settings = get_option( 'mapply_settings__bam', $defaults_settings );
  }

  return $settings;
}

// Process the form data
function process_mapply_keys(){
  if ($_POST){

    $settings = get_settings__bam();

    // Check for the google api key
    if (isset($_POST['google_api_key'])){
      $settings[ 'google_api' ] = sanitize_text_field($_POST['google_api_key']);
    }

    // Check for the apply api key
    if (isset($_POST['mapply_api_key'])){
      $settings[ 'mapply_api' ] = sanitize_text_field($_POST['mapply_api_key']);
    }

    $settings[ 'display_refferal' ] = isset($_POST['display_ref']) ? 1 : 0;

    update_option( 'mapply_settings__bam', $settings );

    // redirect
    wp_redirect(admin_url( 'admin.php?page=mapply/mapply.php&settings-saved=1' ));
    exit;
  }
}
