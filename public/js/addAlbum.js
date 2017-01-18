$(function() {
    $('#addAlbum').on('click', function(e){
        e.preventDefault();
        $('#addAlbumBlock').toggleClass('active');
        $('#forFogging').toggleClass('fogging');
    });
    $('#cancelAlbumBlock').on('click', function(e){
        e.preventDefault();
        $('#addAlbumBlock').toggleClass('active');
        $('#forFogging').toggleClass('fogging');
    });
});
