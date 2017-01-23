<?php
namespace App\Controllers;

use App\Models\{News, NewsComment};

/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:31
 */

class SiteController extends PageController
{
    private function getNewsInfo()
    {
        News::joinDB('news.id', 'users_news', 'id', [], false, ' AND users_news.user_id=:userId');
        News::join('id', 'App\Models\NewsComment', 'newsId', ' ORDER BY comments.published DESC LIMIT 3');
        NewsComment::joinDB('news_comments.comment_id', 'comments', 'id', ['user_id' => 'userId',
            'text' => 'text', 'status' => 'status', 'published' => 'published']);
        NewsComment::joinDB('comments.user_id', 'users', 'id', ['first_name' => 'firstName', 'last_name' => 'lastName']);
        NewsComment::joinDB('users.id', 'users_avatars', 'user_id', ['file_name' => 'avatarFileName'],
            true, " AND users_avatars.status='active'");
        $news = News::getByCondition(['userId' => $this->userId]);

        foreach ($news as $oneNews) {
            foreach ($oneNews->newsComment as $oneComment) {
                if ($oneComment->status == 'block') {
                    $oneComment->text = '... <small>(комментарий пользователя был заблокирован)</small>';
                } elseif ($oneComment->status == 'delete') {
                    $oneComment->text = '... <small>(комментарий пользователя был удален)</small>';
                }
            }
        }

        return $news;
    }

    public function actionIndex()
    {
        $result = parent::actionIndex();
        $result['templateNames'] = [
                                    'head',
                                    'navbar',
                                    'leftcolumn',
                                    'middlecolumn',
                                    'rightcolumn',
                                    'footer',
                                   ];
        $result['news'] = $this->getNewsInfo();

        return $result;
    }
}
