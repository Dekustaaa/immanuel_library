<?php
require_once __DIR__ . "/../../middleware/auth.php";
requireAuth();
if (isset($_POST['update']) && $_SERVER['REQUEST_METHOD'] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $bio = $_POST['bio'];

    print_r($_POST);
}

?>
