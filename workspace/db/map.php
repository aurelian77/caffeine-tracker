<?php
declare(strict_types=1);

namespace workspace\db;

use nicotine\Registry;

Registry::set('map', [
    'cf_roles' => [
        'cf_users' => [
            'link' => 'role_id'
        ],
    ],
]);
