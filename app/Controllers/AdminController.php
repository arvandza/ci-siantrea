<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AntreanModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

class AdminController extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data = [
            'dosen' => $model->getUsersByRole(2),
            'pager' => $model->pager,
            'title' => 'Kelola Dosen',
        ];

        return view('admin/kelola-dosen', $data);
    }

    public function addDosen()
    {
        $validationRules = [
            'username' => 'required|is_unique[users.username]',
            'password' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'prodi' => 'required'
        ];

        if ($this->validate($validationRules)) {
            $userModel = new UserModel();
            $data = [
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'nama'     => $this->request->getPost('nama'),
                'email'    => $this->request->getPost('email'),
                'prodi'    => $this->request->getPost('prodi'),
                'role_id'  => 2
            ];
            $userModel->createUser($data);
            return redirect()->back()->withInput()->with('success', 'Berhasil Menambahkan Data');
        } else {
            return redirect()->back()->withInput()->with('errors', 'Kesalahan dalam Inputan');
        }
    }

    public function deleteDosen($id)
    {
        $userModel = new UserModel();
        $user = $userModel->getUserById($id);

        if ($user && $user['role_id'] == 2) {
            $userModel->deleteUser($id);
            return redirect('kelola_dosen')->back()->with('success', 'Berhasil Menghapus Data Dosen');
        } else {
            return redirect('kelola_dosen')->back()->withInput()->with('errors', 'Data yang dihapus bukan data dosen');
        }
    }

    public function editDosen($id)
    {
        $userModel = new UserModel();
        $user = $userModel->getUserById($id);

        $data = [
            'user' => $user,
            'title' => 'Edit Data Dosen'
        ];

        if (!$user) {
            return redirect('kelola_dosen')->back()->with('errors', "Data Dosen tidak ditemukan");
        }

        return view('admin/edit-dosen', $data);
    }

    public function updateDosen($id)
    {
        $userModel = new UserModel();
        $data = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'prodi'    => $this->request->getPost('prodi'),
        ];

        $user = $userModel->getUserById($id);

        if (!$user && $user['role_id'] != 2) {
            return redirect('kelola_dosen')->back()->with('errors', 'Data yang diupdate bukan data dosen');
        }

        $userModel->updateUser($id, $data);
        return redirect('kelola_dosen')->back()->with('success', 'Data Berhasil Diperbaharui');
    }

    // Antrean
    public function indexAntrean()
    {
        $model = new UserModel();
        $antreModel = new AntreanModel();
        $jakartaTime = Time::now('Asia/Jakarta');
        $date = $jakartaTime->format('Y-m-d');

        $antreans = $antreModel
            ->select('antrean.*, users.nama as dosen_nama')
            ->join('users', 'antrean.dosen_id = users.id')
            ->paginate(10);

        $data = [
            'title' => 'Kelola Antrean',
            'dosen' => $model->getUsersByRole(2),
            'antre' => $antreans,
            'pager' => $antreModel->pager,
            'tanggal' => $date
        ];

        return view('admin/kelola-antrean', $data);
    }

    public function addAntrean()
    {
        $antreanModel = new AntreanModel();
        $userModel    = new UserModel();

        $data = [
            'dosen_id' => $this->request->getVar('optionDosen'),
            'tanggal'  => $this->request->getVar('date'),
        ];

        $antreanId = $antreanModel->createAntrean($data);
        $userId = $this->request->getVar('optionDosen');

        $userModel->update($userId, ['antrean_id' => $antreanId]);

        return redirect('kelola_antrean')->back()->with('success', 'Berhasil Menambahkan Data');
    }

    public function deleteAntrean($id)
    {
        $userModel    = new UserModel();
        $antreanModel = new AntreanModel();

        $antre = $antreanModel->find($id);

        if (!$antre) {
            return redirect('kelola_antrean')->back()->with('errors', 'Data Antrean Tidak Ada');
        }

        $userModel->where('antrean_id', $id)->set('antrean_id', NULL)->update();
        $antreanModel->deleteAntrean($id);

        return redirect('kelola_antrean')->back()->with('success', 'Berhasil Menghapus Data Antrean');
    }

    public function editAntrean($id)
    {
        $antreModel = new AntreanModel();
        $antre = $antreModel->find($id);
        $jakartaTime = Time::now('Asia/Jakarta');
        $date = $jakartaTime->format('Y-m-d');

        $antreans = $antreModel
            ->select('antrean.*, users.nama as dosen_nama')
            ->join('users', 'antrean.dosen_id = users.id')
            ->where('antrean.id', $id)
            ->first();

        $data = [
            'antre' => $antre,
            'title' => 'Edit Data Dosen',
            'dosen' => $antreans,
            'tanggal' => $date
        ];

        if (!$antre) {
            return redirect('kelola_antrean')->back()->with('errors', "Data Dosen tidak ditemukan");
        }

        return view('admin/edit-antrean', $data);
    }

    public function updateAntrean($id)
    {
        $antreanModel = new AntreanModel();

        $antre = $antreanModel->find($id);

        if (!$antre) {
            return redirect('kelola_antrean')->back()->with('errors', 'Data Antrean Tidak Ditemukan');
        }

        $data = [
            'tanggal'  => $this->request->getVar('date'),
        ];

        if (!$antre) {
            return redirect('kelola_antrean')->back()->with('errors', "Data Dosen tidak ditemukan");
        }

        $antreanModel->editAntrean($id, $data);

        return redirect('kelola_antrean')->back()->with('success', "Data Berhasil Diperbaharui");
    }
}
