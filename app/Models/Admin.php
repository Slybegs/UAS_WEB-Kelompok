<?php

namespace App\Models;

use App\Helpers\Session;

class Admin extends BaseModel
{
    protected string $table = 'admins';

    protected array $fillable = [
        'id', 'name', 'email', 'password'
    ];

    public function login($email, $password)
    {
        $this->query("SELECT id, email, password FROM {$this->table}")
            ->where('email', '=', $email)
            ->where('password', '=', $password);
        $result = $this->get('email', 'asc', 1);
        if ($result === null) {
            return false;
        }
        $session = new Session();
        $session->set('userId', $result['id']);
        return true;
    }
}