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
        $check = $this->proxy->admin->model('LoginModel')->check($post);
        $session = $this->proxy->session();

        if (!empty($post['login'])) {
            if ($check == false) {
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
            email($post['email'], Registry::get('config')->siteName.' :: Your password reset link', $body /* is already html header, so use it */);
        }
    }

    #[RequestMethod('get')]
    public function logout()
    {
        $this->proxy->session(['staff_member'=> []]);
        header("Location: ".href('admin'));
    }

}
