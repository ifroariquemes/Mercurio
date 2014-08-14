<?php

namespace controller\user;

use lib\MyCookie;
use model\user\accountType\AccountType;
use model\user\User;

class UserController {

    public function __construct() {
        if (!array_key_exists(MyCookie::MessageSession, $_SESSION)) {
            $_SESSION[MyCookie::MessageSession] = '';
        }
    }

    public static function firstRun() {
        $acAdmin = new AccountType();
        $acAdmin->setFlag('ADMINISTRATOR');
        $acAdmin->setName('Administrator');
        $acAdmin->save();
        $acUser = new AccountType();
        $acUser->setFlag('USER');
        $acUser->setName('User');
        $acUser->save();
        $uAdmin = new User();
        $uAdmin->setName('Administrator');
        $uAdmin->setLastName('Default');
        $uAdmin->setLogin('admin');
        $uAdmin->setPassword('admin');
        $uAdmin->setAccountType($acAdmin);
        $uAdmin->save();
    }

    public static function manage() {
        global $_MyCookie;
        UserController::VerifyAccessLevel('ADMINISTRATOR');
        $_MyCookie->LoadView('user', 'Manage');
    }

    public static function add() {
        global $_MyCookie;
        UserController::VerifyAccessLevel('ADMINISTRATOR');
        $_MyCookie->LoadView('user', 'Edit', array('action' => 'Add', 'user' => new User));
    }

    public static function edit() {
        global $_MyCookie;
        global $_MyCookieUser;
        $user = User::select('u')->where('u.id =  ?1')
                        ->setParameter(1, $_MyCookie->getURLVariables(2))->getQuery()->getSingleResult();
        if ($_MyCookieUser->getId() != $user->getId()) {
            UserController::VerifyAccessLevel('ADMINISTRATOR');
        }
        $_MyCookie->LoadView('user', 'Edit', array('action' => 'Edit', 'user' => $user));
    }

    public static function verifyUsername() {
        $user = User::select('u')->where('u.login = ?1')->setParameter(1, filter_input(INPUT_POST, 'email'))->getQuery()->getResult();
        if (count($user) > 0) {
            _e('This e-mail already exists.', 'user');
        }
    }

    public static function resend() {
        $user = User::select('u')->where('u.login = ?1')->setParameter(1, filter_input(INPUT_POST, 'email'))->getQuery()->getResult();
        if (count($user) > 0) {
            self::sendEmail($user[0]);
        } else {
            _e('There is no account registred with this e-mail.', 'user');
        }
    }

    public static function saveAndEmail() {
        $user = new User();
        $user
                ->setName(filter_input(INPUT_POST, 'name'))
                ->setLastname(filter_input(INPUT_POST, 'lastName'))
                ->setLogin(filter_input(INPUT_POST, 'email'))
                ->setEmail(filter_input(INPUT_POST, 'email'))
                ->setPassword(filter_input(INPUT_POST, 'newPassword'))
                ->setAccountType(AccountType::select('a')->where('a.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'accountTypeId'))->getQuery()->getSingleResult())
                ->setStatus(0)
                ->save();
        $user->setCode(md5($user->getId()))->save();
        self::sendEmail($user);
    }

    public static function confirmRegistration() {
        global $_MyCookie;
        $user = User::select('u')->where('u.code = ?1')->setParameter(1, filter_input(INPUT_GET, 'key'))->getQuery()->getResult();
        if (count($user) > 0) {
            $user[0]->setStatus(1)->save();
            $_MyCookie->LoadView('user', 'Confirmed', filter_input(INPUT_GET, 'return'));
        } else {
            _e('Key not recognised.', 'user');
        }
    }

    public static function sendEmail(User $user) {
        $return = filter_input(INPUT_SERVER, 'HTTP_REFERER');
        require_once 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
        $mail = new \PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->Username = 'natanael.simoes@ifro.edu.br';
        $mail->Password = '145111nn';
        $mail->setFrom('natanael.simoes@ifro.edu.br', $user->getEmail());
        $mail->Subject = utf8_decode('Seu cadastro no Mercúrio');
        $mail->msgHTML(utf8_decode(<<<EOT
<p>Olá, {$user->getCompleteName()}!</p>
           
<p>Este e-mail foi enviado porque recebemos uma solicitação de cadastro no Mercúrio, nosso Sistema Gerenciador de Eventos.<br>
Para confirmar seu cadastro, por favor, clique no link abaixo ou copie e cole-o na barra de endereço do seu navegador:</p>

<p><a href="http://localhost/Mercurio/user/confirmRegistration/?key={$user->getCode()}&return={$return}">http://localhost/Mercurio/user/confirmRegistration/?key={$user->getCode()}</a></p>
                
<p>Se você não solicitou cadastro em nosso sistema, contate-nos através do e-mail <a href="mailto:natanael.simoes@ifro.edu.br">natanael.simoes@ifro.edu.br</a> e desconsidere este e-mail.</p>

<p><span style="font-size: small">Este é um e-mail automático. Não o responda.</span></p>
<hr>
Mercúrio - Sistema Gerenciador de Eventos<br>
<b>IFRO - Instituto Federal de Educação, Ciência e Tecnologia de Rondônia</b> - <i>Campus Ariquemes</i><br>
<a href="http://www.ifro.edu.br">http://www.ifro.edu.br</a>                
EOT
        ));
        $mail->addAddress($user->getEmail());
        $mail->send();
        _e('We\'ve sent a confirmation link, please check your e-mail to use this service.', 'user');
    }

    /**
     * 
     * @return User
     */
    public static function save() {
        $user = (empty(filter_input(INPUT_POST, 'id'))) ? new User() : User::select('u')->where('u.id =  ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();
        $user->setName(filter_input(INPUT_POST, 'name'));
        $user->setMiddleName(filter_input(INPUT_POST, 'middleName'));
        $user->setLastname(filter_input(INPUT_POST, 'lastName'));
        $user->setLogin(filter_input(INPUT_POST, 'login'));
        if (!empty(filter_input(INPUT_POST, 'newPassword'))) {
            $user->setPassword(filter_input(INPUT_POST, 'newPassword'));
        }
        $user->setAccountType(AccountType::select('a')->where('a.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'accountTypeId'))->getQuery()->getSingleResult());
        $user->save();
        return $user;
    }

    public static function deactivate() {
        $user = User::select('u')->where('u.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();
        $user->setStatus(0);
        $user->save();
    }

    public static function reactivate() {
        $user = User::select('u')->where('u.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();
        $user->setStatus(1);
        $user->save();
    }

    public static function delete() {
        $user = User::select('u')->where('u.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();
        $user->delete();
    }

    public static function checkActualPassword() {
        $user = User::select('u')->where('u.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();
        echo ($user->getPassword() == md5(filter_input(INPUT_POST, 'actualPassword'))) ? 'true' : 'false';
    }

    public static function changePassword() {
        $user = User::select('u')->where('u.id = ?1')
                        ->setParameter(1, filter_input(INPUT_POST, 'id'))->getQuery()->getSingleResult();
        $user->setPassword(filter_input(INPUT_POST, 'newPassword'));
        $user->save();
    }

    public static function getNomeUsuario() {

        $usuario = unserialize($_SESSION['MyCookie_SESSAO_USUARIO']);

        if (is_object($usuario))
            return $usuario->getName();
    }

    public static function getSobrenomeUsuario() {

        $usuario = unserialize($_SESSION['MyCookie_SESSAO_USUARIO']);

        if (is_object($usuario))
            return $usuario->getSobrenome();
    }

    public function Login() {
        $users = User::select('u')
                ->where('u.login = :login')
                ->setParameter('login', filter_input(INPUT_POST, 'login'))
                ->getQuery()
                ->getResult();
        $_SESSION[MyCookie::MessageSession] = __('Invalid login or password. Please, try again.', 'user');
        if (count($users) == 1) {
            if ($users[0]->getPassword() == md5(filter_input(INPUT_POST, 'password'))) {
                if ($users[0]->getStatus()) {
                    $_SESSION[MyCookie::UserIdSession] = $users[0]->getId();
                    $_SESSION[MyCookie::MessageSession] = __('Success!', 'user');
                } else {
                    $_SESSION[MyCookie::MessageSession] = __('Your username is deactivated. Please contact administration.', 'user');
                }
            }
        }
        header('location:' . $_SERVER['HTTP_REFERER']);
    }

    public static function LoadSessionUser() {
        global $_MyCookieUser;
        if (array_key_exists(MyCookie::UserIdSession, $_SESSION) & !empty($_SESSION[MyCookie::UserIdSession])) {
            $_MyCookieUser = User::select('u')
                            ->where('u.id = :id')
                            ->setParameter('id', $_SESSION[MyCookie::UserIdSession])
                            ->getQuery()
                            ->execute()[0];
        }
    }

    public function Logout() {
        global $_MyCookie;
        unset($_SESSION[MyCookie::UserIdSession]);
        unset($_SESSION[MyCookie::MessageSession]);
        header('location:' . $_MyCookie->getSite());
    }

    public static function isAdministratorLoggedIn() {
        if (UserController::isUserLoggedIn()) {
            global $_MyCookieUser;
            return ($_MyCookieUser->getAccountType()->getFlag() == 'ADMINISTRATOR');
        }
        return false;
    }

    public static function isUserLoggedIn() {
        return isset($_SESSION[MyCookie::UserIdSession]);
    }

    public static function VerifyAccessLevel($accessLevel, $_ = null) {
        global $_MyCookie;
        global $_MyCookieUser;
        $accessLevel = func_get_args();
        if (!in_array($_MyCookieUser->getAccountType()->getFlag(), $accessLevel))
            header('location: ' . $_MyCookie->getSite() . 'administrator/');
    }

    public static function ShowUserTableByType($accid) {
        global $_MyCookie;
        $data = User::select('u')->join('u.accountType', 'a')->where("a.id = ?1")->add('orderBy', 'u.name ASC, u.status DESC')
                        ->setParameter(1, $accid)->getQuery()->execute();
        $_MyCookie->LoadView('user', 'Manage.table', $data);
    }

    public static function VerificarUsuario() {

        $usuario = new TUsuario;

        if (count($usuario->ListarTodosOnde("usuario = '{$_REQUEST['usuario']}'")) > 0)
            echo '1';
    }

    public static function AlterarTipo() {

        $_SESSION['TIPO_INDEX'] = $_REQUEST['tipo'];
    }

    public static function ResetarTipo() {
        unset($_SESSION['TIPO_INDEX']);
    }

    public static function selectWithFlag($flag) {
        global $_MyCookie;
        $users = User::select('u')->join('u.accountType', 'a')->where('a.flag = ?1')->orderBy('u.name')
                        ->setParameter(1, $flag)->getQuery()->getResult();
        $_MyCookie->LoadView('user', 'Select', $users);
    }

}

?>
