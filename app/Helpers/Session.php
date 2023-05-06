<?php

namespace App\Helpers;

class Session
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Sets a flash message data function
    public function set($key = "", $value = ""): bool
    {
        if (!empty($key) && !empty($value)) {
            $_SESSION[$key] = $value;
            return true;
        }
        return false;
    }

    // Sets a flash message data function
    public function flash($key = "", $value = ""): bool
    {
        if (!empty($key) && !empty($value)) {
            $_SESSION['_flash'][$key] = $value;
            return true;
        }
        return false;
    }

    // Getting the flashdata
    public function get($key): mixed
    {
        if (empty($key)) {
            return null;
        }

        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else if (isset($_SESSION['_flash'][$key])) {
            $data = $_SESSION['_flash'][$key];
            unset($_SESSION['_flash'][$key]);
            return $data;
        }

        return null;
    }

    public function delete($key): bool
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }
}