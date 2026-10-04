<?php

class Login extends Controller
{
    public function index()
    {
        if (isset($_SESSION['user'])) {
            $this->redirect('/uts-pwl');
        }

        $data['title'] = 'Login - Manajemen Akun';
        $data['error'] = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($email) || empty($password)) {
                $data['error'] = 'Email dan password wajib diisi.';

            } else {
                $accountModel = $this->model('Account');

                $user = $accountModel->findByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'account_type_id' => $user['account_type_id'],
                        'status' => $user['status']
                    ];

                    $this->redirect('/uts-pwl');

                } else {
                    $data['error'] = 'Email atau password salah.';
                }
            }
        }

        $this->view('auth/login', $data);
    }

    public function logout()
    {
        unset($_SESSION['user']);

        session_destroy();

        $this->redirect('/uts-pwl/login');
    }
}
