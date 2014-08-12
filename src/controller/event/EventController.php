<?php

namespace controller\event;

use model\event\Event;
use model\organization\Organization;
use lib\util\Pagination;
use model\activity\Activity;
use model\activity\type\Type;

class EventController {

    public static function manage() {
        global $_MyCookie;
        $_MyCookie->goBackTo('administrator');
        $events = Event::select('e')->orderBy('e.name')->getQuery()->getResult();
        $_MyCookie->LoadView('event', 'Manage', Pagination::paginate($events));
    }

    public static function search() {
        global $_MyCookie;
        $event = Event::select('e')->where(Event::expr()->like('e.name', '?1'))->orderBy('e.name')
                        ->setParameter(1, sprintf('%%%s%%', filter_input(INPUT_POST, 'name')))->getQuery()->getResult();
        $pages = Pagination::paginate($event);
        if (count($pages) > 0) {
            $_MyCookie->LoadView('event', 'Manage.table', $pages);
        }
    }

    public static function add() {
        global $_MyCookie;
        $_MyCookie->goBackTo('administrator', 'event');
        $_SESSION[\controller\activity\ActivityController::SESSIONKEY_ACTIVITIES] = array();
        $event = new Event;
        $_MyCookie->LoadView('event', 'Edit', array('event' => $event, 'action' => __('Add', 'event')));
    }

    public static function edit() {
        global $_MyCookie;
        $_MyCookie->goBackTo('administrator', 'event');
        $_SESSION[\controller\activity\ActivityController::SESSIONKEY_ACTIVITIES] = array();
        $event = Event::select('e')->where('e.id = ?1')
                        ->setParameter(1, $_MyCookie->getURLVariables(2))->getQuery()->getSingleResult();
        $_MyCookie->LoadView('event', 'Edit', array('action' => __('Edit', 'event'), 'event' => $event));
    }

    public static function save() {
        $event = (empty(filter_input(INPUT_POST, 'id'))) ? new Event : Event::select('e')->where('e.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();
        $organization = Organization::select('o')->where('o.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'organization'))->getQuery()->getSingleResult();
        $event
                ->setName(filter_input(INPUT_POST, 'Name'))
                ->setOrganization($organization)
                ->setDescription(filter_input(INPUT_POST, 'Description'))
                ->setStartDate(filter_input(INPUT_POST, 'StartDate'))
                ->setEndDate(filter_input(INPUT_POST, 'EndDate'))
                ->setAddress(filter_input(INPUT_POST, 'Address'))
                ->save();
        foreach (filter_input(INPUT_POST, 'Activity', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) as $act) {
            $activity = (empty($act['Id'])) ? new Activity : Activity::select('a')->where('a.id = ?1')->setParameter(1, $act['Id'])->getQuery()->getSingleResult();
            $type = Type::select('t')->where('t.id = ?1')->setParameter(1, $act['Type'])->getQuery()->getSingleResult();
            $activity
                    ->setName($act['Name'])
                    ->setType($type)
                    ->setDuration($act['Duration'])
                    ->setSpeakers($act['Speakers'])
                    ->setHasCertificate($act['HasCertificate'] === 'true')
                    ->setHasSubmissions($act['HasSubmissions'] === 'true')
                    ->setEvent($event)
                    ->save();
        }
        $_SESSION[\controller\activity\ActivityController::SESSIONKEY_ACTIVITIES] = null;
        _e('Event saved successfully!', 'event');
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
