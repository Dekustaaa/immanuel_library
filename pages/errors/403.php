<?php
require_once __DIR__ . "/../../middleware/auth.php";

requireAuth();
http_response_code(403);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Akses Ditolak - Perpustakaan Digital</title>
  <link rel="stylesheet" href="../../styles/base.css">
</head>

<body style="display:flex; min-height:100vh; align-items:center; justify-content:center; text-align:center;">
  <div>
    <h1 style="font-family: var(--font-display); font-size: 4rem;">403</h1>
    <p style="margin: 8px 0 20px; color: var(--ink-soft);">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
    <a href="../books/index.php" class="btn btn-primary">Kembali ke Beranda</a>
  </div>
</body>

</html>