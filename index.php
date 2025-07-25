<?php
// Aktifkan error agar jika ada masalah, muncul
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';

$result = mysqli_query($coon, "SELECT * FROM artikel ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manajemen Artikel Kampus</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
    th { background-color: #f0f0f0; }
    a { text-decoration: none; color: blue; }
    .btn { padding: 6px 12px; background: #007bff; color: white; border: none; text-decoration: none; }
  </style>
</head>
<body>
  <h2>📰 Daftar Artikel Kampus</h2>
  <a href="form_create.php" class="btn">➕ Tambah Artikel</a>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Penulis</th>
        <th>Tanggal</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if (mysqli_num_rows($result) > 0): ?>
        <?php $no = 1; ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['judul']) ?></td>
            <td><?= htmlspecialchars($row['penulis']) ?></td>
            <td><?= htmlspecialchars($row['tanggal']) ?></td>
            <td>
              <a href="form_edit.php?id=<?= $row['id'] ?>">✏️ Edit</a> |
              <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">🗑 Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5">Belum ada artikel.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
