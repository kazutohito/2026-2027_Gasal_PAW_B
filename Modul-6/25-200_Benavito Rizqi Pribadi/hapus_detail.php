<?php
include "koneksi.php";

$id = $_GET['id'];
$barang_id = $_GET['barang_id'];

$query = "DELETE FROM transaksi_detail WHERE transaksi_id=$id AND barang_id=$barang_id";

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
?>
