<?php
declare(strict_types=1);

namespace workspace\admin\models;

use nicotine\Model;

class UsersModel extends Model {

    public function getUserByIdAndHash($userId, $hash)
    {
        $query = $this->db->select("*")->from("cf_users")
            ->where("`is_banned` IS NULL AND `id` = ".intval($userId)." AND `login_token` = :hash")
            ->limit("1")
            ->query()
        ;
        return $this->db->getRow($query, [
            ':hash' => $hash,
        ]);
    }

    public function resetUserHash($userId)
    {
        $this->db->update([
            'table' => 'cf_users',
            'data' => [
                'login_token' => null,
            ],
            'where' => (int) $userId,
        ]);
    }
}
