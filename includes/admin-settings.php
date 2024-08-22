<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

function tmdb_add_settings_page() {
    add_options_page(
        'TMDb Movie Data Populator Settings',
        'TMDb Movie Data',
        'manage_options',
        'tmdb-movie-data-settings',
        'tmdb_render_settings_page'
    );
}

function tmdb_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>TMDb Movie Data Populator Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('tmdb_settings_group');
            do_settings_sections('tmdb-movie-data-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function tmdb_register_settings() {
    register_setting('tmdb_settings_group', 'tmdb_api_key');
    
    add_settings_section(
        'tmdb_main_section',
        'Main Settings',
        'tmdb_main_section_callback',
        'tmdb-movie-data-settings'
    );
    
    add_settings_field(
        'tmdb_api_key',
        'TMDb API Key',
        'tmdb_api_key_callback',
        'tmdb-movie-data-settings',
        'tmdb_main_section'
    );
}

function tmdb_main_section_callback() {
    echo '<p>Enter your TMDb API key below:</p>';
}

function tmdb_api_key_callback() {
    $api_key = get_option('tmdb_api_key');
    echo "<input type='text' name='tmdb_api_key' value='" . esc_attr($api_key) . "' />";
}
