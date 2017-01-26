<?php
namespace App\Controllers;

use App\Models\{
    Album, AlbumPhoto, AlbumUser, User
};

class AlbumController extends PageController
{
    public function actionIndex()
    {
        $id = func_get_arg(0);
        $result = parent::actionIndex();

        AlbumUser::join('albumId', 'App\Models\Album', 'id');
        Album::join('id', 'App\Models\AlbumPhoto', 'albumId', " AND status='active'");
        $result['userAlbums'] = AlbumUser::getByCondition(['userId' => $this->userId]);
        $userAlbum = Album::getByID($id);

        $result['templateNames'] = [
            'head',
            'navbar',
            'leftcolumn',
            'middlecolumnalbum',
            'rightcolumn',
            'footer',
        ];
        $result['title'] = $userAlbum->name;
        $result['albumId'] = $id;
        return $result;
    }

    public function actionInsertPhoto($id)
    {
        $this->userId = User::checkLogged();
        $count = count($_FILES['uploadPhoto']['name']);
        if (!isset($_FILES['uploadPhoto'])) {
            throw new \Exception('Photo required');
        }
        for ($i = 0; $i < $count; $i++) {
            $this->fileValidation($i);
            $path = ROOT . '/public/photos/';
            $ext = explode('.', $_FILES['uploadPhoto']['name'][$i]);
            $newName = md5(time() . $ext[0]) . '.' . $ext[1];
            $full_path = $path . $newName;
            if (!move_uploaded_file($_FILES['uploadPhoto']['tmp_name'][$i], $full_path)) {
                header('Location: /album/' . $id);
            }
            $newPhoto = new AlbumPhoto();
            $newPhoto->fileName = $newName;
            $newPhoto->albumId = $id;
            $newPhoto->status = 'active';
            $newPhoto->insert();
        }
            header('Location: /album/' . $id);
    }

    public function actionDeletePhoto($id)
    {
        $this->userId = User::checkLogged();

        $userPhoto = AlbumPhoto::getByID($id);
        AlbumPhoto::delete($id);
        header('Location: /album/' . $userPhoto->albumId);
    }
    
    public function actionUpdateAlbum($id)
    {
        $this->userId = User::checkLogged();
        $userAlbum = Album::getByID($id);
        $userAlbum->name = $_POST['newAlbumName'];
        $userAlbum->update();
        header('Location: /album/' . $id);
    }

    private function fileValidation($i)
    {
        $size = 1024 * 3 * 1024;//3 Mb
        $allowedExts = ['jpg', 'jpeg', 'gif', 'png'];
        $ext = explode('.', $_FILES['uploadPhoto']['name'][$i]);
        if ($_FILES['uploadPhoto']['size'][$i] > $size
            || $_FILES['uploadPhoto']['error'][$i] != 0
            || !in_array(end($ext), $allowedExts)
        ) {
            throw new \Exception('Size > 3 Mb OR some error occurred OR unsupported format');
        }
    }
}
