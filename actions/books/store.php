<?php
session_start();
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../validations/book-validation.php";

if (isset($_POST['store']) && $_SERVER['REQUEST_METHOD'] === "POST") {

    try {
        $pdo->beginTransaction();

        $request = getBookRequest($_POST);
        $errors = validateBook($request);

        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors['errors'];
            $_SESSION['old'] = $request;
            header("Location: ../../pages/books/create.php");
            exit();
        }

        $query = "INSERT INTO books (title, isbn, year, stock, category_id, description) VALUES (:title, :isbn, :year, :stock, :category_id, :description)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'title' => $request['title'],
            'isbn' => $request['isbn'],
            'year' => $request['year'],
            'stock' => $request['stock'],
            'category_id' => $request['category_id'],
            'description' => $request['description']
        ]);
        $book_id = $pdo->lastInsertId();
        $query = "INSERT INTO book_author (book_id, author_id) VALUES (:book_id, :author_id)";
        $stmt = $pdo->prepare($query);
        $authorIds = $request['author_ids'];
        foreach ($authorIds as $authorId) {
            $stmt->execute([
                'book_id' => $book_id,
                'author_id' => htmlspecialchars($authorId)
            ]);
        }
        $pdo->commit();
        header("Location: ../../pages/books/index.php");
        exit();

    } catch (PDOException $e) {
        $pdo->rollBack();
        throw $e;
    }
}

?>