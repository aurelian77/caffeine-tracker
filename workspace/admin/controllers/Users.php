<?php
declare(strict_types=1);

namespace workspace\admin\controllers;

use nicotine\Controller;
use nicotine\RequestMethod;
use nicotine\AdminRoles;
use nicotine\Registry;

class Users extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->proxy->layout = '';
    }

    // No admin roles required. Guy can enter "incognito".
    #[RequestMethod('get')]
    public function edit($userId, $hash = '')
    {
        if (empty($hash)) { // Should be logged in.
            $user = get_user();

            if (empty($user['id']) || $user['id'] != $userId) {
                $this->proxy->redirect(href('admin'), ['You don\'t have permission to access this resource!'], 'error');
            }
        } else { // The hash should match.
            $user = $this->proxy->admin->model('UsersModel')->getUserByIdAndHash($userId, $hash);

            if (empty($user)) {
                $this->proxy->redirect(href('admin'), ['You don\'t have permission to access this resource!'], 'error');
            }

            $this->proxy->admin->model('UsersModel')->resetUserHash($userId); // set db hash = null (aka "expired")
        }

        // do something with $user
    }
}
