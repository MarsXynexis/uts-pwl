<?php

class ActionController extends Controller
{
    public function index()
    {
        $this->authCheck();

        $search = trim($_GET['search'] ?? '');

        $actionModel = $this->model('Action');

        $data['title'] = 'Manajemen Aksi';
        $data['active_menu'] = 'action';
        $data['search'] = $search;
        $data['actions'] = $actionModel->getActions($search);
        $data['success'] = $_SESSION['success'] ?? null;
        $data['error'] = $_SESSION['error'] ?? null;

        
        unset($_SESSION['success']);
        unset($_SESSION['error']);

        $this->view('action/index', $data);
    }

    public function create()
    {
        $this->authCheck();

        $actionModel = $this->model('Action');

        $data['title'] = 'Tambah Aksi';
        $data['active_menu'] = 'action';
        $data['error'] = null;
        $data['old'] = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (empty($name) || empty($description)) {
                $data['error'] = 'Semua field wajib diisi.';
                $data['old'] = $_POST;

            } else {
                $existing = $actionModel->findByName($name);

                if ($existing && empty($existing['deleted_at'])) {
                    $data['error'] = 'Nama sudah digunakan.';
                    $data['old'] = $_POST;

                } else if ($existing && !empty($existing['deleted_at'])) {
                    try {
                        $actionModel->restoreAction($existing['id'], $_POST);

                        $_SESSION['success'] = 'Aksi berhasil dipulihkan dan ditambahkan.';

                        $this->redirect('/uts-pwl/action');

                    } catch (PDOException $e) {
                        $data['error'] = 'Gagal memulihkan aksi.';
                        $data['old'] = $_POST;
                    }

                } else {
                    try {
                        $actionModel->createAction($_POST);

                        $_SESSION['success'] = 'Aksi berhasil ditambahkan.';

                        $this->redirect('/uts-pwl/action');

                    } catch (PDOException $e) {
                        $data['error'] = 'Gagal menambahkan aksi.';
                        $data['old'] = $_POST;
                    }
                }
            }
        }

        $this->view('action/create', $data);
    }

    public function edit($id)
    {
        $this->authCheck();

        $actionModel = $this->model('Action');

        $data['title'] = 'Ubah Aksi';
        $data['active_menu'] = 'action';
        $data['error'] = null;
        $data['action'] = $actionModel->getActionById($id);

        if (!$data['action']) {
            $_SESSION['error'] = 'Aksi tidak ditemukan.';
            $this->redirect('/uts-pwl/action');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (empty($name) || empty($description)) {
                $data['error'] = 'Semua field wajib diisi.';
                $data['old'] = $_POST;

            } else {
                $existing = $actionModel->findByName($name);

                if ($existing && $existing['id'] !== $id) {
                    $data['error'] = 'Nama sudah digunakan.';
                    $data['old'] = $_POST;

                } else {
                    try {
                        $actionModel->updateAction($id, $_POST);

                        $_SESSION['success'] = 'Aksi berhasil diperbarui.';

                        $this->redirect('/uts-pwl/action');

                    } catch (PDOException $e) {
                        $data['error'] = 'Gagal memperbarui aksi.';
                        $data['old'] = $_POST;
                    }
                }
            }
        }

        $this->view('action/edit', $data);
    }

    public function delete($id)
    {
        $this->authCheck();

        $actionModel = $this->model('Action');

        try {
            $actionModel->deleteAction($id);

            $_SESSION['success'] = 'Aksi berhasil dihapus.';
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Gagal menghapus aksi.';
        }

        $this->redirect('/uts-pwl/action');
    }

}