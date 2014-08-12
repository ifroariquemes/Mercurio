<?php

namespace controller\activity;

use model\activity\Activity;
use model\activity\type\Type;
use model\event\Event;
use model\user\User;

class ActivityController {

    const SESSIONKEY_ACTIVITIES = 'ACTIVITIES';

    public static function manage(Event $event) {
        global $_MyCookie;
        $_MyCookie->LoadView('activity', 'Manage', $event);
    }

    public static function add() {
        global $_MyCookie;
        $activity = new Activity;
        $_MyCookie->LoadView('activity', 'Edit', array('activity' => $activity, 'onSession' => false, 'iAct' => null));
    }

    public static function edit() {
        global $_MyCookie;
        $onSession = filter_input(INPUT_POST, 'onSession');
        $activity = ($onSession === 'false') ?
                Activity::select('a')->where('a.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult() :
                unserialize($_SESSION[self::SESSIONKEY_ACTIVITIES][filter_input(INPUT_POST, 'id')]);
        $_MyCookie->LoadView('activity', 'Edit', array('activity' => $activity, 'onSession' => $onSession, 'iAct' => filter_input(INPUT_POST, 'id')));
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
        $speakers = filter_input(INPUT_POST, 'Speakers', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (!empty($speakers)) {
            array_multisort($speakers);
            foreach ($speakers as $speaker) {
                $activity->addSpeaker($speaker);
            }
        }
        $iAct = uniqid();
        $_SESSION[self::SESSIONKEY_ACTIVITIES][$iAct] = serialize($activity);
        $_MyCookie->LoadView('activity', 'Manage.table', array('activity' => $activity, 'iAct' => $iAct));
    }

    public static function updateLine() {
        global $_MyCookie;
        $type = Type::select('t')->where('t.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'Type'))->getQuery()->getSingleResult();
        $onSession = filter_input(INPUT_POST, 'onSession');
        $activity = ($onSession === 'false') ?
                Activity::select('a')->where('a.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult() :
                unserialize($_SESSION[self::SESSIONKEY_ACTIVITIES][filter_input(INPUT_POST, 'iAct')]);
        $activity
                ->setName(filter_input(INPUT_POST, 'Name'))
                ->setDuration(filter_input(INPUT_POST, 'Duration'))
                ->setType($type)
                ->setHasCertificate(filter_input(INPUT_POST, 'Certificate') == 'true')
                ->setHasSubmissions(filter_input(INPUT_POST, 'Submissions') == 'true')
                ->setSpeakers(array());
        $speakers = filter_input(INPUT_POST, 'Speakers', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (!empty($speakers)) {
            array_multisort($speakers);
            foreach ($speakers as $speaker) {
                $activity->addSpeaker($speaker);
            }
        }
        if ($onSession === 'true') {
            $_SESSION[self::SESSIONKEY_ACTIVITIES][filter_input(INPUT_POST, 'iAct')] = serialize($activity);
        }
        $iAct = ($onSession === 'true') ? filter_input(INPUT_POST, 'iAct') : $activity->getId();
        $_MyCookie->LoadView('activity', 'Manage.table', array('activity' => $activity, 'iAct' => $iAct));
    }

    public static function createSpeakerLine() {
        global $_MyCookie;
        $name = filter_input(INPUT_POST, 'spkName');
        $_MyCookie->LoadView('activity', 'Speaker.line', $name);
    }

}
