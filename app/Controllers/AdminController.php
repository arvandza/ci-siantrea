<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

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

    public function storeDataDosen()
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

        if($user && $user['role_id'] == 2){
            $userModel->deleteUser($id);
            return redirect()->back()->with('success', 'Berhasil Menghapus Data Dosen');
        } else {
            return redirect()->back()->withInput()->with('errors', 'Data yang dihapus bukan data dosen');
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

        if(!$user){
            return redirect()->back()->with('errors', "Data Dosen tidak ditemukan");
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

        if(!$user && $user['role_id'] != 2) {
            return redirect()->back()->with('errors', 'Data yang diupdate bukan data dosen');
        }

        $userModel->updateUser($id, $data);
        return redirect()->back()->with('success', 'Data Berhasil Diperbaharui');
    }

    // Antrean
    public function indexAntrean()
    {
        $data = [
            'title' => 'Kelola Antrean'
        ];

        return view('admin/kelola-antrean', $data);
    }
}
