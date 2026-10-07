<?php require_once 'views/layouts/header.php'; ?>

<?php require_once 'views/layouts/sidebar.php'; ?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Tambah Aksi</h1>

    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/uts-pwl">Home</a></li>
        <li class="breadcrumb-item"><a href="/uts-pwl/action">Manajemen Aksi</a></li>
        <li class="breadcrumb-item active">Tambah Aksi</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <?php if (!empty($data['error'])) : ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $data['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <div class="card">
          <div class="card-body pt-3">

            <h5 class="card-title">Tambah Aksi</h5>

            <form action="/uts-pwl/action/create" method="POST" class="row g-3">

              <div class="col-md-6">
                <label for="action_name" class="form-label fw-semibold">Nama Aksi</label>
                <input type="text" name="name" class="form-control" id="name" value="<?= htmlspecialchars($data['old']['name'] ?? ''); ?>" required>
              </div>

              <div class="col-md-6">
                <label for="description" class="form-label fw-semibold">Deskripsi</label>
                <input type="text" name="description" class="form-control" id="description" value="<?= htmlspecialchars($data['old']['description'] ?? ''); ?>" required>
              </div>

              <div class="col-12 mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="/uts-pwl/action" class="btn btn-secondary">Batal</a>
              </div>

            </form>

          </div>
        </div>

      </div>
    </div>
  </section>

</main>

<?php require_once 'views/layouts/footer.php'; ?>
