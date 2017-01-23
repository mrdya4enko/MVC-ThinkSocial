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

    $('#addPhotos').on('click', function(e){
        e.preventDefault();
        $('#addPhotoBlock').toggleClass('active');
        $('#forFogging').toggleClass('fogging');
    });
    $('#cancelAddPhotoBlock').on('click', function(e){
        e.preventDefault();
        $('#addPhotoBlock').toggleClass('active');
        $('#forFogging').toggleClass('fogging');
    });
});
