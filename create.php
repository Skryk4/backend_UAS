<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

include 'config.php';

// Ambil data dari JSON body
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Debug jika parsing gagal
if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "Format JSON tidak valid atau kosong",
        "debug_raw" => $rawData
    ]);
    exit;
}

// Validasi input
if (
    isset($data["judul"]) && !empty($data["judul"]) &&
    isset($data["penulis"]) && !empty($data["penulis"]) &&
    isset($data["tanggal"]) && !empty($data["tanggal"]) &&
    isset($data["isi"]) && !empty($data["isi"])
) {
    $judul = mysqli_real_escape_string($coon, $data["judul"]);
    $penulis = mysqli_real_escape_string($coon, $data["penulis"]);
    $tanggal = mysqli_real_escape_string($coon, $data["tanggal"]);
    $isi = mysqli_real_escape_string($coon, $data["isi"]);

    $query = "INSERT INTO artikel (judul, penulis, tanggal, isi)
              VALUES ('$judul', '$penulis', '$tanggal', '$isi')";

    if (mysqli_query($coon, $query)) {
        echo json_encode(["success" => true, "message" => "Artikel berhasil ditambahkan"]);
    } else {
        echo json_encode(["success" => false, "message" => mysqli_error($coon)]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Data tidak lengkap",
        "received" => $data
    ]);
}
?>
