<?php
include "koneksi.php";

$id = $_GET['id'];

if (isset($_POST['simpan'])) {
  $barang_id = (int) $_POST['barang_id'];
  $qty = (int) $_POST['qty'];
  $transaksi_id = (int) $_GET['id'];

  if ($barang_id <= 0 || $qty <= 0 || $transaksi_id <= 0) {
      die("Data barang, jumlah, atau transaksi tidak valid!");
  }

  $q_barang = mysqli_query($conn, "SELECT harga FROM barang WHERE id=$barang_id");
  $barang = mysqli_fetch_assoc($q_barang);
  $harga = $barang['harga'];

  $query = "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty)
            VALUES ($id, $barang_id, $harga, $qty)";

  if (mysqli_query($conn, $query)) {
    $total = 0;
    $q_hitung = mysqli_query($conn, "SELECT harga, qty FROM transaksi_detail WHERE transaksi_id=$id");
    while ($row = mysqli_fetch_assoc($q_hitung)) {
      $total = $total + ($row['harga'] * $row['qty']);
    }

    mysqli_query($conn, "UPDATE transaksi SET total=$total WHERE id=$id");

    header("Location: detail.php?id=$id");
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}

$q_master = mysqli_query($conn, "SELECT transaksi.id, transaksi.waktu_transaksi, transaksi.keterangan, transaksi.total, pelanggan.nama
                                 FROM transaksi
                                 LEFT JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
                                 WHERE transaksi.id=$id");
$master = mysqli_fetch_assoc($q_master);

$q_detail = mysqli_query($conn, "SELECT transaksi_detail.barang_id, transaksi_detail.harga, transaksi_detail.qty, barang.kode_barang, barang.nama_barang
                                 FROM transaksi_detail
                                 INNER JOIN barang ON transaksi_detail.barang_id = barang.id
                                 WHERE transaksi_detail.transaksi_id=$id");

$q_barang_semua = mysqli_query($conn, "SELECT id, kode_barang, nama_barang, harga FROM barang ORDER BY nama_barang");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Detail Transaksi</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

  <div class="menu">
    <a href="index.php">Transaksi</a>
    <a href="barang.php">Barang</a>
  </div>

  <div class="header">
    <h2>Detail Transaksi #<?php echo $master['id']; ?></h2>
    <a href="index.php" class="btn btn-batal">Kembali</a>
  </div>

  <div class="info">
    <p><b>Tanggal:</b> <?php echo $master['waktu_transaksi']; ?></p>
    <p><b>Pelanggan:</b> <?php echo $master['nama']; ?></p>
    <p><b>Keterangan:</b> <?php echo $master['keterangan']; ?></p>
    <p><b>Total:</b> <?php echo $master['total']; ?></p>
  </div>

  <h3>Tambah Barang</h3>
  <form method="post">
    <div class="form-baris">
      <label>Barang</label>
      <select name="barang_id" required>
        <option value="">-- Pilih Barang --</option>
        <?php
        while ($row = mysqli_fetch_assoc($q_barang_semua)) {
          $cek = mysqli_query($conn, "SELECT * FROM transaksi_detail WHERE transaksi_id=$id AND barang_id=" . $row['id']);
          $sudah = mysqli_fetch_assoc($cek);

          if (!$sudah) {
            echo "<option value='" . $row['id'] . "'>";
            echo $row['kode_barang'] . " - " . $row['nama_barang'] . " (" . $row['harga'] . ")";
            echo "</option>";
          }
        }
        ?>
      </select>
    </div>
    <div class="form-baris">
      <label>Qty</label>
      <input type="number" name="qty" min="1" value="1" required>
    </div>
    <div class="form-tombol">
      <button type="submit" name="simpan" class="btn btn-simpan">Simpan</button>
    </div>
  </form>

  <h3>Daftar Barang</h3>
  <table>
    <tr>
      <th width="50">No</th>
      <th>Kode</th>
      <th>Nama Barang</th>
      <th>Harga</th>
      <th>Qty</th>
      <th>Subtotal</th>
      <th width="80">Tindakan</th>
    </tr>
    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($q_detail)) {
      echo "<tr>";
      echo "<td>" . $no . "</td>";
      echo "<td>" . $row['kode_barang'] . "</td>";
      echo "<td>" . $row['nama_barang'] . "</td>";
      echo "<td class='kanan'>" . $row['harga'] . "</td>";
      echo "<td class='kanan'>" . $row['qty'] . "</td>";
      echo "<td class='kanan'>" . ($row['harga'] * $row['qty']) . "</td>";
      echo "<td>";
      echo "<a href='hapus_detail.php?id=" . $id . "&barang_id=" . $row['barang_id'] . "' class='btn btn-kecil btn-hapus'>Hapus</a>";
      echo "</td>";
      echo "</tr>";
      $no = $no + 1;
    }
    ?>
    <tr>
      <th colspan="5" class="kanan">Total</th>
      <th class="kanan"><?php echo $master['total']; ?></th>
      <th></th>
    </tr>
  </table>

</div>
</body>
</html>
