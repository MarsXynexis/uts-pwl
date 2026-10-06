<?php require_once 'views/layouts/header.php'; ?>

<?php require_once 'views/layouts/sidebar.php'; ?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Manajemen Tipe Akun</h1>

    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/uts-pwl">Home</a></li>
        <li class="breadcrumb-item active">Manajemen Tipe Akun</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body pt-3">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">

              <form action="/uts-pwl/account-type" method="GET" class="d-flex gap-2 flex-grow-1" style="max-width: 480px;">
                <div class="input-group">
                  <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                  <input type="text" name="search" class="form-control" placeholder="Cari tipe akun..." value="<?= htmlspecialchars($data['search'] ?? ''); ?>">
                  <button type="submit" class="btn btn-primary">Cari</button>

                  <?php if (!empty($data['search'])) : ?>
                    <a href="/uts-pwl/account-type" class="btn btn-outline-secondary">Reset</a>
                  <?php endif; ?>
                </div>
              </form>

              <a href="/uts-pwl/account-type/create" class="btn btn-primary d-flex align-items-center gap-1">
                <i class="bi bi-plus-lg"></i> Tambah Tipe Akun
              </a>

            </div>

            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Dibuat</th>
                    <th class="text-center" style="width: 120px;">Aksi</th>
                  </tr>
                </thead>

                <tbody>
                  <?php if (!empty($data['account-types'])) : ?>
                    <?php foreach ($data['account-types'] as $type) : ?>
                      <tr>
                        <td class="fw-semibold text-dark"><?= htmlspecialchars($type['name']); ?></td>
                        <td><?= htmlspecialchars($type['description']); ?></td>
                        <td>
                          <span class="text-secondary small"><?= htmlspecialchars($type['created_at']); ?></span>
                        </td>
                        <td class="text-center">
                          <a href="/uts-pwl/account-type/edit/<?= $type['id']; ?>" class="btn btn-sm btn-outline-warning me-1" title="Ubah">
                            <i class="bi bi-pencil"></i>
                          </a>

                          <?php if ($type['id'] !== $_SESSION['user']['id']) : ?>
                            <a href="/uts-pwl/account-type/delete/<?= $type['id']; ?>" class="btn btn-sm btn-outline-danger btn-delete" title="Hapus">
                              <i class="bi bi-trash"></i>
                            </a>
                          <?php else : ?>
                            <button class="btn btn-sm btn-outline-secondary" title="Tidak dapat menghapus akun sendiri" disabled>
                              <i class="bi bi-trash"></i>
                            </button>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td colspan="6" class="text-center py-4 text-muted">
                        Tidak ada data akun.
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

</main>

<?php require_once 'views/layouts/footer.php'; ?>
