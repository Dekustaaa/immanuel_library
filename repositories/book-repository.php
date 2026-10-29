<?php

require_once __DIR__ . "/../config/database.php";

function getBooks($search, $categoryId, $currentPage, $perPage)
{
  global $pdo;
  $query = "select b.id, b.title, b.stock, c.name as category from books b
            left join categories c on b.category_id = c.id
            where b.title like :search
            and (:category_filter = '' or b.category_id = :category_id)
            limit :limit offset :offset
            ";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'search' => "%$search%",
    'category_filter' => $categoryId,
    'category_id' => $categoryId,
    'limit' => $perPage,
    'offset' => ($currentPage - 1) * $perPage,
  ]);
  $books = $stmt->fetchAll();
  $query = "select ba.book_id, a.name from book_author ba
            left join authors a on ba.author_id = a.id";
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
  
  $query = "SELECT b.id, b.title, b.isbn, b.year, b.stock, b.category_id, b.description, c.name AS category
            FROM books b
            LEFT JOIN categories c ON b.category_id = c.id
            WHERE b.id = :id";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'id' => $id
  ]);

  $book = $stmt->fetch();

  if (!$book){
    header("Location: index.php");
    exit;
  }

  $query = "SELECT a.id, a.name FROM book_author ba
           LEFT JOIN authors a ON ba.author_id = a.id 
           WHERE ba.book_id = :book_id
           ";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'book_id' => $book['id']
  ]);

  $bookAuthors = $stmt->fetchAll();

  $book['author_ids'] = array_column($bookAuthors, 'id');
  $book['authors'] = array_column($bookAuthors, 'name');
  return $book;
}
function isIsbnTaken($isbn, $ignoreBookId)
{
  global $pdo;
  $bookId = intval($ignoreBookId);
  $query = "select count(id) from books where isbn = :isbn && id != :book_id";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'isbn' => $isbn,
    'book_id' => $bookId
  ]);
  $isIsbnTaken = $stmt->fetchColumn() > 0;
  return $isIsbnTaken;
}
function countOfBooks($search, $categoryId){
  global $pdo;

  $query = "select count(id) from books where title like :title";
  $params = ['title' => "%$search%"];

  if ($categoryId !== '' && $categoryId !== null) {
    $query .= " and category_id = :category_id";
    $params['category_id'] = $categoryId;
  }

  $stmt = $pdo->prepare($query);
  $stmt->execute($params);
  $totalBooks = $stmt->fetchColumn();
  return $totalBooks;
}