<?php

namespace App\Controllers;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index(): string
    {
        $model = new UserModel();
        $data = [
            'title' => 'Dashboard',
            'total_dosen' => $model->getTotal(2)
        ];
        return view('home', $data);
    }
}
