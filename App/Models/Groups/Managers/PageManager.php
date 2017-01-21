<?php
namespace App\Models\Groups\Managers;

use App\Controllers\PageController;
use App\Models\Groups\Butler;

/**
 * Class GPController
 */

class PageManager extends PageController
{
    private $butler;

    /**
     * PageManager constructor.
     * @param Butler $butler
     */
    public function __construct(Butler $butler)
    {
        $this->butler = $butler;
    }

    /**
     * @return array
     */
    public function response()
    {
        if ($this->butler['GroupValidator']->isExists()) {
            if ($this->butler['UserValidator']->IsOwner()) {
                return $this->actionGroupOwner();
            } elseif ($this->butler['UserValidator']->IsSubscriber()) {
                return $this->actionGroupSubscriber();
            } else {
                return $this->actionGroupGuest();
            }
        } else {
            return $this->actionGroupIsNotExists();
        }
    }

    /**
     * Action of group owner
     */
    private function actionGroupOwner()
    {
        $response = parent::actionIndex();
        $response['templateNames'] = ['head',
            'navbar',
            'leftcolumn',
            'groups/management/groupPageContent',
            'groups/management/groupPageInfo'];
        $response['title'] = $this->butler['CurrentGroup']->name;
        return $response;
    }

    /**
     * Action of group Subscriber
     */

    private function actionGroupSubscriber()
    {
        $response = parent::actionIndex();
        $response['templateNames'] = ['head',
            'navbar',
            'leftcolumn'
        ];
        $response['title'] = $this->butler['CurrentGroup']->name;
        return $response;
    }

    /**
     * Action for group guest
     */

    private function actionGroupGuest()
    {
        $response = parent::actionIndex();
        $response['templateNames'] = ['head',
            'navbar',
            'leftcolumn'
        ];
        $response['title'] = $this->butler['CurrentGroup']->name;
        return $response;
    }

    /**
     * @return array
     */
    private function actionGroupIsNotExists()
    {
        $response = parent::actionIndex();
        $response['templateNames'] = ['head',
            'navbar',
            'leftcolumn'
        ];
        $response['title'] = "Group NoT Found";
        return $response;
    }
}
