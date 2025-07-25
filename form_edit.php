<?php
include 'config.php';

if (!isset($_GET['id'])) {
    echo "<p style='color:red;'>ID tidak ditemukan di URL.</p>";
    exit;
}

$id = (int)$_GET['id'];
$result = mysqli_query($coon, "SELECT * FROM artikel WHERE id = $id");

if (!$result || mysqli_num_rows($result) === 0) {
    echo "<p style='color:red;'>Data artikel tidak ditemukan.</p>";
    exit;
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Artikel</title>
</head>
<body>
    <h2>Form Edit Artikel</h2>

    <form id="editForm">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <label>Judul:</label><br>
        <input type="text" name="judul" value="<?= htmlspecialchars($data['judul']) ?>"><br><br>

        <label>Penulis:</label><br>
        <input type="text" name="penulis" value="<?= htmlspecialchars($data['penulis']) ?>"><br><br>

        <label>Tanggal:</label><br>
        <input type="date" name="tanggal" value="<?= htmlspecialchars($data['tanggal']) ?>"><br><br>

        <label>Isi:</label><br>
        <textarea name="isi" rows="5" cols="50"><?= htmlspecialchars($data['isi']) ?></textarea><br><br>

        <button type="submit">Update</button>
        <a href="index.php">Batal</a>
    </form>

    <p id="message" style="color:red;"></p>

    <script>
        const form = document.getElementById("editForm");
        const message = document.getElementById("message");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            const jsonData = {};
            formData.forEach((value, key) => {
                jsonData[key] = value;
            });

            try {
                const res = await fetch("update.php", {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(jsonData)
                });

                const result = await res.json();
                if (result.success) {
                    alert("Artikel berhasil diupdate!");
                    window.location.href = "index.php";
                } else {
                    message.textContent = "Error: " + result.message;
                }
            } catch (err) {
                message.textContent = "Gagal terhubung ke server.";
                console.error(err);
            }
        });
    </script>
</body>
</html>
