<?php
// Header CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Tangani preflight request dari browser (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'config.php';

$data = json_decode(file_get_contents("php://input"));

if ($data && isset($data->id)) {
  $id = $data->id;

  $query = "DELETE FROM artikel WHERE id=$id";
  $result = mysqli_query($coon, $query);

  echo json_encode(["success" => $result]);
} else {
  echo json_encode(["success" => false, "message" => "ID tidak valid"]);
}
?>
