<?php

require_once __DIR__ . "/../config/database.php";

function getBooks()
{
  global $pdo;
  $query = "SELECT b.id, b.title, b.stock, c.name as category FROM books b
            LEFT JOIN categories c ON b.category_id = c.id
            ";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $books = $stmt->fetchAll();

  $query = "SELECT ba.book_id, a.name FROM book_author ba
            LEFT JOIN authors a ON ba.author_id = a.id
            ";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $bookAuthors = $stmt->fetchAll();

  $bookByAuthors = [];
  foreach ($bookAuthors as $bookAuthor) {
    $bookByAuthors[$bookAuthor['book_id']][] = $bookAuthor['name'];
  }
  foreach ($books as $index => $book) {
    $books[$index]['authors'] = $bookByAuthors[$book['id']] ?? [];
  }

  return $books;
}

function getBook($id)
{
  global $pdo;
  
  $query = "SELECT id, title, isbn, year, stock, category_id, description FROM books WHERE id = :id";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'id' => $id
  ]);

  $book = $stmt->fetch();

  if (!$book){
    header("Location: ../books/index.php");
    exit;
  }

  $query = "SELECT a.id FROM book_author ba
           LEFT JOIN authors a ON ba.author_id = a.id 
           WHERE ba.book_id = :book_id
           ";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'book_id' => $book['id']
  ]);

  $authorIds = $stmt->fetchAll();

  $book['author_ids'] = array_column($authorIds, 'id');
  return $book;
}