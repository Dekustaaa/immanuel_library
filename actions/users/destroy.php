<?php
require_once __DIR__ . "/../../middleware/auth.php";
requireRole(['admin']);
if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === "GET") {
    $id = $_GET['id'];

    echo "Pengguna dengan id " . htmlspecialchars($id) . " berhasil dihapus.";
}

?>
