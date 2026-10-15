<?php
require_once __DIR__ . "/../../config/database.php";

if (isset($_POST['store']) && $_SERVER['REQUEST_METHOD'] === "POST") {

    try {
        $pdo->beginTransaction();

        $title = htmlspecialchars($_POST['title']);
        $isbn = htmlspecialchars($_POST['isbn']);
        $year = htmlspecialchars($_POST['year']);
        $stock = htmlspecialchars($_POST['stock']);
        $categoryId = htmlspecialchars($_POST['category_id']);
        $description = htmlspecialchars($_POST['description']);

        $query = "INSERT INTO books (title, isbn, year, stock, category_id, description) VALUES (:title, :isbn, :year, :stock, :category_id, :description)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':title' => $title,
            ':isbn' => $isbn,
            ':year' => $year,
            ':stock' => $stock,
            ':category_id' => $categoryId,
            ':description' => $description
        ]);
        $book_id = $pdo->lastInsertId();
        $query = "INSERT INTO book_author (book_id, author_id) VALUES (:book_id, :author_id)";
        $stmt = $pdo->prepare($query);
        $authorIds = $_POST['author_ids'];
        foreach ($authorIds as $authorId) {
            $stmt->execute([
                ':book_id' => $book_id,
                ':author_id' => htmlspecialchars($authorId)
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