<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $judul = mysqli_real_escape_string($coon, $_POST['judul']);
  $penulis = mysqli_real_escape_string($coon, $_POST['penulis']);
  $tanggal = mysqli_real_escape_string($coon, $_POST['tanggal']);
  $isi = mysqli_real_escape_string($coon, $_POST['isi']);

  $query = "INSERT INTO artikel (judul, isi, penulis, tanggal) VALUES ('$judul', '$isi', '$penulis', '$tanggal')";
  $result = mysqli_query($coon, $query);

  if ($result) {
    header("Location: index.php");
    exit;
  } else {
    echo "Gagal menyimpan artikel: " . mysqli_error($coon);
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tambah Artikel</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      color: #333;
      padding: 20px;
    }
    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      max-width: 600px;
      margin: auto;
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="date"],
    textarea {
      width: 100%;
      padding: 8px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      font-size: 14px;
    }
    textarea {
      resize: vertical;
    }
    button {
      background-color: #4CAF50;
      color: white;
      padding: 10px 18px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }
    button:hover {
      background-color: #45a049;
    }
    a {
      margin-left: 10px;
      color: #555;
      text-decoration: none;
      font-size: 14px;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <h2>Form Tambah Artikel</h2>
  <form action="form_create.php" method="post">
    <label>Judul:</label>
    <input type="text" name="judul" required>

    <label>Penulis:</label>
    <input type="text" name="penulis" required>

    <label>Tanggal:</label>
    <input type="date" name="tanggal" required>

    <label>Isi:</label>
    <textarea name="isi" rows="5" required></textarea>

    <button type="submit">Simpan</button>
    <a href="index.php">Batal</a>
  </form>
</body>
</html>
