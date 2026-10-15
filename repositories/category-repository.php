<?php
require_once __DIR__ . "/../config/database.php";
function getCategories()
{
  global $pdo;
  $query = "SELECT c.*, COUNT(b.id) AS total_books FROM categories c
            LEFT JOIN books b ON b.category_id = c.id
            GROUP BY c.id, c.name, c.description";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $categories = $stmt->fetchAll();

  return $categories;
}

function getCategory()
{
  $category = [
    "id"          => 1,
    "name"        => "Fiksi",
    "description" => "Novel dan cerita rekaan",
  ];

  return $category;
}
