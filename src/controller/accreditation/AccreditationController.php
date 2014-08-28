<?php

namespace controller\accreditation;

use model\event\Event;
use model\user\User;
use model\activity\Activity;
use lib\util\Pagination;

class AccreditationController {

    public static function searchEvent() {
        global $_MyCookie;
        $event = Event::select('e')->where(Event::expr()->like('e.name', '?1'))->andWhere('e.startDate - 1 <= ?2')->andWhere('e.endDate >= ?2')->orderBy('e.name')
                        ->setParameter(1, sprintf('%%%s%%', filter_input(INPUT_POST, 'name')))
                        ->setParameter(2, new \DateTime)->getQuery()->getResult();
        $pages = Pagination::paginate($event);
        if (count($pages) > 0) {
            $_MyCookie->LoadView('accreditation', 'Manage.table', $pages);
        }
    }

    public static function search() {
        global $_MyCookie;
        $event = Event::select('e')->join('e.participants', 'p')->where(Event::expr()->like('p.name', '?1'))->orWhere(Event::expr()->like('p.lastName', '?1'))->orderBy('e.name')
                        ->setParameter(1, sprintf('%%%s%%', filter_input(INPUT_POST, 'name')))->getQuery()->getResult();
        if (count($event) && !empty($event[0]->getParticipants())) {
            $_MyCookie->LoadView('accreditation', 'Participants.table', $event[0]);
        }
    }

    public static function manage() {
        global $_MyCookie;
        $_MyCookie->goBackTo('administrator');
        $events = Event::select('e')->where('e.startDate - 1 >= ?1')->andWhere('e.endDate >= ?1')->orderBy('e.name')->setParameter(1, new \DateTime)->getQuery()->getResult();
        $_MyCookie->LoadView('accreditation', 'Manage', Pagination::paginate($events));
    }

    public static function participants() {
        global $_MyCookie;
        $_MyCookie->goBackTo('administrator', 'accreditation');
        $event = Event::select('e')->where('e.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(2))->getQuery()->getSingleResult();
        $_MyCookie->LoadView('accreditation', 'Participants.manage', $event);
    }

    public static function activities() {
        global $_MyCookie;
        $_MyCookie->goBackTo('administrator', 'accreditation', 'participants', $_MyCookie->getURLVariables(2));
        $event = Event::select('e')->where('e.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(2))->getQuery()->getSingleResult();
        $participant = User::select('u')->where('u.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(3))->getQuery()->getSingleResult();
        $_MyCookie->LoadView('accreditation', 'Participants.activities', array('event' => $event, 'participant' => $participant));
    }

    public static function confirm() {
        $activities = filter_input(INPUT_POST, 'Activity', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $participant = User::select('u')->where('u.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'participant'))->getQuery()->getSingleResult();
        if (count($activities) > 0) {
            $event = Event::select('e')->where('e.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'event'))->getQuery()->getSingleResult();
            if (!$event->getConfirmed()->contains($participant)) {
                $event->getConfirmed()->add($participant);
                $event->save();
            }
            if (!$event->getParticipants()->contains($participant)) {
                $event->getParticipants()->add($participant);
                $event->save();
            }
            foreach ($event->getActivities() as $activity) {
                $activity->getParticipants()->removeElement($participant);
                $activity->save();
            }
            foreach ($activities as $act) {
                $activity = Activity::select('a')->where('a.id = ?1')->setParameter(1, $act)->getQuery()->getSingleResult();
                $activity->getParticipants()->add($participant);
                $activity->save();
            }
            _e('Credentials confirmed successfully', 'accreditation');
        } else {
            _e('You need to select at least one activity to confirm credentials in this event', 'accreditation');
        }
    }

}
