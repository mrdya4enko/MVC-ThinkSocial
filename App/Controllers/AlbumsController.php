<?php
namespace App\Controllers;

use App\Models\{User, UserAvatarComment, UserCity,UserGroup, Friend,
    Message, City, AlbumUser, Album, AlbumPhoto, UserNews, AlbumPhotoComment, News, NewsComment, Comment};

class AlbumsController extends PageController
{
    public function actionIndex($id='')
    {
        $result = parent::actionIndex($id);
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

        /*AlbumUser::join('albumId', 'App\Models\Album', 'id');
        Album::join('id', 'App\Models\AlbumPhoto', 'albumId', " AND status='active'");
        $album = Album::getByCondition(['name' => $newAlbum->name]);
        print_r($album);exit;
        $newAlbumUser = new AlbumUser();
        $newAlbumUser->userId = $this->userId;
        $newAlbumUser->albumId =;
        $newAlbumUser->insert();*/
        header('Location: /albums/');
    }
}
