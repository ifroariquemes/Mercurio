<?php

namespace controller\activity;

use model\activity\Activity;
use model\activity\type\Type;
use model\event\Event;
use model\user\User;

class ActivityController {

    public static function manage(Event $event) {
        global $_MyCookie;        
        $_MyCookie->LoadView('activity', 'Manage', $event);
    }

    public static function add() {
       global $_MyCookie; 
        $_MyCookie->LoadView('activity', 'Edit');
    }

    public static function createLine() {
        global $_MyCookie;
        $type = Type::select('t')->where('t.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'Type'))->getQuery()->getSingleResult();
        $activity = new Activity();
        $activity
                ->setName(filter_input(INPUT_POST, 'Name'))
                ->setDuration(filter_input(INPUT_POST, 'Duration'))
                ->setType($type)
                ->setHasCertificate(filter_input(INPUT_POST, 'Certificate') == 'true')
                ->setHasSubmissions(filter_input(INPUT_POST, 'Submissions') == 'true');
        foreach (filter_input(INPUT_POST, 'Speakers', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) as $speaker) {
            $activity->addSpeaker(User::select('u')->where('u.id = ?1')->setParameter(1, $speaker)->getQuery()->getSingleResult());
        }
        $_MyCookie->LoadView('activity', 'Manage.table', array('activity' => $activity, 'iAct' => uniqid()));
    }

    public static function createSpeakerLine() {
        global $_MyCookie;
        $user = User::select('u')->where('u.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'user'))->getQuery()->getSingleResult();
        $_MyCookie->LoadView('activity', 'Speaker.line', $user);
    }

}
