<?php

namespace controller\event;

use controller\user\UserController;
use model\event\Event;
use model\event\Organization;
use lib\util\Pagination;
use model\event\Activity;
use model\event\activity\Type;
use model\user\User;

class EventController {

    public static function manage() {
        global $_MyCookie;
        global $_User;
        UserController::checkAccessLevel('ADMINISTRATOR', 'STAFF', 'USER');
        if ($_User->getAccountType()->getFlag() == 'USER') {
            $this->managePublic();
        }
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

    public static function managePublic() {
        global $_MyCookie;
        global $_User;
        global $_BaseURL;
        if (!isset($_User)) {
            $_MyCookie->loadView('index', 'login');
        } else if (UserController::isAdministratorLoggedIn()) {
            header("location: {$_BaseURL}administrator/");
        } else {
            $_MyCookie->goBackTo('');
            $events = Event::select('e')->where('e.isRegistrationOpen = ?1')
                            ->setParameter(1, true)
                            ->add('orderBy', 'e.name ASC')
                            ->getQuery()->getResult();
            $_MyCookie->loadView('event', 'managePublic', ['events' => $events]);
        }
    }

    public static function urlManage(Event $event, $register = false) {
        global $_MyCookie;
        global $_User;
        if ($_User->getAccountType()->getFlag() == 'ADMINISTRATOR' && !$register) {
            return $_MyCookie->mountLink('administrator', 'event', 'edit', $event->getId());
        } else {
            return $_MyCookie->mountLink('administrator', 'event', 'register', $event->getId());
        }
    }

    public static function add() {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        $_MyCookie->goBackTo('administrator', 'event');
        $_SESSION[\controller\event\ActivityController::SESSIONKEY_ACTIVITIES] = array();
        $event = new Event;
        if ($_MyCookie->getURLVariables(2)) {
            $organization = Organization::select('c')->where('c.id = ?1')
                            ->setParameter(1, $_MyCookie->getURLVariables(2))
                            ->getQuery()->getOneOrNullResult();
            $event->setOrganization($organization);
        }
        $_MyCookie->LoadView('event', 'edit', array('event' => $event, 'action' => 'add'));
    }

    public static function edit() {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        $_MyCookie->goBackTo('administrator', 'event');
        $_SESSION[\controller\event\ActivityController::SESSIONKEY_ACTIVITIES] = array();
        $event = Event::select('e')->where('e.id = ?1')
                        ->setParameter(1, $_MyCookie->getURLVariables(2))->getQuery()->getSingleResult();
        $_MyCookie->LoadView('event', 'edit', array('action' => 'edit', 'event' => $event));
    }

    public static function save() {
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
                    ->setEvent($event)
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

    public static function delete() {
        UserController::checkAccessLevel('ADMINISTRATOR');
        Event::select('e')->where('e.id = ?1')
                ->setParameter(1, filter_input(INPUT_POST, 'id'))
                ->getQuery()->getSingleResult()->delete();
    }

    public static function select($organization) {
        global $_MyCookie;
        $organizations = Organization::select('o')->orderBy('o.name')->getQuery()->getResult();
        $id = (empty($organization)) ? null : $organization->getId();
        $_MyCookie->LoadView('organization', 'Select', array('organizations' => $organizations, 'id' => $id));
    }

    public static function register() {
        global $_MyCookie;
        global $_User;
        if (!isset($_User)) {
            $_MyCookie->loadView('index', 'login');
        } else {
            UserController::checkAccessLevel('ADMINISTRATOR', 'USER');
            $event = Event::select('e')->where('e.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(2))->getQuery()->getSingleResult();
            $eventDetail = self::getEventDetail($event);
            $_MyCookie->LoadView('event', 'register', ['event' => $event, 'eventDetail' => $eventDetail]);
        }
    }

    public static function getEventDetail(Event $event) {
        $stDate = date_create_from_format('d/m/Y H:i', $event->getStartDate() . ' 00:00');
        $enDate = date_create_from_format('d/m/Y H:i', $event->getEndDate() . ' 23:59');
        $eventDetail = array();
        while ($stDate <= $enDate) {
            $activities = array();
            $turDate = clone($stDate);
            $turDate->add(date_interval_create_from_date_string("5 hours 59 minutes"));
            if ($turDate->format('H') < 12) {
                $turno = 'MATUTINO';
            } else if ($turDate->format('H') <= 18) {
                $turno = 'VESPERTINO';
            } else {
                $turno = 'NOTURNO';
            }
            $minTime = date_create_from_format('Y-m-d H:i', '1970-01-01 23:59');
            $maxTime = date_create_from_format('Y-m-d H:i', '1970-01-01 00:00');
            foreach ($event->getActivities() as $activity) {
                foreach ($activity->getSessions() as $session) {
                    if ($session->getDate() === $stDate->format('Y-m-d') && $session->getStart() >= $stDate->format('H:i') && $session->getStart() <= $turDate->format('H:i')) {
                        $minTime = ($session->getStartTime() < $minTime) ? $session->getStartTime() : $minTime;
                        $maxTime = ($session->getEndTime() > $maxTime) ? $session->getEndTime() : $maxTime;
                        if (!in_array($activity, $activities)) {
                            array_push($activities, $activity);
                        }
                    }
                }
            }
            if ($minTime->format('i') < 30) {
                $minTime = date_create_from_format('Y-m-d H:i', "1970-01-01 {$minTime->format('H')}:00");
            } else {
                $minTime = date_create_from_format('Y-m-d H:i', "1970-01-01 {$minTime->format('H')}:30");
            }

            if ($maxTime->format('i') == 0) {
                $maxTime = date_create_from_format('Y-m-d H:i', "1970-01-01 {$maxTime->format('H')}:00");
            } else if ($maxTime->format('i') <= 30) {
                $maxTime = date_create_from_format('Y-m-d H:i', "1970-01-01 {$maxTime->format('H')}:30");
            } else {
                $maxHour = $maxTime->format('H') + 1;
                $maxHour = ($maxHour == 24) ? '00' : $maxHour;
                $maxTime = date_create_from_format('Y-m-d H:i', "1970-01-01 {$maxHour}:00");
            }
            if (!isset($eventDetail[$stDate->format('Y-m-d')])) {
                $eventDetail[$stDate->format('Y-m-d')] = array(
                    'date' => $stDate->format('d/m/Y'),
                    'dateUs' => $stDate->format('Y-m-d'),
                    'turnos' => array()
                );
            }
            array_push($eventDetail[$stDate->format('Y-m-d')]['turnos'], [
                'minTime' => $minTime,
                'maxTime' => $maxTime,
                'turno' => $turno,
                'activities' => $activities]);
            $stDate->add(date_interval_create_from_date_string("6 hours"));
        }
        return $eventDetail;
    }

    public static function saveRegister($pUser = null) {
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
                $activity->getParticipants()->removeElement($user);
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

    public static function deleteRegistration() {
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

    public static function printCertificates() {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        ini_set('memory_limit', '1024M');
        ini_set('allow_url_fopen', 1);
        set_time_limit(0);
        $event = Event::select('e')->where('e.id = ?1')
                        ->setParameter(1, $_MyCookie->getURLVariables(2))
                        ->getQuery()->getOneOrNullResult();
        $users = User::select('u')->join('u.activities', 'a')
                        ->join('a.event', 'e')
                        ->where('e.id = ?1')
                        ->orderBy('u.id')
                        ->setParameter(1, $_MyCookie->getURLVariables(2))->getQuery()->getResult();
        $reg = 5489; //O ultimo registro
        $pag = 0; //a ultima pagina
        $cert = 0;
        $data = '30/08/2017';
        self::createCertDir($event->getId());
        $fGen = fopen("cert/{$event->getId()}/_generated.txt", 'w+');
        fwrite($fGen, str_pad('NOME', 50) . str_pad('REGISTRO', 10) . "PAGINA\n");
        foreach ($users as $user) {
            $reg++;
            $cert++;
            $pag = $pag + (($cert - 1) % 3 == 0);
            $dom = new \Dompdf\Dompdf();
            $a = new \Dompdf\Options();
            $a->setIsRemoteEnabled(true);
            $dom->setOptions($a);
            ob_start();
            $_MyCookie->LoadView('event', 'Certificate', array($user, $reg, $pag, $event, $data));
            $htmlOutput = ob_get_contents();
            $dom->load_html($htmlOutput);
            ob_clean();
            $dom->set_paper('A4', 'landscape');
            $dom->render();
            $fp = fopen("cert/{$event->getId()}/{$user->getId()}.pdf", 'w+');
            fwrite($fp, $dom->output());
            fclose($fp);
            fwrite($fGen, str_pad(self::removeAccent($user->getName()), 50) . str_pad($reg, 10) . "$pag\n");
        }
        fclose($fGen);
        echo 'Certificados gerados com sucesso!';
    }

    private static function createCertDir($eId) {
        if (!file_exists('cert/')) {
            mkdir('cert/');
        }
        if (!file_exists("cert/$eId/")) {
            mkdir("cert/$eId/");
        }
        if (!file_exists("cert/$eId/speakers/")) {
            mkdir("cert/$eId/speakers/");
        }
    }

    public static function printSpeakerCertificates() {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        ini_set('memory_limit', '512M');
        ini_set('allow_url_fopen', 1);
        set_time_limit(0);
        $event = Event::select('e')->where('e.id = ?1')
                        ->setParameter(1, $_MyCookie->getURLVariables(2))
                        ->getQuery()->getOneOrNullResult();
        $reg = 5705; //O ultimo registro
        $pag = 72; //a ultima pagina
        $cert = 0;
        $data = '13/04/2017';
        self::createCertDir($event->getId());
        $fGen = fopen("cert/{$event->getId()}/speakers/_generated.txt", 'w+');
        fwrite($fGen, str_pad('NOME', 50) . str_pad('REGISTRO', 10) . "PAGINA\n");
        $sp = array();
        foreach ($event->getActivities() as $activity) {
            foreach ($activity->getSpeakers() as $speaker) {
                $reg++;
                $cert++;
                $pag = $pag + (($cert - 1) % 3 == 0);
                $dom = new \Dompdf\Dompdf();
                $a = new \Dompdf\Options();
                $a->setIsRemoteEnabled(true);
                $dom->setOptions($a);
                ob_start();
                $_MyCookie->LoadView('event', 'CertificateSpeaker', array($speaker, $reg, $pag, $event, $data, $activity));
                $htmlOutput = ob_get_contents();
                $dom->load_html($htmlOutput);
                ob_clean();
                $dom->set_paper('A4', 'landscape');
                $dom->render();
                $spkFname = self::removeAccent($speaker);
                array_push($sp, $spkFname);
                $fp = fopen("cert/{$event->getId()}/speakers/$spkFname.pdf", 'w+');
                fwrite($fp, $dom->output());
                fclose($fp);
                fwrite($fGen, str_pad($spkFname, 50) . str_pad($reg, 10) . "$pag\n");
            }
        }
        fclose($fGen);
        echo 'Certificados gerados com sucesso!';
    }

    private static function removeAccent($str) {
        $unwanted_array = array('Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
            'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
            'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', '/' => '');
        return strtr($str, $unwanted_array);
    }

    public static function emailEverybody() {
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

    public static function openActivities() {
        global $_MyCookie;
        $event = Event::select('e')->where('e.id = ?1')->setParameter(1, $_MyCookie->getURLVariables(2))->getQuery()->getSingleResult();
        $eventDetail = EventController::getEventDetail($event);
        $_MyCookie->loadView('event', 'openActivities', ['event' => $event, 'eventDetail' => $eventDetail]);
    }

    public static function loadEmails() {
        global $_MyCookie;
        UserController::checkAccessLevel('ADMINISTRATOR');
        $event = Event::select('e')->where('e.id = ?1')
                        ->setParameter(1, filter_input(INPUT_GET, 'eventId'))
                        ->getQuery()->getSingleResult();
        foreach ($event->getParticipants() as $user) {
            echo "{$user->getEmail()}, ";
        }
    }

    public static function sendMessage() {
        global $_MyCookie;
        global $_BaseURL;
        global $_Config;
        UserController::checkAccessLevel('ADMINISTRATOR');
        set_time_limit(0);
        require_once 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
        $event = Event::select('e')->where('e.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'eventId'))
                        ->getQuery()->getSingleResult();
        $mailConfig = $_Config->mail;
        foreach ($event->getParticipants() as $user) {
            $mail = new \PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';
            $mail->SMTPAuth = true;
            $mail->Host = $mailConfig->host;
            $mail->Port = $mailConfig->port;
            $mail->SMTPSecure = $mailConfig->security;
            $mail->Username = $mailConfig->username;
            $mail->Password = $mailConfig->password;
            $mail->setFrom($mailConfig->email, $event->getName());
            $mail->Subject = \utf8_decode('Mensagem dos organizadores');
            $mail->msgHTML(\utf8_decode(filter_input(INPUT_POST, 'mensagem')));
            $mail->addAddress($user->getEmail());
            $mail->send();
        }
    }

    public static function userCertificates() {
        global $_MyCookie;
        global $_User;
        $events = \model\event\Event::select('e')
                        ->join('e.activities', 'a')
                        ->join('a.present', 'u', \Doctrine\ORM\Query\Expr\Join::WITH, 'u.id = ?1')
                        ->setParameter(1, $_User->getId())
                        //->orderBy('e.endDate', 'DESC')
                        ->getQuery()->getResult();
        $_MyCookie->loadView('event', 'UserCertificates', $events);
    }

    public static function view() {
        $eId = \lib\MyCookie::getInstance()->getURLVariables(2);
        $event = Event::select('e')->where('e.id = ?1')
                        ->setParameter(1, $eId)
                        ->getQuery()->getOneOrNullResult();
        \lib\MyCookie::getInstance()->loadView('event', 'View', $event);
    }

}
