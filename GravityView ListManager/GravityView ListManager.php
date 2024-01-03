<?php
/*
Plugin Name: GravityView ListManager
Description: Custom functionality for GravityView.
Version: 1.0
Author: magnigenie
*/

// No direct file access
defined('ABSPATH') || exit;

define('GV_CUSTOM_PLUGIN_FILE', __FILE__);
define('GV_CUSTOM_PLUGIN_PATH', plugin_dir_path(__FILE__));

require_once GV_CUSTOM_PLUGIN_PATH . 'includes/class-gravityview-ListManager.php';

// Instantiate the class to trigger the actions and filters
new GravityView_ListManager();
