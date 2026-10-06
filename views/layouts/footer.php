  <footer id="footer" class="footer">
    <div class="copyright text-center py-3 text-muted">
      &copy; UTS PWL <strong><span>TI 3C Tandain</span></strong>
    </div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="/uts-pwl/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>window.Swal || document.write('<script src="/uts-pwl/assets/vendor/sweetalert2/sweetalert2.all.min.js"><\/script>')</script>

  <script src="/uts-pwl/assets/js/main.js"></script>

  <?php
    $flashSuccess = $data['success'] ?? $_SESSION['success'] ?? null;
    $flashError = $data['error'] ?? $_SESSION['error'] ?? null;
    unset($_SESSION['success'], $_SESSION['error']);
  ?>

  <?php if (!empty($flashSuccess)) : ?>
    <script>
      const ToastSuccess = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer);
          toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
      });

      ToastSuccess.fire({
        icon: 'success',
        title: '<?= htmlspecialchars($flashSuccess, ENT_QUOTES); ?>'
      });
    </script>
  <?php endif; ?>

  <?php if (!empty($flashError)) : ?>
    <script>
      const ToastError = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer);
          toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
      });

      ToastError.fire({
        icon: 'error',
        title: '<?= htmlspecialchars($flashError, ENT_QUOTES); ?>'
      });
    </script>
  <?php endif; ?>

  <script>
    document.addEventListener('click', function(e) {
      const deleteBtn = e.target.closest('.btn-delete');

      if (deleteBtn) {
        e.preventDefault();

        const url = deleteBtn.getAttribute('href');

        const swalBootstrap = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-danger mx-1',
            cancelButton: 'btn btn-secondary mx-1'
          },
          buttonsStyling: false
        });

        swalBootstrap.fire({
          title: 'Apakah Anda yakin?',
          text: 'Data yang dihapus akan dipindahkan ke soft delete.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = url;
          }
        });
      }
    });
  </script>

</body>
</html>
