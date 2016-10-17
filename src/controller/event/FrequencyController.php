<?php

namespace controller\event;

use model\event\Event;
use model\event\Activity;
use controller\user\UserController;

class FrequencyController
{

    public static function manage()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR', 'STAFF');
        $_MyCookie->goBackTo('administrator', 'event');
        $event = Event::select('e')->where('e.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(3))->getQuery()->getSingleResult();
        $_MyCookie->loadView('event/frequency', 'activities.manage', $event);
    }

    public static function activity()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR', 'STAFF');
        $activity = Activity::select('a')->where('a.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(3))->getQuery()->getSingleResult();
        $_MyCookie->goBackTo('administrator', 'event', 'frequency', 'manage', $activity->getEvent()->getId());
        $_MyCookie->LoadView('event/frequency', 'frequency.manage', $activity);
    }

    public static function check()
    {
        UserController::checkAccessLevel('ADMINISTRATOR', 'STAFF');
        $activity = Activity::select('a')->where('a.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'activity'))->getQuery()->getSingleResult();
        $participant = \model\user\User::select('u')->where('u.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'participant'))->getQuery()->getSingleResult();
        $activity->getPresent()->add($participant);
        $activity->save();
    }

    public static function uncheck()
    {
        UserController::checkAccessLevel('ADMINISTRATOR', 'STAFF');
        $activity = Activity::select('a')->where('a.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'activity'))->getQuery()->getSingleResult();
        $participant = \model\user\User::select('u')->where('u.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'participant'))->getQuery()->getSingleResult();
        $activity->getPresent()->removeElement($participant);
        $activity->save();
    }

    public static function printList()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR', 'STAFF');
        $activity = Activity::select('a')->where('a.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(3))->getQuery()->getSingleResult();
        $_MyCookie->LoadView('event/frequency', 'print', $activity);
    }

    public static function removeParticipant()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        $activity = Activity::select('a')->where('a.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'activity'))->getQuery()->getSingleResult();
        $user = \model\user\User::select('u')->where('u.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'user'))->getQuery()->getSingleResult();
        $activity->getParticipants()->removeElement($user);
        $activity->save();
    }

    public static function removeAllParticipantsNotConfirmed()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        $activity = Activity::select('a')->where('a.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'activity'))->getQuery()->getSingleResult();
        foreach ($activity->getParticipantsNotConfirmed() as $participant) {
            $activity->getParticipants()->removeElement($participant);
        }
        $activity->save();
    }

}
