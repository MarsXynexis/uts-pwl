<?php

class AuthController extends Controller
{
    public function index()
    {
        if (isset($_SESSION['user'])) {
            $this->redirect('/uts-pwl/account');
        }

        $data['title'] = 'Login - Manajemen Akun';
        $data['error'] = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($email) || empty($password)) {
                $data['error'] = 'Email dan password wajib diisi.';
            } else if (!isset($_POST['captcha']) || $_POST['captcha'] !== $_SESSION['code']) {
                $data['error'] = 'Captcha salah.';
            } else {
                $accountModel = $this->model('Account');

                $user = $accountModel->findByEmail($email);

                if ($user && empty($user['deleted_at']) && password_verify($password, $user['password'])) {
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'account_type_id' => $user['account_type_id'],
                        'status' => $user['status']
                    ];

                    $this->redirect('/uts-pwl/account');
                } else {
                    $data['error'] = 'Email atau password salah.';
                }
            }
        }

        $this->view('auth/login', $data);
    }


    public function captcha()
    {
        $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $pass = array();
        $panjangAlpha = strlen($alphabet) - 2;

        for ($i = 0; $i < 5; $i++) {
            $n = rand(0, $panjangAlpha);
            $pass[] = $alphabet[$n];
        }

        $code = implode($pass);
        $_SESSION["code"] = $code; // Simpan kodenya ke session

        // Membuat gambar
        $wh = imagecreatetruecolor(173, 50);
        $bgc = imagecolorallocate($wh, 22, 86, 165);
        $fc = imagecolorallocate($wh, 223, 230, 233);

        imagefill($wh, 0, 0, $bgc);
        imagestring($wh, 5, 50, 15, $code, $fc);

        // Output sebagai gambar asli
        header('Content-Type: image/jpeg');
        imagejpeg($wh);
        imagedestroy($wh);
        exit;
    }

    public function logout()
    {
        unset($_SESSION['user']);

        session_destroy();

        $this->redirect('/uts-pwl/login');
    }
}
