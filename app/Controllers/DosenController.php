<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;
use Ramsey\Uuid\Uuid;

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

    public function updateAntrean($id)
    {
        $antre = $this->antreanModel->find($id);
        $data = [
            'tanggal'      => $this->request->getVar('date'),
            'maks_antrean' => $this->request->getVar('antrean'),
            'keterangan'   => $this->request->getVar('keterangan')
        ];

        if (!$antre || $antre['dosen_id'] != $this->session->get('id')) {
            throw new PageNotFoundException();
        }

        $this->antreanModel->editAntrean($id, $data);

        return redirect('dosen/kelola_antrean')->with('success', "Data Berhasil Diperbaharui");
    }

    public function indexData()
    {
        $kode_verif = session()->get('kode_verif');
        
        // if(!$kode_verif){
        //     throw new PageNotFoundException();
        // }
        
        return view('user/ambil-antrean');
    }

    public function storeDataAntrean()
    {
        $uuid = Uuid::uuid4();
        $kode_verif = substr($uuid, 0, 4);
        $id_dosen = $this->request->getVar('id_dosen');

        $lastNumber = $this->dataModel->where('antrean_id', $id_dosen)->select('no_urut')->orderBy('id', 'DESC')->first();

        $lastNumber = $lastNumber ? $lastNumber['no_urut'] : 0;

        $no_urut = $lastNumber + 1;

        $data = [
            'kode_verif' => $kode_verif,
            'antrean_id' => $id_dosen,
            'no_urut'    => $no_urut
        ];

        $this->dataModel->insert($data);
        $totalAntrean = $this->dataModel->where('antrean_id', $id_dosen)->countAllResults();
        $this->antreanModel->where('id', $id_dosen)->set('jumlah_antrean', $totalAntrean)->update();

        $dosenName = $this->antreanModel
            ->select('antrean.*, users.nama as dosen_nama')
            ->join('users', 'antrean.dosen_id = users.id')
            ->where('antrean.id', $id_dosen)
            ->first();

        session()->setFlashdata('kode_verif', $kode_verif);
        session()->setFlashdata('no_urut', $no_urut);
        session()->setFlashdata('nama_dosen', $dosenName['dosen_nama']);

        return redirect()->to('/ambil_antrean');
    }
}
