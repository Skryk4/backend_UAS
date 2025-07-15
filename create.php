<?php
file_put_contents("debug.txt", file_get_contents("php://input"));

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit();
}

include 'config.php';
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

if ($data) {
  $judul = $data->judul;
  $isi = $data->isi;
  $penulis = $data->penulis;
  $tanggal = $data->tanggal;

  $query = "INSERT INTO artikel (judul, isi, penulis, tanggal) VALUES ('$judul', '$isi', '$penulis', '$tanggal')";
  $result = mysqli_query($coon, $query);

  echo json_encode(["success" => $result]);
} else {
  echo json_encode(["success" => false, "message" => "Data tidak valid"]);
}
?>
