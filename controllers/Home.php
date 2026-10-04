<?php

class Home extends Controller
{
    public function index()
    {
        $this->authCheck();

        $data['title'] = 'Dashboard - Manajemen Akun';
        $data['active_menu'] = 'dashboard';

        $this->view('layouts/header', $data);
        $this->view('layouts/sidebar', $data);
        $this->view('home/index', $data);
        $this->view('layouts/footer', $data);
    }
}
