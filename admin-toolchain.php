<?php

/**
 * Plugin Name: Admin Toolchain
 * Plugin URI: https://github.com/skaramicke/admin-toolchain
 * Description: A small collection of tools to adapt WordPress administration to your liking
 * Version: 1.0.0
 * Author: Mikael Grön <skaramicke@gmail.com>
 * Author URI: https://github.com/skaramicke
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
