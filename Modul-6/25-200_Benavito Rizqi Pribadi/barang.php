<?php
include "koneksi.php";

$query = "SELECT barang.id, barang.kode_barang, barang.nama_barang, barang.harga, barang.stok, supplier.nama
          FROM barang
          LEFT JOIN supplier ON barang.supplier_id = supplier.id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Data Master Barang</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

  <div class="menu">
    <a href="index.php">Transaksi</a>
    <a href="barang.php">Barang</a>
  </div>

  <div class="header">
    <h2>Data Master Barang</h2>
  </div>

  <table>
    <tr>
      <th width="50">No</th>
      <th>Kode</th>
      <th>Nama Barang</th>
      <th>Harga</th>
      <th>Stok</th>
      <th>Supplier</th>
      <th width="80">Tindakan</th>
    </tr>
    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $no . "</td>";
      echo "<td>" . $row['kode_barang'] . "</td>";
      echo "<td>" . $row['nama_barang'] . "</td>";
      echo "<td class='kanan'>" . $row['harga'] . "</td>";
      echo "<td class='kanan'>" . $row['stok'] . "</td>";
      echo "<td>" . $row['nama'] . "</td>";
      echo "<td>";
      echo "<a href='hapus_barang.php?id=" . $row['id'] . "' class='btn btn-kecil btn-hapus'>Hapus</a>";
      echo "</td>";
      echo "</tr>";
      $no = $no + 1;
    }
    ?>
  </table>

</div>
</body>
</html>
