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
            'total_antrean' => $antreModel->query("SELECT SUM(jumlah_antrean) as total FROM antrean")->getRow()->total
        ];
        return view('home', $data);
    }

    public function landing()
    {
        $antreans = $this->antreanModel
            ->select('antrean.*, users.nama as dosen_nama')
            ->join('users', 'antrean.dosen_id = users.id')
            ->paginate(10);

        $data = [
            'title' => 'SIANTREA',
            'antre' => $antreans,
            'pager' => $this->antreanModel->pager,
        ];

        return view('landingpage', $data);
    }
}
