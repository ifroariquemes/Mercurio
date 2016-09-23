<?php

namespace controller\index;

class IndexController extends \lib\util\Router
{

    public function showPage($view = null)
    {
        global $_Cache;
        global $_Async;
        global $_MyCookie;
        global $_BaseURL;
        global $_User;
        if(empty($_User) && $_MyCookie->getNamespace() !== 'controller\build') {
            ob_start();
            include('src/view/index/login.php');
            $view = ob_get_contents();
            ob_end_clean();
            $_Cache->doCache = false;
        }
        else if (is_null($view)) {
            ob_start();
            \controller\event\EventController::managePublic();
            $view = ob_get_contents();
            ob_end_clean();
            $_Cache->doCache = false;
        }
        if ($_Async) {
            $_Cache->doCache($view);
            echo $view;
        } else {
            ob_start();
            include('src/view/index/template.php');
            $page = ob_get_contents();
            ob_end_clean();
            $_Cache->doCache($page);
            echo $page;
        }
    }
}