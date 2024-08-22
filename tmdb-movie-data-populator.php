<?php
/*
Plugin Name: TMDb Movie Data Populator
Description: Automatically populates custom fields with movie data from TMDb.
Version: 1.0
Author: B1PL0B
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('TMDB_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TMDB_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once(TMDB_PLUGIN_DIR . 'includes/custom-fields.php');
require_once(TMDB_PLUGIN_DIR . 'includes/api-handler.php');
require_once(TMDB_PLUGIN_DIR . 'includes/admin-settings.php');

// Hook to initialize the plugin
add_action('plugins_loaded', 'tmdb_movie_data_populator_init');

function tmdb_movie_data_populator_init() {
    // Register custom fields
    add_action('add_meta_boxes', 'tmdb_register_custom_fields');
    
    // Save custom fields
    add_action('save_post', 'tmdb_save_custom_fields');
    
    // Enqueue admin scripts and styles
    add_action('admin_enqueue_scripts', 'tmdb_enqueue_admin_scripts');
    
    // Add settings page
    add_action('admin_menu', 'tmdb_add_settings_page');
    
    // Register settings
    add_action('admin_init', 'tmdb_register_settings');
}

// Enqueue admin scripts and styles
function tmdb_enqueue_admin_scripts($hook) {
    if ('post.php' != $hook && 'post-new.php' != $hook) {
        return;
    }
    
    wp_enqueue_script('tmdb-admin-script', TMDB_PLUGIN_URL . 'assets/js/admin-script.js', array('jquery'), '1.0', true);
    wp_enqueue_style('tmdb-admin-style', TMDB_PLUGIN_URL . 'assets/css/admin-style.css');
    
    wp_localize_script('tmdb-admin-script', 'tmdbAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('tmdb-ajax-nonce')
    ));
}
