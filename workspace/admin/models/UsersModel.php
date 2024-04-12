<?php
declare(strict_types=1);

namespace workspace\admin\models;

use nicotine\Model;

class UsersModel extends Model {

    public function getUserByIdAndHash($userId, $hash)
    {
        $query = $this->db->select("*")
            ->from("cf_users")
            ->where("`is_banned` IS NULL AND `id` = ".intval($userId)." AND `login_token` = :hash")
            ->query()
        ;
        return $this->db->getRow($query, [
            ':hash' => $hash,
        ]);
    }

    public function countUsers()
    {
        $query = $this->db->select("COUNT(*)")
            ->from("cf_users")
            ->query()
        ;
        return $this->db->getValue($query);
    }

    public function getUsers($start, $end)
    {
        $query = $this->db->select("`cf_users`.*, `cf_roles`.`name` AS `role_name`")
            ->from("cf_users")
            ->innerJoin("cf_roles")
            ->limit(intval($start).", ".intval($end))
            ->query()
        ;
        return $this->db->getAll($query);
    }
}
