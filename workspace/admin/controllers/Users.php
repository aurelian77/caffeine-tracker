<?php
declare(strict_types=1);

namespace workspace\admin\controllers;

use nicotine\Controller;
use nicotine\RequestMethod;
use nicotine\AdminRoles;
use nicotine\Registry;
use nicotine\Pagination;

class Users extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->proxy->layout = 'admin';
    }

    #[RequestMethod('get')]
    #[AdminRoles('super_admin')]
    public function list()
    {
        $title = 'List Users';
        
        $totalUsers = $this->proxy->admin->model('UsersModel')->countUsers();
        $pagination = new Pagination(intval($totalUsers));
        
        $pagination->perPage = 2;
        
        $users = $this->proxy->admin->model('UsersModel')->getUsers($pagination->getLimitStart(), $pagination->getLimitEnd());
        
        $this->proxy->view('Users/list', compact('title', 'users', 'pagination'));
    }

    // No admin roles required. Guy can enter "incognito", but needs a valid hash - which is immediatly changed.
    #[RequestMethod('get')]
    public function edit($userId, $hash = '')
    {
        $title = 'Edit User';

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

            $this->proxy->admin->model('LoginModel')->storeNewUserHash($userId, generate_hash()); // change the hash
        }

        $this->proxy->view('Users/edit', compact('title', 'user'));
    }
}
