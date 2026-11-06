CREATE DATABASE penjualan;
USE penjualan;

CREATE TABLE users (
    id_user TINYINT AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(35) NOT NULL,
    nama VARCHAR(50) NOT NULL,
    alamat VARCHAR(150) NOT NULL,
    hp VARCHAR(20) NOT NULL,
    level TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id_user, username)
);

CREATE TABLE pelanggan (
    id VARCHAR(20) PRIMARY KEY NOT NULL,
    nama VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L','P') NOT NULL,
    telp VARCHAR(12) NOT NULL,
    alamat TEXT
);

CREATE TABLE supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    telp VARCHAR(12) NOT NULL,
    alamat TEXT NOT NULL
);

CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(10) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL,
    supplier_id INT NOT NULL,
    CONSTRAINT fk_barang_supplier FOREIGN KEY (supplier_id) REFERENCES supplier(id),
    UNIQUE KEY uk_kode_barang (kode_barang)
);

CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    waktu_transaksi DATE NOT NULL,
    keterangan TEXT NOT NULL,
    total INT NOT NULL,
    pelanggan_id VARCHAR(20) NOT NULL,
    CONSTRAINT fk_transaksi_pelanggan FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
);

CREATE TABLE transaksi_detail (
    transaksi_id INT NOT NULL,
    barang_id INT NOT NULL,
    harga INT NOT NULL,
    qty INT NOT NULL,
    CONSTRAINT fk_detail_transaksi FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_detail_barang FOREIGN KEY (barang_id) REFERENCES barang(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    PRIMARY KEY (transaksi_id,barang_id)
);


CREATE TABLE pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    waktu_bayar DATETIME NOT NULL,
    total INT NOT NULL,
    metode ENUM('Tunai','Transfer','EDC') NOT NULL,
    transaksi_id INT NOT NULL,
    CONSTRAINT fk_pembayaran_transaksi FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
);