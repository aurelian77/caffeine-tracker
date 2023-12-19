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

    #[RequestMethod('get')]
    #[AdminRoles('super_admin')]
    public function edit($userId, $hash = '')
    {
        // Should be logged in.
        if (empty($hash)) {
            
            // exit;

        // The hash should match.
        } else {
            
            // set db hash = null ("expired")
            // exit;
        }
    }
}
