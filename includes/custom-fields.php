<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

function tmdb_register_custom_fields() {
    add_meta_box(
        'tmdb_movie_data',
        'TMDb Movie Data',
        'tmdb_render_custom_fields',
        'post',
        'normal',
        'high'
    );
}

function tmdb_render_custom_fields($post) {
    wp_nonce_field('tmdb_save_custom_fields', 'tmdb_custom_fields_nonce');
    
    $fields = array(
        'movie_name' => 'Movie Name',
        'release_date' => 'Release Date',
        'genre' => 'Genre',
        'country_of_origin' => 'Country of Origin',
        'movie_poster' => 'Movie Poster',
        'movie_backdrop' => 'Movie Backdrop',
        'language' => 'Language',
        'duration' => 'Duration',
        'director_name' => 'Director Name',
        'actors_name' => 'Actors Name',
        'revenue' => 'Revenue',
        'budget' => 'Budget',
        'rating' => 'Rating',
        'synopsis' => 'Synopsis'
    );
    
    echo '<div id="tmdb-movie-data">';
    echo '<label for="tmdb_movie_id">TMDb Movie ID:</label>';
    echo '<input type="text" id="tmdb_movie_id" name="tmdb_movie_id" value="" />';
    echo '<button type="button" id="tmdb_fetch_data" class="button">Fetch Movie Data</button>';
    echo '<div id="tmdb-loading" style="display:none;">Loading...</div>';
    echo '<div id="tmdb-error" style="display:none;color:red;"></div>';
    
    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, '_tmdb_' . $key, true);
        echo '<div class="tmdb-field">';
        echo "<label for='tmdb_{$key}'>{$label}:</label>";
        echo "<input type='text' id='tmdb_{$key}' name='tmdb_{$key}' value='" . esc_attr($value) . "' />";
        echo '</div>';
    }
    
    echo '</div>';
}

function tmdb_save_custom_fields($post_id) {
    if (!isset($_POST['tmdb_custom_fields_nonce']) || !wp_verify_nonce($_POST['tmdb_custom_fields_nonce'], 'tmdb_save_custom_fields')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array(
        'movie_name',
        'release_date',
        'genre',
        'country_of_origin',
        'movie_poster',
        'movie_backdrop',
        'language',
        'duration',
        'director_name',
        'actors_name',
        'revenue',
        'budget',
        'rating',
        'synopsis'
    );
    
    foreach ($fields as $field) {
        if (isset($_POST['tmdb_' . $field])) {
            update_post_meta($post_id, '_tmdb_' . $field, sanitize_text_field($_POST['tmdb_' . $field]));
        }
    }
}