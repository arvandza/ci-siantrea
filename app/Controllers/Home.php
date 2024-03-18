<?php

namespace App\Controllers;
use App\Models\AntreanModel;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index(): string
    {
        $model = new UserModel();
        $antreModel = new AntreanModel();

        $data = [
            'title' => 'Dashboard',
            'total_dosen' => $model->getTotal(2),
            'total_antrean' => $antreModel->countAllResults()
        ];
        return view('home', $data);
    }
}
