<?php
declare(strict_types=1);

namespace workspace\admin\models;

use nicotine\Model;

class UsersModel extends Model {

    public function getUserByIdAndHash($userId, $hash)
    {
        $query = $this->db->select("*")->from("cf_users")
            ->where("`is_banned` IS NULL AND `id` = ".intval($userId)." AND `invitation_hash` = :hash")
            ->limit("1")
            ->query()
        ;
        return $this->db->getRow($query, [
            ':hash' => $hash,
        ]);
    }
}
