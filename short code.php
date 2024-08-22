<?php
$fields = array(
    'movie_name' => 'Movie Name',
    'release_date' => 'Release Date',
    'genre' => 'Genre',
    'country_of_origin' => 'Country of Origin',
    'movie_poster' => 'Movie Poster',
    'movie_backdrop' => 'Movie Backdrop',
    'language' => 'Language',
    'duration' => 'Duration',
    'director_name' => 'Director',
    'actors_name' => 'Cast',
    'revenue' => 'Revenue',
    'budget' => 'Budget',
    'rating' => 'Rating',
	'synopsis' => 'Synopsis'
);

echo '<div class="movie-details">';
foreach ($fields as $key => $label) {
    $value = get_post_meta(get_the_ID(), '_tmdb_' . $key, true);
    if (!empty($value)) {
        echo '<div class="movie-detail">';
        echo '<strong>' . esc_html($label) . ':</strong> ';
        if ($key === 'movie_poster' || $key === 'movie_backdrop') {
            echo '<img src="' . esc_url($value) . '" alt="' . esc_attr($label) . '" />';
        } elseif ($key === 'duration') {
            echo esc_html($value) . ' minutes';
        } elseif ($key === 'revenue' || $key === 'budget') {
            echo '$' . number_format($value);
        } elseif ($key === 'rating') {
            echo esc_html($value) . '/10';
        } elseif ($key === 'synopsis') {
            echo '<p>' . esc_html($value) . '</p>';
        } else {
            echo esc_html($value);
        }
        echo '</div>';
    }
}
echo '</div>';
?>
