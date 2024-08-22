<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// AJAX handler for fetching movie data
add_action('wp_ajax_tmdb_fetch_movie_data', 'tmdb_fetch_movie_data_ajax');

function tmdb_fetch_movie_data_ajax() {
    check_ajax_referer('tmdb-ajax-nonce', 'nonce');
    
    $movie_id = isset($_POST['movie_id']) ? intval($_POST['movie_id']) : 0;
    
    if ($movie_id) {
        $movie_data = tmdb_fetch_movie_data($movie_id);
        
        if ($movie_data) {
            wp_send_json_success($movie_data);
        } else {
            wp_send_json_error('Failed to fetch movie data.');
        }
    } else {
        wp_send_json_error('Invalid movie ID.');
    }
}

// Function to fetch movie data from TMDb API
function tmdb_fetch_movie_data($movie_id) {
    $api_key = get_option('tmdb_api_key');
    $api_url = "https://api.themoviedb.org/3/movie/{$movie_id}?api_key={$api_key}&append_to_response=credits";
    
    $response = wp_remote_get($api_url);
    
    if (is_wp_error($response)) {
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (isset($data['id'])) {
        $movie_data = array(
            'movie_name' => $data['title'],
            'release_date' => $data['release_date'],
            'genre' => implode(', ', array_column($data['genres'], 'name')),
            'country_of_origin' => isset($data['production_countries'][0]['name']) ? $data['production_countries'][0]['name'] : '',
            'movie_poster' => 'https://image.tmdb.org/t/p/w500' . $data['poster_path'],
            'movie_backdrop' => 'https://image.tmdb.org/t/p/w1280' . $data['backdrop_path'],
            'language' => isset($data['spoken_languages'][0]['name']) ? $data['spoken_languages'][0]['name'] : '',
            'duration' => $data['runtime'],
            'director_name' => '',
            'actors_name' => '',
            'revenue' => $data['revenue'],
            'budget' => $data['budget'],
            'rating' => $data['vote_average'],
            'synopsis' => $data['overview']  
        );
        
        // Get director and actors
        if (isset($data['credits']['crew'])) {
            foreach ($data['credits']['crew'] as $crew_member) {
                if ($crew_member['job'] === 'Director') {
                    $movie_data['director_name'] = $crew_member['name'];
                    break;
                }
            }
        }
        
        if (isset($data['credits']['cast'])) {
            $actors = array_slice($data['credits']['cast'], 0, 5);
            $movie_data['actors_name'] = implode(', ', array_column($actors, 'name'));
        }
        
        return $movie_data;
    }
    
    return false;
}