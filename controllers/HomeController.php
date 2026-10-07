<?php

class HomeController extends Controller
{
    public function index()
    {
        $this->authCheck();

        $this->redirect('/uts-pwl/account');
    }
}
