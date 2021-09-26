<?php

/**
 * Plugin Name: Admin Toolchain
 * Plugin URI: https://github.com/skaramicke/admin-toolchain
 * Description: A small collection of tools to adapt WordPress administration to your liking
 * Version: 1.0.0
 * Author: Mikael Grön <skaramicke@gmail.com>
 * Author URI: https://github.com/skaramicke
 * License: GPLv2
 */

define('WPAT_VERSION', "v1.0.0");

require_once(__DIR__ . '/inc/tool.php');

/** @var WPAT_Tool[] $wpat_tool_instances */
global $wpat_tool_instances;
$wpat_tool_instances = [];

// Load all the tools
foreach (glob(__DIR__ . '/tools/*.php') as $tool) {
    require_once $tool;
}

// Create settings page
add_action('admin_menu', function () {
    add_options_page('Admin Toolchain', 'Admin Toolchain', 'manage_options', 'admin-toolchain', 'wpat_display_options');
});

function wpat_display_options()
{
    /** @var WPAT_Tool[] $wpat_tool_instances */
    global $wpat_tool_instances;
    include(__DIR__ . '/tpl/options_page.php');
}

// Add github updater functionality
require_once(__DIR__ . '/inc/github-updater.php');
if (is_admin()) { // note the use of is_admin() to double check that this is happening in the admin
    $config = array(
        'slug' => 'admin-toolchain', // this is the slug of your plugin
        'proper_folder_name' => plugin_basename(__FILE__), // this is the name of the folder your plugin lives in
        'api_url' => 'https://api.github.com/repos/skaramicke/admin-toolchain', // the GitHub API url of your GitHub repo
        'raw_url' => 'https://raw.github.com/skaramicke/admin-toolchain/main', // the GitHub raw url of your GitHub repo
        'github_url' => 'https://github.com/skaramicke/admin-toolchain', // the GitHub url of your GitHub repo
        'zip_url' => 'https://github.com/skaramicke/admin-toolchain/zipball/main', // the zip url of the GitHub repo
        'sslverify' => true, // whether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
        'requires' => '3.0', // which version of WordPress does your plugin require?
        'tested' => '5.8', // which version of WordPress is your plugin tested up to?
        'readme' => 'README.md', // which file to use as the readme for the version number
        // 'access_token' => '', // Access private repositories by authorizing under Plugins > GitHub Updates when this example plugin is installed
    );
    new WP_GitHub_Updater($config);
}
