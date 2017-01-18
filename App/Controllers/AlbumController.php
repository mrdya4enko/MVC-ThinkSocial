<?php
namespace App\Controllers;

use App\Models\{User, UserAvatarComment, UserCity,UserGroup, Friend,
    Message, City, AlbumUser, Album, UserNews, AlbumPhotoComment, News, NewsComment, Comment};

class AlbumController extends PageController
{
    public function actionIndex($id)
    {
        $result = parent::actionIndex($id);
        $result['templateNames'] = [
            'head',
            'navbar',
            'leftcolumn',
            'middlecolumnalbum',
            'rightcolumn',
            'footer',
        ];
        $result['albumId'] = $id;
        return $result;
    }
}
