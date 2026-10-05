<?php

class HomeController extends Controller
{
    public function index()
    {
        $this->authCheck();

        $data['title'] = 'Dashboard - Manajemen Akun';
        $data['active_menu'] = 'dashboard';

        $this->view('home/index', $data);
    }
}
