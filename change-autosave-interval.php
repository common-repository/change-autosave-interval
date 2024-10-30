<?php
/**
* Plugin Name: Change Autosave Interval
* Plugin URI: https://carlosmr.com/plugin/ajustar-el-tiempo-de-autoguardado/
* Description: This plugin creates a new setting at the end of Settings > General that allows to select the interval of time that WordPress take autosave your contents while editing.
* Version: 1.0.1
* Author: Carlos Mart&iacute;nez Romero
* Author URI: https://carlosmr.com
* License: GPL+2
* Text Domain: change-autosave-interval
* Domain Path: /languages
*/
// Load translations
add_action( 'plugins_loaded', 'cmr_cwasi_load_textdomain' );
function cmr_cwasi_load_textdomain(){
  load_plugin_textdomain( 'change-wordpress-autosave-interval', false, dirname( plugin_basename(__FILE__)).'/languages' );
}
// Starts the plugin
add_action( 'admin_init', 'cmr_cwasi_init' );
add_action( 'plugins_loaded', 'cmr_cwasi_execute' );
function cmr_cwasi_init(){
  // Section record
  register_setting( 'general', 'cmr_cwasi_settings', 'cmr_cwasi_sanitize_validate_settings' );
  // Adding the fields
  $settings = get_option('cmr_cwasi_settings');
  add_settings_field( 'cmr_cwasi_field_one', esc_html__('Autosave interval (in seconds)'), 'cmr_cwasi_fields_callback', 'general', 'default', array(
    'name' => 'cmr_cwasi_settings[one]',
    'value' => $settings['one']
  ) );
}
// Checking and validating the fields
function cmr_cwasi_sanitize_validate_settings( $input ){
  $output = get_option( 'cmr_cwasi_settings' );
  // Sanitizing the number
  $output['one'] = absint( $input['one'] );
  return $output;
}
// Field load
function cmr_cwasi_fields_callback( $args ){
  echo '<input type="text" name="'.esc_attr( $args['name'] ).'" value="'.esc_attr( $args['value'] ).'">';
  echo '</br>';
  echo '<p class="description">' . __('Keep in mind that this plugin wont work if the time is already defined elsewhere.', 'change-wordpress-autosave-interval' ) . '</p>';
}
function cmr_cwasi_execute(){
  // Getting the value
  $settings = get_option( 'cmr_cwasi_settings' );
  // Getting first value of the array
  if (isset($settings['one'])){
    if ( !defined( 'AUTOSAVE_INTERVAL' ) ){
      $cmrautosavetime = $settings['one'];
      // Definition of value
      define( 'AUTOSAVE_INTERVAL', $cmrautosavetime );
    }
    else{
    }
  }
}