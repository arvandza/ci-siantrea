<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class DosenController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard Dosen'
        ];

        return view('dosen/dashboard', $data);
    }

    public function indexAntrean()
    {
        $userId = $this->session->get('id');
        $data = [
            'title' => 'Kelola Antrean',
            'antre' => $this->antreanModel->getAntreanByUserId($userId),
            'pager' => $this->antreanModel->pager
        ];

        return view('dosen/kelola-antrean', $data);
    }

    public function editAntrean()
    {
        $id = $this->request->getGet('id');
        $antre = $this->antreanModel->find($id);
        $jakartaTime = Time::now('Asia/Jakarta');
        $date = $jakartaTime->format('Y-m-d');

        $antreans = $this->antreanModel
            ->select('antrean.*, users.nama as dosen_nama')
            ->join('users', 'antrean.dosen_id = users.id')
            ->where('antrean.id', $id)
            ->first();

        if (!$antre || $antre['dosen_id'] != $this->session->get('id')) {
            throw new PageNotFoundException();
        }

        $data = [
            'antre'   => $antre,
            'title'   => 'Edit Data Antrean',
            'tanggal' => $date,
            'dosen'   => $antreans
        ];

        return view('dosen/edit-antrean', $data);
    }
}
