<?php
include "koneksi.php";

// kalau tombol simpan ditekan, simpan data master transaksi
if (isset($_POST['simpan'])) {
  $tanggal = $_POST['waktu_transaksi'];
  $pelanggan_id = $_POST['pelanggan_id'];
  $keterangan = $_POST['keterangan'];

  // total awal 0, nanti dihitung saat detail transaksi diisi
  $query = "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id)
            VALUES ('$tanggal', '$keterangan', 0, '$pelanggan_id')";

  if (mysqli_query($conn, $query)) {
    header("Location: index.php");
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}

// data pelanggan untuk dropdown
$pelanggan = mysqli_query($conn, "SELECT id, nama FROM pelanggan ORDER BY nama");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Tambah Data Master Transaksi</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

  <div class="header">
    <h2>Tambah Data Master Transaksi Baru</h2>
  </div>

  <form method="post">
    <div class="form-baris">
      <label>Tanggal</label>
      <input type="date" name="waktu_transaksi" required>
    </div>
    <div class="form-baris">
      <label>Pelanggan</label>
      <select name="pelanggan_id" required>
        <option value="">-- Pilih Pelanggan --</option>
        <?php
        while ($row = mysqli_fetch_assoc($pelanggan)) {
          echo "<option value='" . $row['id'] . "'>" . $row['nama'] . "</option>";
        }
        ?>
      </select>
    </div>
    <div class="form-baris">
      <label>Keterangan</label>
      <input type="text" name="keterangan" placeholder="keterangan" required>
    </div>
    <div class="form-tombol">
      <button type="submit" name="simpan" class="btn btn-simpan">Simpan</button>
      <a href="index.php" class="btn btn-batal">Batal</a>
    </div>
  </form>

</div>
</body>
</html>
