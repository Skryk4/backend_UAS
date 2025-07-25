<?php
// Tampilkan semua error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Header untuk CORS & JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Debug logging
$logData = [
    'method' => $_SERVER['REQUEST_METHOD'],
    'headers' => getallheaders(),
    'body' => file_get_contents("php://input")
];
file_put_contents("debug-update.log", json_encode($logData, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);

// Tangani preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'config.php';

// Tangani request PUT
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"));

    if ($data && isset($data->id)) {
        $id = (int)$data->id;
        $judul = mysqli_real_escape_string($coon, $data->judul ?? '');
        $isi = mysqli_real_escape_string($coon, $data->isi ?? '');
        $penulis = mysqli_real_escape_string($coon, $data->penulis ?? '');
        $tanggal = mysqli_real_escape_string($coon, $data->tanggal ?? '');

        if (!$judul || !$isi || !$penulis || !$tanggal) {
            echo json_encode(["success" => false, "message" => "Semua field wajib diisi."]);
            exit();
        }

        $query = "UPDATE artikel SET judul='$judul', isi='$isi', penulis='$penulis', tanggal='$tanggal' WHERE id=$id";
        $result = mysqli_query($coon, $query);

        if ($result) {
            echo json_encode(["success" => true, "message" => "Artikel berhasil diupdate."]);
        } else {
            echo json_encode(["success" => false, "message" => "Gagal update: " . mysqli_error($coon)]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "ID tidak ditemukan dalam request."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Hanya metode PUT yang diperbolehkan."]);
}
?>
