<?php
require_once __DIR__ . "/../../middleware/auth.php";
requireRole(['admin']);
if (isset($_POST['update']) && $_SERVER['REQUEST_METHOD'] === "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    print_r($_POST);
}

?>
