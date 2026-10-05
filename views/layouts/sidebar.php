  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-heading">MENU UTAMA</li>

      <li class="nav-item">
        <a class="nav-link <?= ($data['active_menu'] ?? '') === 'account' ? '' : 'collapsed'; ?>" href="/uts-pwl/account">
          <i class="bi bi-people"></i>
          <span>Akun</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= ($data['active_menu'] ?? '') === 'account_type' ? '' : 'collapsed'; ?>" href="/uts-pwl/account-type">
          <i class="bi bi-shield-lock"></i>
          <span>Tipe Akun</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= ($data['active_menu'] ?? '') === 'action' ? '' : 'collapsed'; ?>" href="/uts-pwl/action">
          <i class="bi bi-sliders"></i>
          <span>Jenis Aksi</span>
        </a>
      </li>

    </ul>

  </aside>
