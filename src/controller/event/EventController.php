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
        $events = Event::select('e')->where('e.isOpen = ?1')->orderBy('e.name')->setParameter(1, true)->getQuery()->getResult();
        $_MyCookie->LoadView('event', 'Manage', Pagination::paginate($events));
    }

    public static function search() {
        global $_MyCookie;
        global $_MyCookieUser;
        if ($_MyCookieUser->getAccountType()->getFlag() == 'ADMINISTRATOR') {
            $event = Event::select('e')->where(Event::expr()->like('e.name', '?1'))->orderBy('e.name')
                            ->setParameter(1, sprintf('%%%s%%', filter_input(INPUT_POST, 'name')))->getQuery()->getResult();
        } else {
            $event = Event::select('e')->where(Event::expr()->like('e.name', '?1'))->andWhere('e.isOpen = ?2')->orderBy('e.name')
                            ->setParameter(1, sprintf('%%%s%%', filter_input(INPUT_POST, 'name')))
                            ->setParameter(2, true)->getQuery()->getResult();
        }
        $pages = Pagination::paginate($event);
        if (count($pages) > 0) {
            $_MyCookie->LoadView('event', 'Manage.table', $pages);
        }
    }

    public static function urlManage(Event $event) {
        global $_MyCookie;
        global $_MyCookieUser;
        if ($_MyCookieUser->getAccountType()->getFlag() == 'ADMINISTRATOR') {
            return $_MyCookie->mountLink('administrator', 'event', 'edit', $event->getId());
        } else {
            return $_MyCookie->mountLink('administrator', 'event', 'register', $event->getId());
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
                ->setIsOpen(filter_input(INPUT_POST, 'IsOpen') === 'true')
                ->save();
        foreach (filter_input(INPUT_POST, 'Activity', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) as $act) {
            $activity = (empty($act['Id'])) ? new Activity : Activity::select('a')->where('a.id = ?1')->setParameter(1, $act['Id'])->getQuery()->getSingleResult();
            $type = Type::select('t')->where('t.id = ?1')->setParameter(1, $act['Type'])->getQuery()->getSingleResult();
            $activity
                    ->setName($act['Name'])
                    ->setType($type)
                    ->setDuration($act['Duration'])
                    ->setDescription($act['Description'])
                    ->setSpeakers($act['Speakers'])
                    ->setHasCertificate($act['HasCertificate'] === 'true')
                    ->setHasSubmissions($act['HasSubmissions'] === 'true')
                    ->setVacancies($act['Vacancies'])
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

    public static function register() {
        global $_MyCookie;
        \controller\administrator\AdministratorController::VerifyAdministratorLoggedIn();
        $event = Event::select('e')->where('e.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(2))->getQuery()->getSingleResult();
        $_MyCookie->LoadView('event', 'Register', $event);
    }

    public static function saveRegister() {
        global $_MyCookieUser;
        $activities = filter_input(INPUT_POST, 'Activity', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (count($activities) > 0) {
            $event = Event::select('e')->where('e.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();
            if (!$event->getParticipants()->contains($_MyCookieUser)) {
                $event->getParticipants()->add($_MyCookieUser);
                $event->save();
            }
            foreach ($event->getActivities() as $activity) {
                $activity->getParticipants()->removeElement($_MyCookieUser);
                $activity->save();
            }
            foreach ($activities as $act) {
                $activity = Activity::select('a')->where('a.id = ?1')->setParameter(1, $act)->getQuery()->getSingleResult();
                $activity->getParticipants()->add($_MyCookieUser);
                $activity->save();
            }
            _e('Register saved successfully', 'event');
        } else {
            _e('You need to select at least one activity to register in this event', 'event');
        }
    }

}
