<?php
use App\Controllers\PageController;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: phpstudent
 * Date: 13.01.17
 * Time: 16:08
 */


class PageControllerTest extends TestCase
{
    public function testIndexAction()
    {
        $pageController = new PageController();
        ob_start();
        $pageController->show();
        $result = ob_get_clean();
        $this->assertEquals('This is PageController, method show', $result);
    }
}