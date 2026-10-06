<?php

class AccountTypeController extends Controller
{

    public function index()
    {
        $this->authCheck();

        $search = trim($_GET['search'] ?? '');

        $accountTypeModel = $this->model('AccountType');

        $data['title'] = 'Manajemen Tipe Akun';
        $data['active_menu'] = 'account_type';
        $data['search'] = $search;
        $data['account-types'] = $accountTypeModel->getAccountTypes($search);
        $data['success'] = $_SESSION['success'] ?? null;
        $data['error'] = $_SESSION['error'] ?? null;

        unset($_SESSION['success']);
        unset($_SESSION['error']);

        $this->view('account-type/index', $data);
    }

    public function edit($id = null)
    {
        $this->authCheck();

        if (empty($id)) {
            $this->redirect('/uts-pwl/account-type');
        }

        $accountTypeModel = $this->model('AccountType');

        $accountType = $accountTypeModel->getAccountTypeById($id);

        if (!$accountType) {
            $this->redirect('/uts-pwl/account-type');
        }

        $data['title'] = 'Ubah Tipe Akun';
        $data['active_menu'] = 'account_type';
        $data['account_type'] = $accountType;
        $data['error'] = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (empty($name) || empty($description)) {
                $data['error'] = 'Semua field wajib diisi.';
            } else {
                try {
                    $accountTypeModel->updateAccountType($id, $_POST);

                    $_SESSION['success'] = 'Tipe Akun berhasil diperbarui.';

                    $this->redirect('/uts-pwl/account-type');
                } catch (PDOException $e) {
                    $data['error'] = 'Gagal memperbarui data tipe akun.';
                }
            }
        }


        $this->view('account-type/edit', $data);
    }

    public function create()
    {
        $this->authCheck();
        $accountTypeModel = $this->model('AccountType');

        $data['title'] = 'Tambah Tipe Akun';
        $data['active_menu'] = 'account_type';
        $data['account_types'] = $accountTypeModel->getAccountTypes();
        $data['error'] = null;
        $data['old'] = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (empty($name) || empty($description)) {
                $data['error'] = 'Semua field wajib diisi.';
                $data['old'] = $_POST;
            } else {
                $existing = $accountTypeModel->findByName($name);
                if ($existing) {
                    $data['error'] = 'Nama tipe akun sudah digunakan.';
                    $data['old'] = $_POST;
                } else {
                    try {
                        $accountTypeModel->createAccountType($_POST);

                        $_SESSION['success'] = 'Tipe Akun berhasil ditambahkan.';

                        $this->redirect('/uts-pwl/account-type');
                    } catch (PDOException $e) {
                        $data['error'] = 'Gagal menambahkan tipe akun.';
                        $data['old'] = $_POST;
                    }
                }
            }
        }

        $this->view('account-type/create', $data);
    }

    public function delete($id = null)
    {
        $this->authCheck();

        $accountTypeModel = $this->model('AccountType');
        $accountModel = $this->model('Account');

        $usedAccountTypes = $accountModel->getUsedAccountTypes();
        if (in_array($id, array_column($usedAccountTypes, 'account_type_id'))) {
                $_SESSION['error'] = 'Tipe akun ini dipakai oleh akun yang ada.';
            } else {
                try {
                    $accountTypeModel = $this->model('AccountType');

                    $accountTypeModel->deleteAccountType($id);

                    $_SESSION['success'] = 'Tipe Akun berhasil dihapus.';

                } catch (PDOException $e) {
                    $_SESSION['error'] = 'Gagal menghapus tipe akun.';
                }
            }
            $this->redirect('/uts-pwl/account-type');
        }

}
