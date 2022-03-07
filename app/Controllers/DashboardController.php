<?php

namespace App\Controllers;

use App\Models\ArticleModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $session = session();
        $articleModel = new ArticleModel();
        $data['articles'] = $articleModel->orderBy('id', 'DESC')->findAll();
        return view('dashboard', $data);
    }
}
