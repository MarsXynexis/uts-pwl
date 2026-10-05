<?php

class AccountController extends Controller
{
    public function index()
    {
        $this->authCheck();

        $search = trim($_GET['search'] ?? '');

        $accountModel = $this->model('Account');

        $data['title'] = 'Manajemen Akun';
        $data['active_menu'] = 'account';
        $data['search'] = $search;
        $data['accounts'] = $accountModel->getAccounts($search);
        $data['success'] = $_SESSION['success'] ?? null;
        $data['error'] = $_SESSION['error'] ?? null;

        unset($_SESSION['success']);
        unset($_SESSION['error']);

        $this->view('account/index', $data);
    }

    public function create()
    {
        $this->authCheck();

        $accountModel = $this->model('Account');
        $accountTypeModel = $this->model('AccountType');

        $data['title'] = 'Tambah Akun';
        $data['active_menu'] = 'account';
        $data['account_types'] = $accountTypeModel->getAccountType();
        $data['error'] = null;
        $data['old'] = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $account_type_id = trim($_POST['account_type_id'] ?? '');
            $status = trim($_POST['status'] ?? '');
            $identification_type = trim($_POST['identification_type'] ?? '');
            $identification_number = trim($_POST['identification_number'] ?? '');

            if (empty($name) || empty($email) || empty($password) || empty($account_type_id) || empty($status) || empty($identification_type) || empty($identification_number)) {
                $data['error'] = 'Semua field wajib diisi.';
                $data['old'] = $_POST;

            } else {
                $existing = $accountModel->findByEmail($email);

                if ($existing && empty($existing['deleted_at'])) {
                    $data['error'] = 'Email sudah digunakan.';
                    $data['old'] = $_POST;

                } else if ($existing && !empty($existing['deleted_at'])) {
                    try {
                        $accountModel->restoreAccount($existing['id'], $_POST);

                        $_SESSION['success'] = 'Akun berhasil dipulihkan dan ditambahkan.';

                        $this->redirect('/uts-pwl/account');

                    } catch (PDOException $e) {
                        $data['error'] = 'Gagal memulihkan akun.';
                        $data['old'] = $_POST;
                    }

                } else {
                    try {
                        $accountModel->createAccount($_POST);

                        $_SESSION['success'] = 'Akun berhasil ditambahkan.';

                        $this->redirect('/uts-pwl/account');

                    } catch (PDOException $e) {
                        $data['error'] = 'Gagal menambahkan akun: Email sudah terdaftar.';
                        $data['old'] = $_POST;
                    }
                }
            }
        }

        $this->view('account/create', $data);
    }

    public function edit($id = null)
    {
        $this->authCheck();

        if (empty($id)) {
            $this->redirect('/uts-pwl/account');
        }

        $accountModel = $this->model('Account');
        $accountTypeModel = $this->model('AccountType');

        $account = $accountModel->getAccountById($id);

        if (!$account) {
            $this->redirect('/uts-pwl/account');
        }

        $data['title'] = 'Ubah Akun';
        $data['active_menu'] = 'account';
        $data['account_types'] = $accountTypeModel->getAccountType();
        $data['account'] = $account;
        $data['error'] = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $account_type_id = trim($_POST['account_type_id'] ?? '');
            $status = trim($_POST['status'] ?? '');
            $identification_type = trim($_POST['identification_type'] ?? '');
            $identification_number = trim($_POST['identification_number'] ?? '');

            if (empty($name) || empty($email) || empty($account_type_id) || empty($status) || empty($identification_type) || empty($identification_number)) {
                $data['error'] = 'Semua field wajib diisi.';

            } else {
                $existing = $accountModel->findByEmail($email);

                if ($existing && $existing['id'] !== $id && empty($existing['deleted_at'])) {
                    $data['error'] = 'Email sudah digunakan oleh akun lain.';

                } else if ($existing && $existing['id'] !== $id && !empty($existing['deleted_at'])) {
                    $data['error'] = 'Email sudah terdaftar pada akun yang dinonaktifkan.';

                } else {
                    try {
                        $accountModel->updateAccount($id, $_POST);

                        $_SESSION['success'] = 'Akun berhasil diperbarui.';

                        $this->redirect('/uts-pwl/account');

                    } catch (PDOException $e) {
                        $data['error'] = 'Gagal memperbarui data akun.';
                    }
                }
            }
        }

        $this->view('account/edit', $data);
    }

    public function delete($id = null)
    {
        $this->authCheck();

        if (!empty($id)) {
            if ($id === $_SESSION['user']['id']) {
                $_SESSION['error'] = 'Tidak dapat menghapus akun yang sedang digunakan.';

            } else {
                try {
                    $accountModel = $this->model('Account');

                    $accountModel->deleteAccount($id);

                    $_SESSION['success'] = 'Akun berhasil dihapus.';

                } catch (PDOException $e) {
                    $_SESSION['error'] = 'Gagal menghapus akun.';
                }
            }
        }

        $this->redirect('/uts-pwl/account');
    }
}
