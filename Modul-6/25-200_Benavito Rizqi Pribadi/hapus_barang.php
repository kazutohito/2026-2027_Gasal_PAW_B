<?php
include "koneksi.php";

$id = $_GET['id'];

$cek = mysqli_query($conn, "SELECT * FROM transaksi_detail WHERE barang_id=$id");
$dipakai = mysqli_fetch_assoc($cek);

if ($dipakai) {
  echo "<p>Barang tidak dapat dihapus karena masih digunakan pada transaksi!</p>";
  echo "<a href='barang.php'>Kembali</a>";
} else {
  $query = "DELETE FROM barang WHERE id=$id";

  if (mysqli_query($conn, $query)) {
    header("Location: barang.php");
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}
?>
