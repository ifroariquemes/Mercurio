<?php

namespace controller\event;

use lib\util\Pagination;
use controller\user\UserController;
use model\event\Organization;
use model\event\CertificateTemplate;

class CertificateController
{

    public static function templates()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        $_MyCookie->goBackTo('administrator', 'event', 'organization', 'manage');
        $oId = $_MyCookie->getURLVariables(3);
        $organization = Organization::select('o')->where('o.id = ?1')
                        ->setParameter(1, $oId)->getQuery()->getSingleResult();
        $_MyCookie->loadView('event/certificate', 'manage', $organization);
    }

    public static function add()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        $oId = $_MyCookie->getURLVariables(3);
        $_MyCookie->goBackTo('administrator', 'event', 'certificate', 'templates', $oId);
        $organization = Organization::select('o')->where('o.id = ?1')
                        ->setParameter(1, $oId)->getQuery()->getSingleResult();
        $_MyCookie->loadView('event/certificate', 'edit', array(
            'action' => 'add',
            'certTemplate' => new CertificateTemplate(),
            'organization' => $organization
        ));
    }

    public static function generate()
    {
        global $_MyCookie;
        global $_User;
        $eId = $_MyCookie->getURLVariables(3);
        $event = \model\event\Event::select('e')->where('e.id = ?1')
                        ->setParameter(1, $eId)->getQuery()->getSingleResult();
        $user = \model\user\User::select('u')->join('u.activities', 'a')->join('a.event', 'e', \Doctrine\ORM\Query\Expr\Join::WITH, 'e.id = ?1')
                        ->where('u.id = ?2')
                        ->setParameter(1, $eId)
                        ->setParameter(2, $_User->getId())
                        ->getQuery()->getSingleResult();
        foreach ($user->getActivities() as $act) {
            if ($act->getPresent()->contains($user)) {
                echo 'p';
            }
        }
    }

}
