<?php
declare(strict_types=1);

namespace workspace\admin\models;

use nicotine\Model;

class LoginModel extends Model {

    public function check(array $data): bool
    {
        $query = $this->db->select("*")->from("cf_users")
            // Aborting "AND `login_token` IS NULL", because someone can request a password reset link.
            ->where("`is_banned` IS NULL AND `email` = :email AND `password` = :password")
            ->query()
        ;
        $member = $this->db->getRow($query, [
            ':email' => $data['email'],
            ':password' => hash('sha512', $data['password'])
        ]);

        if (empty($member)) {
            return false;
        }

        switch ($member['role_id']) {
            case 1:
                $role = 'super_admin';
            break;
            case 2:
                $role = 'contributor';
            break;
            default:
                return false;
            break;
        }

        $session = [];

        $session['staff_member'] = $member;
        $session['staff_member']['admin_roles'] = [$role];

        $this->proxy->session($session);

        return true;
    }
    
    public function getUserByEmail(string $email): array
    {
        $query = $this->db->select("*")->from("cf_users")
            ->where("`is_banned` IS NULL AND `email` = :email")
            ->limit("1")
            ->query()
        ;
        return $this->db->getRow($query, [
            ':email' => $email,
        ]);
    }

    public function storeNewUserHash(int $userId, string $newHash): void
    {
        $this->db->update([
            'table' => 'cf_users',
            'data' => [
                'login_token' => (string) $newHash,
            ],
            'where' => (int) $userId,
        ]);
    }

}
