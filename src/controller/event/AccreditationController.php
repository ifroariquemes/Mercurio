<?php

namespace controller\event;

use controller\user\UserController;
use model\event\Event;
use model\user\User;
use model\event\Activity;
use lib\util\Pagination;

class AccreditationController
{

    public static function participants()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR', 'STAFF');
        $_MyCookie->goBackTo('administrator', 'event');
        $urlPage = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
        $urlPage = ($urlPage) ? $urlPage : 1;
        $event = Event::select('e')->where('e.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(3))->getQuery()->getSingleResult();
        $q = filter_input(INPUT_GET, 'q');
        if (!empty($q)) {
            $pFilter = $event->getParticipants()->filter(
                    function($entry) use ($q) {
                return strpos(strtolower($entry->getName()), strtolower($q)) !== false;
            });
            $participants = $pFilter->slice(25 * ($urlPage - 1), 25);
        } else {
            $participants = $event->getParticipants()->slice(25 * ($urlPage - 1), 25);
        }
        $_MyCookie->loadView('event/accreditation', 'participants.manage', array(
            'event' => $event,
            'participants' => $participants,
            'currentPage' => $urlPage,
            'pages' => ceil($event->getParticipants()->count() / 25),
            'searchTerm' => !empty($q) ? $q : null));
    }

    public static function activities()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR', 'STAFF');
        $_MyCookie->goBackTo('administrator', 'event', 'accreditation', 'participants', $_MyCookie->getURLVariables(3));
        $event = Event::select('e')->where('e.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(3))->getQuery()->getSingleResult();
        $participant = User::select('u')->where('u.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(4))->getQuery()->getSingleResult();
        $_MyCookie->loadView('event/accreditation', 'participants.activities', array('event' => $event, 'participant' => $participant));
    }

    public static function override()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        $_MyCookie->goBackTo('administrator', 'event', 'accreditation', 'participants', $_MyCookie->getURLVariables(3));
        $event = Event::select('e')->where('e.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(3))->getQuery()->getSingleResult();
        $participant = User::select('u')->where('u.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(4))->getQuery()->getSingleResult();
        $_MyCookie->loadView('event/accreditation', 'participants.override', array('event' => $event, 'participant' => $participant));
    }

    public static function confirm()
    {
        UserController::checkAccessLevel('ADMINISTRATOR', 'STAFF');
        $participant = User::select('u')->where('u.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'participant'))->getQuery()->getSingleResult();
        EventController::saveRegister($participant);
        $event = Event::select('e')->where('e.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();        
        if (!$event->getConfirmed()->contains($participant)) {
            $event->getConfirmed()->add($participant);
            $event->save();
        }
    }

    public static function confirmOverride()
    {
        UserController::checkAccessLevel('ADMINISTRATOR');
        $activities = filter_input(INPUT_POST, 'Activity', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $participant = User::select('u')->where('u.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'participant'))->getQuery()->getSingleResult();
        if (count($activities) > 0) {
            $event = Event::select('e')->where('e.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();            
            foreach ($event->getActivities() as $activity) {
                $activity->getParticipants()->removeElement($participant);
                $activity->save();
            }
            foreach ($activities as $act) {
                $activity = Activity::select('a')->where('a.id = ?1')->setParameter(1, $act)->getQuery()->getSingleResult();
                $activity->getParticipants()->add($participant);
                $activity->save();
            }
        }
    }
}