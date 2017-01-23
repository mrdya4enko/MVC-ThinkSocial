<?php
namespace App\Controllers;

use App\Models\{
    Album, AlbumPhoto, AlbumUser, User
};

class AlbumsController extends PageController
{
    public function actionIndex()
    {
        $result = parent::actionIndex();

        AlbumUser::join('albumId', 'App\Models\Album', 'id');
        Album::join('id', 'App\Models\AlbumPhoto', 'albumId', " AND status='active'");
        $result['albumsUsers'] = AlbumUser::getByCondition(['userId' => $this->userId]);

        $result['templateNames'] = [
            'head',
            'navbar',
            'leftcolumn',
            'middlecolumnalbums',
            'rightcolumn',
            'footer',
        ];
        return $result;
    }

    public function actionInsert()
    {
        $this->userId = User::checkLogged();

        $newAlbum = new Album();
        $newAlbum->name = $_POST['albumName'];
        $newAlbum->insert();
        $newAlbumUser = new AlbumUser();
        $newAlbumUser->userId = $this->userId;
        $newAlbumUser->albumId = $newAlbum->id;
        $newAlbumUser->insert();
        header('Location: /album/' . $newAlbum->id);
    }

    public function actionDeleteAlbum($id)
    {
        $this->userId = User::checkLogged();
        AlbumUser::join('albumId', 'App\Models\Album', 'id');
        Album::join('id', 'App\Models\AlbumPhoto', 'albumId', " AND status='active'");
        $userAlbumPhotos = AlbumUser::getByCondition(['userId' => $this->userId, 'albumId' => $id]);
        if(isset($userAlbumPhotos[0])) {
            foreach ($userAlbumPhotos[0]->album->albumPhoto as $photo) {
                AlbumPhoto::delete($photo->id);
            }
        }
        $userAlbum = AlbumUser::getByCondition(['userId' => $this->userId, 'albumId' => $id]);
        if(!isset($userAlbum[0])) {
            throw new \Exception('userAlbum not found');
        } else {
            AlbumUser::delete((int)$userAlbum[0]->id);
            Album::delete($id);
        }
        header('Location: /albums/');
    }
    
}
