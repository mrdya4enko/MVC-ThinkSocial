<?php
namespace App\Controllers;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:31
 */

Class PageController Extends BaseController
{
    protected function getTemplateNames()
    {
        $this->templateInfo['templateNames'] = array('head', 'navbar', 'leftcolumn', 'rightcolumn', 'footer');
    }
    protected function getTitle()
    {
        $this->templateInfo['title'] = 'ThinkSocial';
    }
    protected function getControllerVars()
    {
        $userId = \App\Models\User::checkLogged();

        $user = \App\Models\User::getByID($userId);
        $userAvatar = \App\Models\UserAvatar::getByForeign(array('user_id' => $userId), " AND status='active'");
        if (isset ($userAvatar->id)) {
            $commentAvatarNum = \App\Models\UserAvatarComment::count(array('user_avatar_id' => $userAvatar->id), "");
        }
        else $commentAvatarNum = 0;
        $userCities = \App\Models\UserCity::getByForeign(array('user_id' => $userId), " ORDER BY created_at");
        foreach ($userCities as $userCity) {
            $userCity->city = \App\Models\City::getByID($userCity->city_id);
            $userCity->country = \App\Models\Country::getByID($userCity->city->country_id);
        }
        $userGroups = \App\Models\UserGroup::getByForeign(array('user_id' => $userId), "");
        foreach ($userGroups as $userGroup) {
            $userGroup->group = \App\Models\Group::getByID($userGroup->group_id);
        }
        $userAlbums = \App\Models\AlbumUser::getByForeign(array('user_id' => $userId), "");
        $commentPhotosNum = 0;
        foreach ($userAlbums as $userAlbum) {
            $userAlbum->album = \App\Models\Album::getByID($userAlbum->album_id);
            $addCondition = " AND status='active'";
            $userAlbum->albumPhotos = \App\Models\AlbumPhoto::getByForeign(array('album_id' => $userAlbum->album_id), $addCondition);
            foreach ($userAlbum->albumPhotos as $albumPhoto) {
                $commentPhotosNum += \App\Models\AlbumPhotoComment::count(array('albums_photos_id' => $albumPhoto->id), "");
            }
        }
        $userNews = \App\Models\UserNews::getByForeign(array('user_id' => $userId), "");
        $commentNewsNum = 0;
        foreach ($userNews as $oneUserNews) {
            $oneUserNews->news = \App\Models\News::getByID($oneUserNews->news_id);
            $commentNewsNum += \App\Models\NewsComment::count(array('news_id' => $oneUserNews->news_id), "");
            $oneUserNews->newsComments = \App\Models\NewsComment::getByForeign(array('news_id' => $oneUserNews->news_id), ' LIMIT 3');
            foreach ($oneUserNews->newsComments as $newsComment) {
                $newsComment->comment = \App\Models\Comment::getByID($newsComment->comment_id);
            }
        }
        $friendReqs = \App\Models\Friend::getByForeign(array('user_receiver' => $userId), " AND status='unapplied' ORDER BY created_at DESC");
        foreach ($friendReqs as $friendReq) {
            $friendReq->sender = \App\Models\User::getByID($friendReq->user_sender);
            $friendReq->senderAvatar = \App\Models\UserAvatar::getByForeign(array('user_id' => $friendReq->user_sender), " AND status='active'");
        }
        $unreadMessagesNum = \App\Models\Message::count(array('receiver_id' => $userId), " AND status='unread'");
        $result = array ("unreadMessagesNum" => $unreadMessagesNum,
                         "commentPhotosNum" => $commentPhotosNum,
                         "commentNewsNum" => $commentNewsNum,
                         "commentAvatarNum" => $commentAvatarNum,
                         "user" => $user,
                         "userAvatar" => $userAvatar,
                         "userCities" => $userCities,
                         "userGroups" => $userGroups,
                         "userAlbums" => $userAlbums,
                         "userNews" => $userNews,
                         "friendReqs" => $friendReqs);
        return $result;
    }
}
