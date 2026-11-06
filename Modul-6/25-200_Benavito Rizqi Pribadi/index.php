<?php
include "koneksi.php";

$query = "SELECT transaksi.id, transaksi.waktu_transaksi, transaksi.keterangan, transaksi.total, pelanggan.nama
          FROM transaksi
          LEFT JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
          ORDER BY transaksi.id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Data Master Transaksi</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

  <div class="menu">
    <a href="index.php">Transaksi</a>
    <a href="barang.php">Barang</a>
  </div>

  <div class="header">
    <h2>Data Master Transaksi</h2>
    <a href="tambah.php" class="btn btn-tambah">Tambah Data</a>
  </div>

  <table>
    <tr>
      <th width="50">No</th>
      <th>Tanggal</th>
      <th>Pelanggan</th>
      <th>Keterangan</th>
      <th>Total</th>
      <th width="130">Tindakan</th>
    </tr>
    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $no . "</td>";
      echo "<td>" . $row['waktu_transaksi'] . "</td>";
      echo "<td>" . $row['nama'] . "</td>";
      echo "<td>" . $row['keterangan'] . "</td>";
      echo "<td class='kanan'>" . $row['total'] . "</td>";
      echo "<td>";
      echo "<a href='detail.php?id=" . $row['id'] . "' class='btn btn-kecil btn-detail'>Detail</a> ";
      echo "<a href='hapus.php?id=" . $row['id'] . "' 
      onclick=\"return confirm('Yakin ingin menghapus transaksi ini?')\" 
      class='btn btn-kecil btn-hapus'>Hapus</a>";
      echo "</td>";
      echo "</tr>";
      $no = $no + 1;
    }
    ?>
  </table>

</div>
</body>
</html>
