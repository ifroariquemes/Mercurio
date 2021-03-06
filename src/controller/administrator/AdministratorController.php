<?php

namespace controller\administrator;

use lib\util\Router;
use controller\user\UserController;
use model\user\accountType\AccountType;

class AdministratorController extends Router
{
    private $userControl;

    public function __construct()
    {
        $this->userControl = new UserController();
    }

    public static function checkUserLoggedIn()
    {
        global $_Config;
        if ($_Config->allowPublicSignup) {
            if (!UserController::isUserLoggedIn()) {
                AdministratorController::showLogin();
                exit;
            }
        } else if (!UserController::isAdministratorLoggedIn()) {
            AdministratorController::showLogin();
            exit;
        }
    }

    public static function showLogin()
    {
        global $_MyCookie;
        global $_Cache;
        $account = AccountType::select('a')->getQuery()->execute();
        if (count($account) === 0) {
            UserController::firstRun();
        }
        header('Location:../');
    }

    public function showPage($view = null, $ajax = false)
    {
        global $_MyCookie;
        global $_Cache;
        $this->checkUserLoggedIn();
        if (is_null($view)) {
            ob_start();
            $_MyCookie->loadView('administrator', 'main');
            $view = ob_get_contents();
            ob_end_clean();
        }
        if ($ajax) {
            $_Cache->doCache($view);
            echo $view;
        } else {
            ob_start();
            $_MyCookie->loadTemplate('administrator', 'template', $view);
            $page = ob_get_contents();
            ob_end_clean();
            $_Cache->doCache($page);
            echo $page;
        }
    }
}