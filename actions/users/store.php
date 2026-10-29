<?php
require_once __DIR__ . "/../../middleware/auth.php";
requireRole(['admin']);
if (isset($_POST['store']) && $_SERVER['REQUEST_METHOD'] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    print_r($_POST);
}

?>
