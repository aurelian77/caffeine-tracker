<?php
declare(strict_types=1);

namespace workspace\admin\controllers;

use nicotine\Controller;
use nicotine\RequestMethod;
use nicotine\AdminRoles;
use nicotine\Registry;

class Login extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->proxy->layout = 'login';
    }

    #[RequestMethod('get')]
    public function index(): void
    {
        $this->proxy->view('login/login');
    }
    
    #[RequestMethod('post')]
    public function check(): void
    {
        $post = $this->proxy->post();
        $session = $this->proxy->session();

        if (!empty($post['login'])) {
            if ($this->proxy->admin->model('LoginModel')->check($post) == false) {
                $this->proxy->back(['Invalid login!'], 'error');
            }

            if (in_array('super_admin', $session['staff_member']['admin_roles'])) {
                header('Location: '.href('admin/staff/list'));
            }

            if (in_array('contributor', $session['staff_member']['admin_roles'])) {
                header('Location: '.href('admin/projects/list'));
            }
        }

        if (!empty($post['forgot'])) {
            $user = $this->proxy->admin->model('LoginModel')->getUserByEmail($post['email']);

            if (!empty($user)) {
                $hash = str_split(hash('sha512', (string) time()));
                shuffle($hash);
                $hash = implode('', $hash);

                email(
                    $post['email'], 
                    Registry::get('config')->siteName.' :: Your password reset link',
                    '<p>Your password reset link:</p>'.
                    '<p>'.Registry::get('config')->baseHref.'/login/reset/'.$user['id'].'/'.$hash.'</p>'
                );

                $this->proxy->admin->model('LoginModel')->storeNewUserHash($user['id'], $hash);
            } else {
                $this->proxy->back(['Unknown email!'], 'error');
            }
        }
    }

    #[RequestMethod('get')]
    public function logout()
    {
        $this->proxy->session(['staff_member'=> []]);
        header("Location: ".href('admin'));
    }

}
