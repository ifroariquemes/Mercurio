<?php

namespace controller\event;

use controller\user\UserController;
use model\event\Organization;
use lib\util\Pagination;

class OrganizationController
{

    public static function manage()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        $_MyCookie->goBackTo('administrator', 'event');
        $urlPage = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
        $urlPage = ($urlPage) ? $urlPage : 1;
        $organizations = Organization::select('o')->orderBy('o.name');
        $data = Pagination::paginate($organizations, $urlPage);
        $_MyCookie->loadView('event/organization', 'manage'
                , array(
            'organizations' => $data,
            'currentPage' => $urlPage,
            'pages' => Pagination::getPages($data)));
    }

    public static function search()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        $organization = Organization::select('o')
                        ->where(Organization::expr()->like('o.name', '?1'))
                        ->orderBy('o.name')
                        ->setParameter(1, sprintf('%%%s%%', filter_input(INPUT_POST, 'name')))->getQuery()->getResult();
        $pages = Pagination::paginate($organization);
        if (count($pages) > 0) {
            $_MyCookie->loadView('organization', 'manage.table', $pages);
        }
    }

    public static function add()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        $_MyCookie->goBackTo('administrator', 'event', 'organization');
        $organization = new Organization;
        $_MyCookie->loadView('event/organization', 'edit', array('organization' => $organization, 'action' => 'add'));
    }

    public static function edit()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        $_MyCookie->goBackTo('administrator', 'event', 'organization');
        $organization = Organization::select('o')->where('o.id = ?1')
                        ->setParameter(1, $_MyCookie->getURLVariables(3))->getQuery()->getSingleResult();
        $_MyCookie->loadView('event/organization', 'edit', array('action' => 'edit', 'organization' => $organization));
    }

    public static function save()
    {
        $organization = (empty(filter_input(INPUT_POST, 'id'))) ? new Organization : Organization::select('o')->where('o.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();
        $organization
                ->setName(filter_input(INPUT_POST, 'name'))
                ->setCity(filter_input(INPUT_POST, 'city'))
                ->setState(filter_input(INPUT_POST, 'state'))
                ->save();        
    }

    public static function deleteMsg()
    {
        _e('Do you really want to delete this organization?', 'organization');
    }

    public static function delete()
    {
        Organization::select('o')->where('o.id = ?1')
                ->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult()->delete();
        _e('Organization deleted.', 'organization');
    }

    public static function select($organization)
    {
        global $_MyCookie;
        $organizations = Organization::select('o')->orderBy('o.name')->getQuery()->getResult();
        $id = (empty($organization)) ? null : $organization->getId();
        $_MyCookie->LoadView('event/organization', 'select', array('organizations' => $organizations, 'id' => $id));
    }
}