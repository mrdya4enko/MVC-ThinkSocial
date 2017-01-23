        <!-- Middle Column -->
        <style>
            em.comment {
                margin-left: 4em;
            }
        </style>
        <div id="forFogging">

        </div>
        <div class="w3-col m7">

            <div class="w3-row-padding">
                <div class="w3-col m12">
                    <div class="w3-card-2 w3-round w3-white">
                        <div id="addAlbumBlock">
                            <a id="cancelAlbumBlock" href="#"><img src="/pictures/icon/cancel.png" alt="cancel"></a>
                            <form action="/album/update/<?=$albumId;?>" method="post" enctype="multipart/form-data">
                                <label for="albumName">New album name: </label>
                                <input type="text" id="albumName" name="newAlbumName" placeholder="New name" title="New name">
                                <input type="submit" value="Submit">
                                <input type="reset" value="Reset">
                            </form>
                        </div>
                        <div id="addPhotoBlock">
                            <a id="cancelAddPhotoBlock" href="#"><img src="/pictures/icon/cancel.png" alt="cancel"></a>
                            <form action="/album/insert/<?=$albumId;?>" method="post" enctype="multipart/form-data">
                                <input type="file" name='uploadPhoto[]' multiple>
                                <input type="submit" value="Submit">
                                <input type="reset" value="Reset">
                            </form>
                        </div>
                        <div class="w3-container w3-padding">
                            <a href="#" id="addAlbum" class="w3-btn w3-theme"><i class="fa fa-pencil"></i>   Edit album</a>
                            <a href="#" id="addPhotos" class="w3-btn w3-theme"><i class="fa fa-pencil"></i>   Add new photos</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php
            foreach ($userAlbums as $oneUserAlbum):
                if ($oneUserAlbum->album->id === $albumId):?>
                    <div class="w3-container w3-card-2 w3-white w3-round w3-margin">
                        <p><h3><?=$oneUserAlbum->album->name;?></h3></p>
                        <?php foreach ($oneUserAlbum->album->albumPhoto as $photo):?>
                            <div class="photo">
                                <img src="/photos/<?=$photo->fileName;?>" class="photoInAlbum w3-margin-bottom">
                                <a href="/album/delete/<?=$photo->id;?>"><img src="/pictures/icon/deleteIcon.png" class="deleteIcon"></a>
                            </div>
                        <?php endforeach;?>
                    </div>
                <?php endif;?>
            <?php endforeach;?>

            <!-- End Middle Column -->
        </div>
