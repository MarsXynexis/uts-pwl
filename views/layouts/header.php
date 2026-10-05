<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?= $data['title'] ?? 'UTS PWL'; ?></title>

  <link href="/uts-pwl/assets/css/font.css" rel="stylesheet">
  <link href="/uts-pwl/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/uts-pwl/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/uts-pwl/assets/css/style.css" rel="stylesheet">
</head>

<body>

  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="/uts-pwl" class="logo d-flex align-items-center text-decoration-none">
        <img src="/uts-pwl/assets/img/eak.gif" alt="EAK" class="rounded-3 shadow-sm me-2" style="height: 48px; width: 48px; object-fit: cover;">
        <span class="d-none d-lg-block fw-bold fs-5">Manajemen Akun</span>
      </a>

      <i class="bi bi-list toggle-sidebar-btn fs-4 ms-2" style="cursor: pointer;"></i>
    </div>

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center m-0 p-0 list-unstyled">

        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-1 fw-semibold text-dark"><?= $_SESSION['user']['name'] ?? 'Administrator'; ?></span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile mt-2 shadow-sm">
            <li class="dropdown-header text-start px-3 py-2">
              <h6 class="m-0 fw-bold"><?= $_SESSION['user']['name'] ?? 'Administrator'; ?></h6>
              <small class="text-muted"><?= $_SESSION['user']['email'] ?? 'admin@uts.ac.id'; ?></small>
            </li>

            <li><hr class="dropdown-divider my-1"></li>

            <li>
              <a class="dropdown-item d-flex align-items-center text-danger py-2" href="/uts-pwl/logout">
                <i class="bi bi-box-arrow-right me-2"></i>
                <span>Logout</span>
              </a>
            </li>
          </ul>
        </li>

      </ul>
    </nav>

  </header>
