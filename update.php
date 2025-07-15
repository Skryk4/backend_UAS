<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

include 'config.php';

$data = json_decode(file_get_contents("php://input"));

// debug log (optional):
file_put_contents("debug-update.txt", print_r($data, true));

if ($data && isset($data->id)) {
  $id = (int)$data->id;
  $judul = mysqli_real_escape_string($coon, $data->judul);
  $isi = mysqli_real_escape_string($coon, $data->isi);
  $penulis = mysqli_real_escape_string($coon, $data->penulis);
  $tanggal = mysqli_real_escape_string($coon, $data->tanggal);

  $query = "UPDATE artikel SET judul='$judul', isi='$isi', penulis='$penulis', tanggal='$tanggal' WHERE id=$id";
  $result = mysqli_query($coon, $query);

  if ($result) {
    echo json_encode(["success" => true]);
  } else {
    echo json_encode(["success" => false, "message" => mysqli_error($coon)]);
  }

} else {
  echo json_encode(["success" => false, "message" => "ID atau data tidak lengkap"]);
}
?>
