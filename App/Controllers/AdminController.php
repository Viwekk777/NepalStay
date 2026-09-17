<?php

namespace App\Controllers;

class AdminController
{
    public function dashboard(): void
    {
        if (\App\Auth::isAdmin()=== true) {
            require_once __DIR__ . '/../../Views/admin/dashboard.php';
        }
    }


}