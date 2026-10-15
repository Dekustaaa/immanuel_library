<?php
require_once __DIR__ . "/../config/database.php";
function getAuthors()
{
  global $pdo;
  $query = "SELECT id, name FROM authors";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $authors = $stmt->fetchAll();

  return $authors;
}

function getAuthor()
{
  $author = [
    "id"   => 1,
    "name" => "Andrea Hirata",
    "bio"  => "Penulis asal Belitung, dikenal lewat novel Laskar Pelangi.",
  ];

  return $author;
}
