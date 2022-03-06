<?php

namespace App\Controllers;

use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $session = session();
        echo "Hello : <b>" . $session->get('name') . "</b>";
    }
}
