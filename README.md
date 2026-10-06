# UTS PWL (PHP Native MVC)

Tutorial setup no root 100% work no password download link di bio

## Setup Awal

1. Git clone terus taro di htdocs (sesuaiin aja XAMPP atau Laragoon, running kek PHP biasa ga pake composer jadinya kek: `localhost/uts-pwl`)
2. Copy file `.env.example` terus rename jadi `.env`, sesuaiin ajah sama nama db:
   ```env
   DB_HOST=localhost
   DB_PORT=3306
   DB_NAME=PBL_TI_2025_3C_NAMA (ganti NAMA pake nama mas rusdi)
   DB_USER=root
   DB_PASS= (kalo laragoon tergantung orangnya)
   ```
3. Bikin database di phpMyKisah (sesuai nama db di `.env`)
4. Nyalain Apache & MySQL, buka di browser: `http://localhost/uts-pwl`

## Struktur Folder

- `controllers/`: Tempat buat logic halaman / controller berakhiran Controller (contoh: `HomeController.php`, `AuthController.php`, `AccountController.php`).
- `models/`: Tempat naro query db (contoh: `Account.php`, `AccountType.php`).
- `views/`: Tempat file tampilan HTML/PHP (contoh: `home/index.php`, `account/index.php`).
- `core/`: Ada deh pokoknya gausah diotak atik anuannya
