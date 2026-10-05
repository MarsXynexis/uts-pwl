<?php require_once 'views/layouts/header.php'; ?>

<?php require_once 'views/layouts/sidebar.php'; ?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Tambah Akun</h1>

    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/uts-pwl">Home</a></li>
        <li class="breadcrumb-item"><a href="/uts-pwl/account">Manajemen Akun</a></li>
        <li class="breadcrumb-item active">Tambah Akun</li>
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

            <h5 class="card-title">Tambah Akun</h5>

            <form action="/uts-pwl/account/create" method="POST" class="row g-3">

              <div class="col-md-6">
                <label for="name" class="form-label fw-semibold">Nama</label>
                <input type="text" name="name" class="form-control" id="name" value="<?= htmlspecialchars($data['old']['name'] ?? ''); ?>" required>
              </div>

              <div class="col-md-6">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="<?= htmlspecialchars($data['old']['email'] ?? ''); ?>" required>
              </div>

              <div class="col-12">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" id="password" minlength="8" required>
              </div>

              <div class="col-md-6">
                <label for="account_type_id" class="form-label fw-semibold">Tipe Akun</label>
                <select name="account_type_id" id="account_type_id" class="form-select" required>
                  <option value="">Pilih Tipe Akun</option>
                  <?php foreach ($data['account_types'] as $type) : ?>
                    <option value="<?= $type['id']; ?>" <?= ($data['old']['account_type_id'] ?? '') === $type['id'] ? 'selected' : ''; ?>>
                      <?= htmlspecialchars($type['name']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-6">
                <label for="status" class="form-label fw-semibold">Status</label>
                <select name="status" id="status" class="form-select" required>
                  <option value="Aktif" <?= ($data['old']['status'] ?? 'Aktif') === 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                  <option value="Nonaktif" <?= ($data['old']['status'] ?? '') === 'Nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="identification_type" class="form-label fw-semibold">Jenis Identitas</label>
                <select name="identification_type" id="identification_type" class="form-select" required>
                  <option value="NIM" <?= ($data['old']['identification_type'] ?? '') === 'NIM' ? 'selected' : ''; ?>>NIM</option>
                  <option value="NIP" <?= ($data['old']['identification_type'] ?? '') === 'NIP' ? 'selected' : ''; ?>>NIP</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="identification_number" class="form-label fw-semibold">Nomor Identitas (NIM / NIP)</label>
                <input type="text" name="identification_number" class="form-control" id="identification_number" value="<?= htmlspecialchars($data['old']['identification_number'] ?? ''); ?>" required>
              </div>

              <div class="col-12 mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="/uts-pwl/account" class="btn btn-secondary">Batal</a>
              </div>

            </form>

          </div>
        </div>

      </div>
    </div>
  </section>

</main>

<?php require_once 'views/layouts/footer.php'; ?>
