<?php

namespace controller\frequency;

use model\event\Event;
use model\activity\Activity;
use lib\util\Pagination;

class FrequencyController {

    public static function manage() {
        global $_MyCookie;
        $_MyCookie->goBackTo('administrator');
        $events = Event::select('e')->where('e.startDate >= ?1')->andWhere('e.endDate + 2 >= ?1')->orderBy('e.name')->setParameter(1, new \DateTime)->getQuery()->getResult();
        $_MyCookie->LoadView('frequency', 'Manage', Pagination::paginate($events));
    }

    public static function search() {
        
    }

    public static function event() {
        global $_MyCookie;
        $_MyCookie->goBackTo('administrator', 'frequency');
        $event = Event::select('e')->where('e.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(2))->getQuery()->getSingleResult();
        $_MyCookie->LoadView('frequency', 'Activities.manage', $event);
    }

    public static function activity() {
        global $_MyCookie;
        $activity = Activity::select('a')->where('a.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(2))->getQuery()->getSingleResult();
        $_MyCookie->goBackTo('administrator', 'frequency', 'event', $activity->getEvent()->getId());        
        $_MyCookie->LoadView('frequency', 'Frequency.manage', $activity);
    }

}
