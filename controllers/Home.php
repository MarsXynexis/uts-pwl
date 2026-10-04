<?php

class Home extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard - Manajemen Akun';
        $data['active_menu'] = 'account';

        $this->view('layouts/header', $data);
        $this->view('layouts/sidebar', $data);
        $this->view('home/index', $data);
        $this->view('layouts/footer', $data);
    }
}
