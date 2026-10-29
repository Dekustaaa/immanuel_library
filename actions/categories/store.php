<?php
require_once __DIR__ . "/../../middleware/auth.php";
requireGuest();
if (isset($_POST['store']) && $_SERVER['REQUEST_METHOD'] === "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];

    print_r($_POST);
}

?>
