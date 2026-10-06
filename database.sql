CREATE DATABASE IF NOT EXISTS PBL_TI_2025_3C_NAMA;
USE PBL_TI_2025_3C_NAMA;

DROP TABLE IF EXISTS accounts;
DROP TABLE IF EXISTS actions;
DROP TABLE IF EXISTS account_type;

CREATE TABLE IF NOT EXISTS account_type (
  id VARCHAR(36) PRIMARY KEY,
  name VARCHAR(128) NOT NULL,
  description TEXT,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  deleted_at DATETIME DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS actions (
  id VARCHAR(36) PRIMARY KEY,
  name VARCHAR(128) NOT NULL,
  description TEXT,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  deleted_at DATETIME DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS accounts (
  id VARCHAR(36) PRIMARY KEY,
  name VARCHAR(128) NOT NULL,
  email VARCHAR(128) NOT NULL UNIQUE,
  password TEXT NOT NULL,
  account_type_id VARCHAR(36) NOT NULL,
  status VARCHAR(128) NOT NULL,
  identification_number VARCHAR(128) NOT NULL,
  identification_type ENUM('NIM', 'NIP') NOT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  deleted_at DATETIME DEFAULT NULL,
  CONSTRAINT fk_accounts_account_type FOREIGN KEY (account_type_id) REFERENCES account_type(id) ON UPDATE CASCADE ON DELETE RESTRICT
);

SET @admin_type_id = UUID();

INSERT INTO account_type (id, name, description, created_at, updated_at) VALUES
(@admin_type_id, 'Admin', 'Pengelola sistem, punya akses penuh.', NOW(), NOW()),
(UUID(), 'Dosen', 'Akun untuk dosen (identitas NIP).', NOW(), NOW()),
(UUID(), 'Mahasiswa', 'Akun untuk mahasiswa (identitas NIM).', NOW(), NOW());

INSERT INTO actions (id, name, description, created_at, updated_at) VALUES
(UUID(), 'Create', 'Menambahkan data baru', NOW(), NOW()),
(UUID(), 'Read', 'Melihat data', NOW(), NOW()),
(UUID(), 'Update', 'Mengubah data yang sudah ada', NOW(), NOW()),
(UUID(), 'Delete', 'Menghapus data (soft delete)', NOW(), NOW());

INSERT INTO accounts (id, name, email, password, account_type_id, status, identification_number, identification_type, created_at, updated_at) VALUES
(UUID(), 'Administrator', 'admin@pnj.ac.id', '$2y$10$MCHTrjpFRGAYQWp8YIXQRurpwkjGOIOr/Ws0XqlWwZJKwsI0hn/Pi', @admin_type_id, 'Aktif', '520000000000000746', 'NIP', NOW(), NOW());
