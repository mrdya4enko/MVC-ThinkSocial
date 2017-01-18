<?php
namespace App\Controllers;
use App\Models\{User, UserAvatarComment, UserCity,UserGroup, Friend,
    Message, City, AlbumUser, Album, UserNews, AlbumPhotoComment, NewsComment, Comment};


/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:31
 */

class PageController
{
    protected $userId;


    /**
     * Подготавливает итоговый массив переменных - результат работы контроллера
     *
     * @return array <p>Ассоциативный массив - итоговый набор переменных,
     * полученных в результате работы контроллера, включающий в себя массив
     * наименований шаблонов и title выводимого документа HTML</p>
     */
    public function actionIndex($id)
    {
        $templateNames = [
                          'head',
                          'navbar',
                          'leftcolumn',
                          'rightcolumn',
                          'footer',
                         ];
        $title = 'ThinkSocial';

        $this->userId = User::checkLogged();

        User::joinDB('users.id', 'users_avatars', 'user_id', ['id' => 'userAvatarId', 'file_name' => 'avatarFileName'],
            " AND users_avatars.status='active'");
        $user = User::getByID($this->userId);
        if (isset ($user->userAvatarId)) {
            $commentAvatarNum = UserAvatarComment::count(['userAvatarId' => $user->userAvatarId]);
        } else {
            $commentAvatarNum = 0;
            $user->avatarFileName = 'default.jpeg';
        }

        UserCity::join('cityId', 'App\Models\City', 'id');
        City::join('countryId', 'App\Models\Country', 'id');
        $userCities = UserCity::getByCondition(['userId' => $this->userId], ' ORDER BY created_at');

        UserGroup::join('groupId', 'App\Models\Group', 'id');
        $userGroups = UserGroup::getByCondition(['userId' => $this->userId]);

        AlbumUser::join('albumId', 'App\Models\Album', 'id');
        Album::join('id', 'App\Models\AlbumPhoto', 'albumId', " AND status='active'");
        $userAlbums = AlbumUser::getByCondition(['userId' => $this->userId]);
        $commentPhotosNum = 0;
        foreach ($userAlbums as $userAlbum) {
            foreach ($userAlbum->album->albumPhoto as $albumPhoto) {
                $commentPhotosNum += AlbumPhotoComment::count(['albumPhotoId' => $albumPhoto->id]);
            }
        }

        UserNews::join('newsId', 'App\Models\News', 'id');
        UserNews::join('newsId', 'App\Models\NewsComment', 'newsId', ' LIMIT 3');
        NewsComment::join('commentId', 'App\Models\Comment', 'id', " AND status='active'");
        Comment::join('userId', 'App\Models\User', 'id');
        $userNews = UserNews::getByCondition(['userId' => $this->userId]);

        $commentNewsNum = 0;
        foreach ($userNews as $oneUserNews) {
            $commentNewsNum += NewsComment::count(['newsId' => $oneUserNews->newsId]);
        }

        Friend::join('userSender', 'App\Models\User', 'id');
        $friendReqs = Friend::getByCondition(['userReceiver' => $this->userId, 'status' => 'unapplied'], ' ORDER BY created_at DESC');

        $unreadMessagesNum = Message::count(['receiverId' => $this->userId, 'status' => 'unread']);

        $result = compact('templateNames', 'title', 'unreadMessagesNum', 'commentPhotosNum',
            'commentNewsNum', 'commentAvatarNum', 'user', 'userCities', 'userGroups',
            'userAlbums', 'userNews', 'friendReqs');
        return $result;
    }
}
