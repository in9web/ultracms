<?php
namespace Ultra\Library;

use \Ultra\Session;
use \Ultra\Model\User;

class Authentication
{
    public static function isLogged()
    {
        return Session::getItem('user_logged');
    }

    public static function check()
    {
        return self::isLogged();
    }

    public static function login($login, $password)
    {
        $user = User::where('email',    $login)
                    ->where('status',   'active')
                    ->first();

        if ($user) {

            // FIX ME, change to a crypt hash, see https://secure.php.net/manual/en/function.crypt.php
            if ($user->password == hash('sha256', $password)) {

                // user logged
                Session::setItem('user_logged', true);
                Session::setItem('user', $user->toArray());

                // update last login
                $user->last_login_at = new \DateTime('NOW');
                $user->save();
                
                admin_redirect_uri('/');
                    
            } else {
                
                Session::addFlashMessage('error', _t('Login/Password incorrect'));
                admin_redirect_uri('/auth');

            }
            
        } else {

            Session::addFlashMessage('error', _t('Login/Password incorrect'));
            admin_redirect_uri('/auth');

        }
    }

    public static function logout()
    {
        Session::clearItem('user_logged');
        Session::clearItem('user');
        
        Session::addFlashMessage('success', _t('Logout with success'));
        admin_redirect_uri('/auth');
    }

    /**
     * forgotPassword Generate token to change password
     * @param  string $email E-Mail to send recover password
     * @return string        Return token
     */
    public static function forgotPassword($email)
    {
        $user = User::where('email',    $email)
                    ->where('status',   'active')
                    ->first();

        if ($user) {

            $recover_token = hash('sha256', date('Ymd_His'));
            $user->recover_token = $recover_token;
            $user->save();

            static::sendEMail('forgot', array('token' => $recover_token, 'to' => $to));

            Session::addFlashMessage('success', _t('Access your E-Mail to recover'));
            admin_redirect_uri('/auth');
            
        } else {

            Session::addFlashMessage('error', _t('E-Mail not found'));
            admin_redirect_uri('/auth');

        }
    }

    public static function sendEMail($type, $data)
    {
        switch ($type) {
            case 'forgot':
                $data['subject'] = 'UltraCMS - Forgot password';
                $data['message'] = "Hi, {name}! \n Change your password with link above: \n ".base_url('auth/recover/'.$data['token'])."\n UltraCMS";
                break;
            
            default:
                $data['subject'] = 'UltraCMS';
                $data['message'] = "Hi, {name}! \n Default template email from UltraCMS";
                break;
        }

        $admin_sender = 'noreply@'.$_SERVER['HTTP_HOST'];
        
        $headers[] = 'To: '.$data['to'];
        $headers[] = 'From: '.$admin_sender;
        // $headers[] = 'Reply-to: '.$admin_sender;
        $headers[] = 'X-Mailer: PHP-' . phpversion();

        return mail($data['to'], $data['subject'], $data['message'], implode(PHP_EOL, $header));
    }

}