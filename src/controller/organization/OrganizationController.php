<?php

namespace controller\organization;

use model\organization\Organization;
use lib\util\Pagination;

class OrganizationController {

    public static function manage() {
        global $_MyCookie;
        $_MyCookie->goBackTo('administrator');
        $organizations = Organization::select('o')->orderBy('o.name')->getQuery()->getResult();
        $_MyCookie->LoadView('organization', 'Manage', Pagination::paginate($organizations));
    }

    public static function search() {
        global $_MyCookie;
        $organization = Organization::select('o')->where(Organization::expr()->like('o.name', '?1'))->orderBy('o.name')
                        ->setParameter(1, sprintf('%%%s%%', filter_input(INPUT_POST, 'name')))->getQuery()->getResult();
        $pages = Pagination::paginate($organization);
        if (count($pages) > 0) {
            $_MyCookie->LoadView('organization', 'Manage.table', $pages);
        }
    }

    public static function add() {
        global $_MyCookie;
        $_MyCookie->goBackTo('administrator', 'organization');
        $organization = new Organization;
        $_MyCookie->LoadView('organization', 'Edit', array('organization' => $organization, 'action' => __('Add', 'organization')));
    }

    public static function edit() {
        global $_MyCookie;
        $_MyCookie->goBackTo('administrator', 'organization');
        $organization = Organization::select('o')->where('o.id = ?1')
                        ->setParameter(1, $_MyCookie->getURLVariables(2))->getQuery()->getSingleResult();
        $_MyCookie->LoadView('organization', 'Edit', array('action' => __('Edit', 'organization'), 'organization' => $organization));
    }

    public static function save() {
        $organization = (empty(filter_input(INPUT_POST, 'id'))) ? new Organization : Organization::select('o')->where('o.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();
        $organization
                ->setName(filter_input(INPUT_POST, 'name'))
                ->setCity(filter_input(INPUT_POST, 'city'))
                ->setState(filter_input(INPUT_POST, 'state'))
                ->save();
        _e('Organization saved successfully!', 'organization');
    }

    public static function deleteMsg() {
        _e('Do you really want to delete this organization?', 'organization');
    }

    public static function delete() {
        Organization::select('o')->where('o.id = ?1')
                ->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult()->delete();
        _e('Organization deleted.', 'organization');
    }

    public static function select($organization) {
        global $_MyCookie;
        $organizations = Organization::select('o')->orderBy('o.name')->getQuery()->getResult();
        $id = (empty($organization)) ? null : $organization->getId();
        $_MyCookie->LoadView('organization', 'Select', array('organizations' => $organizations, 'id' => $id));
    }

}
