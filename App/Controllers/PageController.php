<?php
namespace App\Controllers;

use App\Components\ActiveRecord;
use App\Models\{User, UserAvatarComment, Group, Friend, Message, City, Album, AlbumPhotoComment, NewsComment};

/**
 * PageController Class
 *
 * The base class for the page preparation. Extracts from the DB the information
 * necessary for the lefcolumn, rightcolumn, title and navbar and transfers it
 * to the Application
 *
 * @author A.Brichak <brichak.new@gmail.com>
 * @version 1.0
 */

class PageController
{
    /**
     * The ID of currently authorised user
     *
     * @var string
     */
    protected $userId;


    /**
     * Extracts from the DB information about user
     *
     * @return array <p>Array consisting of the object of class User and the
     * array of objects of class City, including the information about the user avatar file and country name</p>
     */
    private function getUserInfo()
    {
        User::joinDB('users.id', 'users_avatars', 'user_id', ['id' => 'userAvatarId', 'file_name' => 'avatarFileName'],
            true, " AND users_avatars.status='active'");
        $user = User::getByID($this->userId);

        $user->avatarFileName = $user->avatarFileName ?? 'default.jpeg';

        City::joinDB('cities.id', 'users_cities', 'city_id', [], false, ' AND users_cities.user_id=:userId');
        City::joinDB('cities.country_id', 'countries', 'id', ['name' => 'countryName']);
        $cities = City::getByCondition(['userId' => $this->userId], ' ORDER BY users_cities.created_at');

        return [$user, $cities];
    }


    private function getGroupsInfo()
    {
        Group::joinDB('groups.id', 'users_groups', 'group_id', [], false, ' AND users_groups.user_id=:userId');
        return Group::getByCondition(['userId' => $this->userId]);
    }


    private function getAlbumsInfo()
    {
        Album::joinDB('albums.id', 'albums_users', 'album_id', [], false, ' AND albums_users.user_id=:userId');
        Album::join('id', 'App\Models\AlbumPhoto', 'albumId', " AND status='active' LIMIT 1");
        $albums = Album::getByCondition(['userId' => $this->userId]);

        AlbumPhotoComment::joinDB('albums_photos_comments.comment_id', 'comments', 'id',
            [], false, ' AND TO_DAYS(NOW())-TO_DAYS(comments.published)<=30');
        AlbumPhotoComment::joinDB('albums_photos_comments.albums_photos_id', 'albums_photos', 'id');
        AlbumPhotoComment::joinDB('albums_photos.album_id', 'albums_users', 'album_id',
            [], false, ' AND albums_users.user_id=:userId');
        $commentPhotosNum = AlbumPhotoComment::count(['userId' => $this->userId]);

        return [$albums, $commentPhotosNum];
    }


    private function getNewsCommentsInfo()
    {
        NewsComment::joinDB('news_comments.comment_id', 'comments', 'id',
            [], false, ' AND TO_DAYS(NOW())-TO_DAYS(comments.published)<=30');
        NewsComment::joinDB('news_comments.news_id', 'users_news', 'news_id',
            [], false, ' AND users_news.user_id=:userId');
        return NewsComment::count(['userId' => $this->userId]);
    }


    private function getFriendRequestsInfo()
    {
        Friend::joinDB('friends.user_sender', 'users', 'id', ['first_name' => 'firstName', 'last_name' => 'lastName']);
        Friend::joinDB('users.id', 'users_avatars', 'user_id', ['file_name' => 'avatarFileName'],
            true, " AND users_avatars.status='active'");
        return Friend::getByCondition(['userReceiver' => $this->userId, 'status' => 'unapplied'], ' ORDER BY friends.created_at DESC');
    }


    public function actionIndex($id='')
    {
        $this->userId = User::checkLogged();

        $templateNames = [
                          'head',
                          'navbar',
                          'leftcolumn',
                          'rightcolumn',
                          'footer',
                         ];
        $title = 'ThinkSocial';

        list($user, $cities) = $this->getUserInfo();
        $commentAvatarNum = (isset ($user->userAvatarId))? UserAvatarComment::count(['userAvatarId' => $user->userAvatarId]) : 0;
        $groups = $this->getGroupsInfo();
        list($albums, $commentPhotosNum) = $this->getAlbumsInfo();
        $commentNewsNum = $this->getNewsCommentsInfo();
        $friendReqs = $this->getFriendRequestsInfo();
        $unreadMessagesNum = Message::count(['receiverId' => $this->userId, 'status' => 'unread']);

        $result = compact('templateNames', 'title', 'unreadMessagesNum', 'commentPhotosNum',
            'commentNewsNum', 'commentAvatarNum', 'user', 'cities', 'groups',
            'albums', 'friendReqs');

        ActiveRecord::clearJoins();
        ActiveRecord::clearJoinsDB();

        return $result;
    }
}
