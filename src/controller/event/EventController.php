<?php

namespace controller\event;

use controller\user\UserController;
use model\event\Event;
use model\event\Organization;
use lib\util\Pagination;
use model\event\Activity;
use model\event\activity\Type;
use model\user\User;

class EventController
{

    public static function manage()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR', 'STAFF', 'USER');
        $_MyCookie->goBackTo('administrator');
        $urlPage = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
        $urlPage = ($urlPage) ? $urlPage : 1;
        $q = filter_input(INPUT_GET, 'q');
        if (empty($q)) {
            $events = Event::select('e')->add('orderBy', 'e.name ASC, e.isOpen DESC');
        } else {
            $events = Event::select('e')
                    ->where(Event::expr()->like('e.name', '?1'))
                    ->setParameter(1, sprintf('%%%s%%', $q));
        }
        $data = Pagination::paginate($events, $urlPage);
        $_MyCookie->loadView('event', 'manage'
                , array(
            'events' => $data,
            'currentPage' => $urlPage,
            'pages' => Pagination::getPages($data),
            'searchTerm' => $q));
    }

    public static function urlManage(Event $event, $register = false)
    {
        global $_MyCookie;
        global $_User;
        if ($_User->getAccountType()->getFlag() == 'ADMINISTRATOR' && !$register) {
            return $_MyCookie->mountLink('administrator', 'event', 'edit', $event->getId());
        } else {
            return $_MyCookie->mountLink('administrator', 'event', 'register', $event->getId());
        }
    }

    public static function add()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        $_MyCookie->goBackTo('administrator', 'event');
        $_SESSION[\controller\event\ActivityController::SESSIONKEY_ACTIVITIES] = array();
        $event = new Event;
        $_MyCookie->LoadView('event', 'edit', array('event' => $event, 'action' => 'add'));
    }

    public static function edit()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        $_MyCookie->goBackTo('administrator', 'event');
        $_SESSION[\controller\event\ActivityController::SESSIONKEY_ACTIVITIES] = array();
        $event = Event::select('e')->where('e.id = ?1')
                        ->setParameter(1, $_MyCookie->getURLVariables(2))->getQuery()->getSingleResult();
        $_MyCookie->LoadView('event', 'Edit', array('action' => 'edit', 'event' => $event));
    }

    public static function save()
    {
        UserController::checkAccessLevel('ADMINISTRATOR');
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
                ->setIsRegistrationOpen(filter_input(INPUT_POST, 'IsRegistrationOpen') === 'true')
                ->save();
        foreach (filter_input(INPUT_POST, 'Activity', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) as $act) {
            $id = $act['Id'];
            $activity = (empty($id)) ? new Activity : $event->getActivities()->filter(
                            function($entry) use ($id) {
                        return $entry->getId() == $id;
                    }
                    )->first();
            $type = Type::select('t')->where('t.id = ?1')->setParameter(1, $act['Type'])->getQuery()->getSingleResult();
            if (!isset($act['Speakers'])) {
                $act['Speakers'] = array();
            }
            $activity
                    ->setName($act['Name'])
                    ->setType($type)
                    ->setDuration($act['Duration'])
                    ->setDescription($act['Description'])
                    ->setSpeakers($act['Speakers'])
                    ->setHasCertificate($act['HasCertificate'] === 'true')
                    ->setHasSubmissions($act['HasSubmissions'] === 'true')
                    ->setVacancies($act['Vacancies']);
            foreach ($activity->getSessions() as $session) {
                $session->delete();
            }
            $activity->getSessions()->clear();
            if (isset($act['Sessions'])) {
                foreach ($act['Sessions'] as $session) {
                    $s = new \model\event\activity\Session;
                    $s
                            ->setDate($session['date'])
                            ->setStart($session['start'])
                            ->setEnd($session['end'])
                            ->setActivity($activity);
                    $activity->getSessions()->add($s);
                }
            }
            $activity->save();
        }
        ActivityController::updateDisable($event);
        $_SESSION[\controller\event\ActivityController::SESSIONKEY_ACTIVITIES] = null;
    }

    public static function delete()
    {
        UserController::checkAccessLevel('ADMINISTRATOR');
        Event::select('e')->where('e.id = ?1')
                ->setParameter(1, filter_input(INPUT_POST, 'id'))
                ->getQuery()->getSingleResult()->delete();
    }

    public static function select($organization)
    {
        global $_MyCookie;
        $organizations = Organization::select('o')->orderBy('o.name')->getQuery()->getResult();
        $id = (empty($organization)) ? null : $organization->getId();
        $_MyCookie->LoadView('organization', 'Select', array('organizations' => $organizations, 'id' => $id));
    }

    public static function register()
    {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR', 'STAFF', 'USER');
        $event = Event::select('e')->where('e.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(2))->getQuery()->getSingleResult();
        $_MyCookie->LoadView('event', 'register', $event);
    }

    public static function saveRegister($pUser = null)
    {
        global $_User;        
        UserController::checkAccessLevel('ADMINISTRATOR', 'STAFF', 'USER');
        $user = (is_null($pUser)) ? $_User : $pUser;
        $activities = filter_input(INPUT_POST, 'Activity', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $removedAct = $newAct = $stillInAct = $curAct = array();
        if (count($activities) > 0) {
            $event = Event::select('e')->where('e.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();
            foreach ($event->getActivities() as $activity) {
                if ($activity->getParticipants()->contains($user)) {
                    $selected = array_keys($activities, $activity->getId());
                    if (empty($selected)) {
                        array_push($removedAct, $activity);
                    } else {
                        array_push($stillInAct, $activity);
                    }
                } else if (in_array($activity->getId(), $activities)) {
                    if ($activity->hasVacancy()) {
                        array_push($newAct, $activity);
                    } else {
                        $t = new \lib\util\Translation;
                        echo $t->getTranslation('event', 'register.message.no_vacancy');
                        echo ':<br>- ' . $activity->getName();
                        exit;
                    }
                }
            }
            // Tests sessions colisions
            $curAct = array_merge($newAct, $stillInAct);
            foreach ($curAct as $actA) {
                foreach ($curAct as $actB) {
                    if ($actA != $actB) {
                        if (ActivityController::checkSessionCollision($actA->getSessions(), $actB->getSessions())) {
                            $t = new \lib\util\Translation;
                            echo $t->getTranslation('event', 'register.message.session_collision');
                            echo ':<br>- ' . $actA->getName() . ' => ' . $actB->getName();
                            exit;
                        }
                    }
                }
            }
            // Removes activities already registred
            foreach ($removedAct as $activity) {
                $activity->getParticipants()->remove($user);
                $activity->save();
            }
            // Register for new activities
            foreach ($newAct as $activity) {
                $activity->getParticipants()->add($user);
                $activity->save();
            }
            // Register in event
            if (!$event->getParticipants()->contains($user)) {
                $event->getParticipants()->add($user);
                $event->save();
            }
        }
    }

    public static function deleteRegistration()
    {
        global $_User;
        UserController::checkAccessLevel('ADMINISTRATOR', 'STAFF', 'USER');
        $event = Event::select('e')->where('e.id = ?1')->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();
        $event->getParticipants()->removeElement($_User);
        $event->save();
        foreach ($event->getActivities() as $activity) {
            $activity->getParticipants()->removeElement($_User);
            $activity->save();
        }
    }

    public static function printCertificates()
    {
        global $_MyCookie;
        include('vendor/dompdf/dompdf_config.inc.php');
        ini_set('memory_limit', '512M');
        set_time_limit(0);
        $users = User::select('u')->join('u.activities', 'a')->join('a.event', 'e')->where('e.id = ?1')->orderBy('u.id')
                        ->setParameter(1, $_MyCookie->getURLVariables(2))->getQuery()->getResult();
        $users = array_slice($users, 0, 4);
        $reg = 999; //O ultimo registro
        $pag = 51; //a ultima pagina
        $cert = 0;
        foreach ($users as $user) {
            $reg++;
            $cert++;
            $pag = $pag + (($cert - 1) % 3 == 0);
            $dom = new \DOMPDF();
            ob_start();
            $_MyCookie->LoadView('event', 'Certificate', array($user, $reg, $pag));
            $dom->load_html(ob_get_contents());
            ob_clean();
            $dom->set_paper('A4', 'landscape');
            $dom->render();
            $fp = fopen('src/controller/event/cert/' . $user->getId() . '-' . urlencode($user->getCompleteName()) . '.pdf', 'w+');
            fwrite($fp, $dom->output());
            fclose($fp);
        }
        exit;
    }

    public static function emailEverybody()
    {
        global $_MyCookie;
        set_time_limit(0);
        $users = User::select('u')->getQuery()->getResult();
        foreach ($users as $user) {
            $url = sprintf('%sadministrator/user/edit/%s', 'http://mercurio.natanaelsimoes.com/', $user->getId());
            require_once 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
            $mail = new \PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->Username = 'natanael.simoes@ifro.edu.br';
            $mail->Password = '145111nn';
            $mail->setFrom('natanael.simoes@ifro.edu.br', $user->getEmail());
            $mail->Subject = utf8_decode('Atualização no EIIFRO 2014');
            $mail->msgHTML(utf8_decode(<<<EOT
<p>Olá, {$user->getCompleteName()}!</p>
           
<p>Gostaríamos de agradecer por sua participação no I Encontro de Informática do Instituto Federal de Rondônia.</p>
<p>Estamos em fase de emissão dos certificados e precisamos saber para qual Campus enviar seu certificado. Clique no link abaixo e preencha o formulário com seu Campus, por favor:

<p><a href="$url">$url</a></p>               

<p><span style="font-size: small">Este é um e-mail automático. Não o responda.</span></p>
<hr>
Mercúrio - Sistema Gerenciador de Eventos<br>
<b>IFRO - Instituto Federal de Educação, Ciência e Tecnologia de Rondônia</b> - <i>Campus Ariquemes</i><br>
<a href="http://www.ifro.edu.br">http://www.ifro.edu.br</a>                
EOT
            ));
            $mail->addAddress($user->getEmail());
            $mail->send();
        }
    }
}