jQuery(document).ready(function($) {
    $('#tmdb_fetch_data').on('click', function() {
        var movieId = $('#tmdb_movie_id').val();
        
        if (!movieId) {
            alert('Please enter a TMDb Movie ID.');
            return;
        }
        
        $('#tmdb-loading').show();
        $('#tmdb-error').hide();
        
        $.ajax({
            url: tmdbAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'tmdb_fetch_movie_data',
                nonce: tmdbAjax.nonce,
                movie_id: movieId
            },
            success: function(response) {
                if (response.success) {
                    var data = response.data;
                    for (var key in data) {
                        $('#tmdb_' + key).val(data[key]);
                    }
                } else {
                    $('#tmdb-error').text(response.data).show();
                }
            },
            error: function() {
                $('#tmdb-error').text('An error occurred. Please try again.').show();
            },
            complete: function() {
                $('#tmdb-loading').hide();
            }
        });
    });
});
