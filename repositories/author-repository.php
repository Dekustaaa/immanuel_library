<?php
require_once __DIR__ . "/../config/database.php";
function getAuthors()
{
  global $pdo;
  $query = "SELECT a.id, a.name, COUNT(ba.book_id) AS total_books FROM authors a
            LEFT JOIN book_author ba ON ba.author_id = a.id
            GROUP BY a.id";
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
