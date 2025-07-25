<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Debug logging
$logData = [
    'method' => $_SERVER['REQUEST_METHOD'],
    'headers' => getallheaders(),
    'body' => file_get_contents("php://input")
];
file_put_contents("debug-delete.log", json_encode($logData, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

include 'config.php';

// 1. Jika pakai DELETE dari Postman / frontend
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->id)) {
        $id = (int) $data->id;
        $query = "DELETE FROM artikel WHERE id=$id";
        $result = mysqli_query($coon, $query);

        if ($result) {
            echo json_encode(["success" => true, "message" => "Artikel berhasil dihapus"]);
        } else {
            echo json_encode(["success" => false, "message" => mysqli_error($coon)]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "ID tidak ditemukan"]);
    }
    exit();
}

// 2. Jika pakai URL biasa (GET) seperti delete.php?id=5
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    if ($id <= 0) {
        echo json_encode(["success" => false, "message" => "ID tidak valid"]);
        exit();
    }

    $query = "DELETE FROM artikel WHERE id=$id";
    $result = mysqli_query($coon, $query);

    if ($result) {
        // Redirect back to index.php after successful deletion
        header("Location: index.php");
        exit();
    } else {
        error_log("MySQL error on delete: " . mysqli_error($coon));
        echo json_encode(["success" => false, "message" => mysqli_error($coon)]);
        exit();
    }
}

// Jika metode tidak didukung
echo json_encode(["success" => false, "message" => "Metode tidak didukung atau ID tidak ada"]);
