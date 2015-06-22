<?php

namespace controller\event;

use model\event\Activity;
use model\event\activity\Type;
use model\event\Event;
use model\event\activity\Session;
use controller\user\UserController;
use Doctrine\Common\Collections\ArrayCollection;

class ActivityController
{
    const SESSIONKEY_ACTIVITIES = 'ACTIVITIES';

    public static function type()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        $met = $_MyCookie->getURLVariables(3);
        \controller\event\activity\TypeController::$met();
    }

    public static function manage(Event $event)
    {
        global $_MyCookie;
        $_MyCookie->LoadView('event/activity', 'manage', $event);
    }

    public static function add()
    {
        global $_MyCookie;
        $activity = new Activity;
        $_MyCookie->LoadView('event/activity', 'edit', array('activity' => $activity, 'onSession' => false, 'iAct' => null));
    }

    public static function edit()
    {
        global $_MyCookie;
        $onSession = filter_input(INPUT_POST, 'onSession');
        $activity = ($onSession === 'false') ?
                Activity::select('a')->where('a.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult() :
                unserialize($_SESSION[self::SESSIONKEY_ACTIVITIES][filter_input(INPUT_POST, 'id')]);
        $_MyCookie->LoadView('event/activity', 'edit', array('activity' => $activity, 'onSession' => $onSession, 'iAct' => filter_input(INPUT_POST, 'id')));
    }

    public static function createLine()
    {
        global $_MyCookie;
        $type = Type::select('t')->where('t.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'Type'))->getQuery()->getSingleResult();
        $activity = new Activity();
        $activity
                ->setName(filter_input(INPUT_POST, 'Name'))
                ->setDuration(filter_input(INPUT_POST, 'Duration'))
                ->setDescription(filter_input(INPUT_POST, 'Description'))
                ->setType($type)
                ->setHasCertificate(filter_input(INPUT_POST, 'Certificate') == 'true')
                ->setHasSubmissions(filter_input(INPUT_POST, 'Submissions') == 'true')
                ->setVacancies(filter_input(INPUT_POST, 'Vacancies'));
        self::addSpeakers($activity);
        self::addSessions($activity);
        $iAct = uniqid();
        $_SESSION[self::SESSIONKEY_ACTIVITIES][$iAct] = serialize($activity);
        $_MyCookie->LoadView('event/activity', 'manage.table', array('activity' => $activity, 'iAct' => $iAct));
    }

    public static function updateLine()
    {
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
                ->setDescription(filter_input(INPUT_POST, 'Description'))
                ->setType($type)
                ->setHasCertificate(filter_input(INPUT_POST, 'Certificate') == 'true')
                ->setHasSubmissions(filter_input(INPUT_POST, 'Submissions') == 'true')
                ->setVacancies(filter_input(INPUT_POST, 'Vacancies'))
                ->setSpeakers(array())
                ->setSessions(new \Doctrine\Common\Collections\ArrayCollection);
        self::addSpeakers($activity);
        self::addSessions($activity);
        $_SESSION[self::SESSIONKEY_ACTIVITIES][filter_input(INPUT_POST, 'iAct')] = serialize($activity);
        $iAct = ($onSession === 'true') ? filter_input(INPUT_POST, 'iAct') : $activity->getId();
        $_MyCookie->LoadView('event/activity', 'manage.table', array('activity' => $activity, 'iAct' => $iAct, 'onSession' => true));
    }

    private static function addSpeakers(&$activity)
    {
        $speakers = filter_input(INPUT_POST, 'Speakers', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (!empty($speakers)) {
            array_multisort($speakers);
            foreach ($speakers as $speaker) {
                $activity->addSpeaker($speaker);
            }
        }
    }

    private static function addSessions(&$activity)
    {
        $sessions = filter_input(INPUT_POST, 'Sessions', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (!empty($sessions['date'])) {
            for ($i = 0, $max = count($sessions['date']); $i < $max; $i++) {
                $s = new \model\event\activity\Session;
                $s
                        ->setDate($sessions['date'][$i])
                        ->setStart($sessions['start'][$i])
                        ->setEnd($sessions['end'][$i]);
                $activity->addSession($s);
            }
        }
    }

    public static function createSpeakerLine()
    {
        global $_MyCookie;
        $name = filter_input(INPUT_POST, 'spkName');
        $_MyCookie->LoadView('event/activity', 'speaker.line', $name);
    }

    public static function createSessionLine()
    {
        global $_MyCookie;
        $session = new \model\event\activity\Session;
        $session
                ->setDate(filter_input(INPUT_POST, 'sesDate'))
                ->setStart(filter_input(INPUT_POST, 'sesStart'))
                ->setEnd(filter_input(INPUT_POST, 'sesEnd'));
        $_MyCookie->LoadView('event/activity', 'session.line', $session);
    }

    public static function updateDisable(Event $event)
    {
        UserController::checkAccessLevel('ADMINISTRATOR');        
        foreach ($event->getActivities() as $actA) {            
            $disable = array();
            foreach ($event->getActivities() as $actB) {                               
                if ($actA->getId() != $actB->getId()) {                    
                    if (self::checkSessionCollision($actA->getSessions(), $actB->getSessions())) {                        
                        array_push($disable, $actB->getId());
                    }
                }
            }
            $actA->setDisable($disable)->save();
        }
    }

    public static function checkSessionCollision($arSA, $arSB)
    {
        $t = 5;
        foreach ($arSA as $sA) {
            foreach ($arSB as $sB) {
                if ($sA->getDate() == $sB->getDate()) {                    
                    if ($sB->getStart(true) >= $sA->getStart(true) &&
                            $sB->getStart(true) < $sA->getEnd(true) - $t) {
                        return true;
                    }
                    if ($sB->getStart(true) < $sA->getStart(true) &&
                            $sB->getEnd(true) > $sA->getStart(true) + $t) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}