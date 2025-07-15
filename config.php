<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "kampus_db"; // ganti sesuai nama database kamu

$coon = mysqli_connect($host, $user, $pass, $db);

if (!$coon) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
?>
