<?php
namespace App\Controllers;
use App\Components\ActiveRecord;
use App\Models\{User, UserAvatarComment, UserCity, Group, UserGroup, Friend,
    Message, City, AlbumUser, Album, UserNews, News, AlbumPhotoComment, NewsComment, Comment};


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
    public function actionIndex()
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
            true, " AND users_avatars.status='active'");
        $user = User::getByID($this->userId);
        if (isset ($user->userAvatarId)) {
            $commentAvatarNum = UserAvatarComment::count(['userAvatarId' => $user->userAvatarId]);
        } else {
            $commentAvatarNum = 0;
            $user->avatarFileName = 'default.jpeg';
        }

        City::joinDB('cities.id', 'users_cities', 'city_id', [], false, ' AND users_cities.user_id=:userId');
        City::joinDB('cities.country_id', 'countries', 'id', ['name' => 'countryName']);
        $cities = City::getByCondition(['userId' => $this->userId], ' ORDER BY users_cities.created_at');

        Group::joinDB('groups.id', 'users_groups', 'group_id', [], false, ' AND users_groups.user_id=:userId');
        $groups = Group::getByCondition(['userId' => $this->userId]);

        Album::joinDB('albums.id', 'albums_users', 'album_id', [], false, ' AND albums_users.user_id=:userId');
        Album::join('id', 'App\Models\AlbumPhoto', 'albumId', " AND status='active' LIMIT 1");
        $albums = Album::getByCondition(['userId' => $this->userId]);

        AlbumPhotoComment::joinDB('albums_photos_comments.comment_id', 'comments', 'id',
            [], false, ' AND TO_DAYS(NOW())-TO_DAYS(comments.published)<=30');
        AlbumPhotoComment::joinDB('albums_photos_comments.albums_photos_id', 'albums_photos', 'id');
        AlbumPhotoComment::joinDB('albums_photos.album_id', 'albums_users', 'album_id',
            [], false, ' AND albums_users.user_id=:userId');
        $commentPhotosNum = AlbumPhotoComment::count(['userId' => $this->userId]);

        News::joinDB('news.id', 'users_news', 'id', [], false, ' AND users_news.user_id=:userId');
        News::join('id', 'App\Models\NewsComment', 'newsId', ' ORDER BY comments.published DESC LIMIT 3');
        NewsComment::joinDB('news_comments.comment_id', 'comments', 'id', ['user_id' => 'userId',
            'text' => 'text', 'status' => 'status', 'published' => 'published']);
        NewsComment::joinDB('comments.user_id', 'users', 'id', ['first_name' => 'firstName', 'last_name' => 'lastName']);
        NewsComment::joinDB('users.id', 'users_avatars', 'user_id', ['file_name' => 'avatarFileName'],
            true, " AND users_avatars.status='active'");
        $news = News::getByCondition(['userId' => $this->userId]);

        $commentNewsNum = 0;
        foreach ($news as $oneNews) {
            $commentNewsNum += NewsComment::count(['newsId' => $oneNews->id]);
            foreach ($oneNews->newsComment as $oneComment) {
                if ($oneComment->status == 'block') {
                    $oneComment->text = '... <small>(комментарий пользователя был заблокирован)</small>';
                } elseif ($oneComment->status == 'delete') {
                    $oneComment->text = '... <small>(комментарий пользователя был удален)</small>';
                }
            }
        }

        Friend::joinDB('friends.user_sender', 'users', 'id', ['first_name' => 'firstName', 'last_name' => 'lastName']);
        Friend::joinDB('users.id', 'users_avatars', 'user_id', ['file_name' => 'avatarFileName'],
            true, " AND users_avatars.status='active'");
        $friendReqs = Friend::getByCondition(['userReceiver' => $this->userId, 'status' => 'unapplied'], ' ORDER BY friends.created_at DESC');

        $unreadMessagesNum = Message::count(['receiverId' => $this->userId, 'status' => 'unread']);

        $result = compact('templateNames', 'title', 'unreadMessagesNum', 'commentPhotosNum',
            'commentNewsNum', 'commentAvatarNum', 'user', 'cities', 'groups',
            'albums', 'news', 'friendReqs');

        ActiveRecord::clearJoins();
        ActiveRecord::clearJoinsDB();

        return $result;
    }
}
