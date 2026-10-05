<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?= $data['title'] ?? 'Login'; ?></title>

  <link href="/uts-pwl/assets/css/font.css" rel="stylesheet">
  <link href="/uts-pwl/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/uts-pwl/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/uts-pwl/assets/css/style.css" rel="stylesheet">
</head>

<body class="bg-light">

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="card mb-3 shadow-sm border-0" style="border-radius: 12px; width: 100%; max-width: 400px;">
                <div class="card-body p-4">

                  <div class="text-center mb-4">
                    <div class="d-flex justify-content-center mb-3">
                      <img src="/uts-pwl/assets/img/eak.gif" alt="EAK" class="rounded-3 shadow-sm" style="width: 64px; height: 64px; object-fit: cover;">
                    </div>

                    <h5 class="card-title text-center p-0 fs-4 fw-bold text-dark">Manajemen Akun</h5>
                    <p class="text-center small text-muted mb-0">Masuk pakai email dan password kamu.</p>
                  </div>

                  <?php if (!empty($data['error'])) : ?>
                    <div class="alert alert-danger py-2 px-3 small" role="alert">
                      <?= $data['error']; ?>
                    </div>
                  <?php endif; ?>

                  <form class="row g-3" action="/uts-pwl/login" method="POST">

                    <div class="col-12">
                      <label for="email" class="form-label fw-semibold small text-secondary">Email</label>
                      <input type="email" name="email" class="form-control" id="email" required autofocus>
                    </div>

                    <div class="col-12">
                      <label for="password" class="form-label fw-semibold small text-secondary">Password</label>
                      <input type="password" name="password" class="form-control" id="password" required>
                    </div>

                    <div class="col-12 mt-4">
                      <button class="btn btn-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2 fw-semibold" type="submit">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                      </button>
                    </div>

                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>
      </section>

    </div>
  </main>

  <script src="/uts-pwl/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
