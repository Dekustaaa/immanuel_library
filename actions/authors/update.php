<?php
require_once __DIR__ . "/../../middleware/auth.php";
requireGuest();
if (isset($_POST['update']) && $_SERVER['REQUEST_METHOD'] === "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $bio = $_POST['bio'];

    print_r($_POST);
}

?>
