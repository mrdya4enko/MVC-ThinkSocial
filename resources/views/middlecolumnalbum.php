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
                            <form action="" method="post" enctype="multipart/form-data">
                                <label for="albumName">Album name: </label>
                                <input type="text" id="albumName" name="albumName" placeholder="Name" title="Name">
                                <input type="file" name="photoForAlbum" accept="image/jpeg,image/png" multiple>
                                <input type="submit" value="Submit">
                                <input type="reset" value="Reset">
                            </form>
                        </div>
                        <div class="w3-container w3-padding">
                            <a href="#" id="addAlbum" class="w3-btn w3-theme"><i class="fa fa-pencil"></i>   Add album</a>
                        </div>
                    </div>
                </div>
            </div>


            <?php
            foreach ($userAlbums as $oneUserAlbum) {
                if ($oneUserAlbum->album->id === $albumId) {
                    echo <<<HEREDOC
                        <div class="w3-container w3-card-2 w3-white w3-round w3-margin"><br>
                            <p><h3>{$oneUserAlbum->album->name}</h3></p>
HEREDOC;
                    foreach ($oneUserAlbum->album->albumPhoto as $photo)
                    echo <<<HEREDOC
                            <img src="/public/photos/{$photo->fileName}" style="width:25%" class="w3-margin-bottom">
HEREDOC;
                    echo '</div>';
                }
            }
            ?>


            <!-- End Middle Column -->
        </div>
