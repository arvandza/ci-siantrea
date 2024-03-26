<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Login'
        ];

        return view('login', $data);
    }

    public function auth()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getVar('password');

        $user = $this->userModel->where('username', $username)->first();

        if($user && password_verify($password, $user['password'])) {
            $this->setUserSession($user);
            return redirect()->to('/dashboard');
        } else {
            session()->setFlashdata('errors', 'Invalid username or password');
            return redirect()->back()->withInput();
        }
    }

    public function setUserSession($user)
    {
        $data = [
            'id'    => $user['id'],
            'nama'  => $user['nama'],
            'username' => $user['username'],
            'is_logged_in' => TRUE
        ];

        session()->set($data);
    }
}
