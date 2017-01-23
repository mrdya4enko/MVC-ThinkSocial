<?php
namespace App\Models\Groups\Managers;

use App\Models\Groups\Butler;

class GetController implements GroupPageMethodController
{
    private $butler;

    public function __construct(Butler $butler)
    {
        $this->butler = $butler;
    }

    public function handleRequest()
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
        $response = $this->butler['PageController']->actionIndex();
        $response['templateNames'] = ['head',
            'navbar',
            'leftcolumn',
            'groups/management/groupPageContent',
            'groups/management/groupPageInfo'];
        $response['title'] = $this->butler['CurrentGroup']->name;
        $response['currentGroup'] = $this->butler['CurrentGroup'];
        return $response;
    }

    /**
     * Action of group Subscriber
     */

    private function actionGroupSubscriber()
    {
        $response = $this->butler['PageController']->actionIndex();
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
        $response = $this->butler['PageController']->actionIndex();
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
        $response = $this->butler['PageController']->actionIndex();
        $response['templateNames'] = ['head',
            'navbar',
            'leftcolumn'
        ];
        $response['title'] = "Group NoT Found";
        return $response;
    }

    public function methodCheck()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            return true;
        } else {
            return false;
        }
    }
}
