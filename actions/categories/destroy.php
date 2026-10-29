<?php
require_once __DIR__ . "/../../middleware/auth.php";
requireGuest();
if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === "GET") {
    $id = $_GET['id'];

    echo "Kategori dengan id " . htmlspecialchars($id) . " berhasil dihapus.";
}

?>
