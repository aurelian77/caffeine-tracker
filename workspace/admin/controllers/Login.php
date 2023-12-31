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
        $this->proxy->view('Login/login');
    }
    
    #[RequestMethod('post')]
    public function check(): void
    {
        $post = $this->proxy->post();
        $session = $this->proxy->session();

        if (!empty($post['login'])) {
            // Check and SET the session user.
            if ($this->proxy->admin->model('LoginModel')->check($post) == false) {
                $this->proxy->back(['Invalid login, or your account is suspended!'], 'error');
            }

            if (in_array('super_admin', get_roles())) {
                $this->proxy->redirect(href('admin/users/list'));
            }

            if (in_array('contributor', get_roles())) {
                $this->proxy->redirect(href('admin/projects/list'));
            }
        }
        elseif (!empty($post['forgot'])) {
            $user = $this->proxy->admin->model('LoginModel')->getUserByEmail($post['email']);

            if (!empty($user)) {
                $hash = generate_hash();

                email(
                    $post['email'],
                    Registry::get('config')->siteName.' | Edit your profile',

                    '<p>Your edit profile link:</p>'.
                    '<p>'.Registry::get('config')->baseHref.'/admin/users/edit/'.$user['id'].'/'.$hash.'</p>'
                );

                $this->proxy->admin->model('LoginModel')->storeNewUserHash($user['id'], $hash);
            } else {
                $this->proxy->back(['Unknown email or your account is suspended!'], 'error');
            }
        }
    }

    #[RequestMethod('get')]
    public function logout()
    {
        $this->proxy->session(['staff_member'=> []]);
        $this->proxy->redirect(href('admin'));
    }

}
