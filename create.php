<?php
session_start();
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['title'], $_POST['author_id'], $_POST['ISBN'], $_POST['genre'], $_POST['publication_year'])) {
        $title = $_POST['title'];
        $author_id = $_POST['author_id'];
        $ISBN = $_POST['ISBN'];
        $genre = $_POST['genre'];
        $publication_year = $_POST['publication_year'];

        // Insert book into database
        $query = "INSERT INTO books (title, author_id, ISBN, genre, publication_year) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sissi", $title, $author_id, $ISBN, $genre, $publication_year);

        if ($stmt->execute()) {
            // Book added successfully
            header("Location: read.php"); // Redirect to books listing page
            exit();
        } else {
            // Error adding book
            echo "Error: " . $conn->error;
        }
    } else {
        // Missing required fields
        echo "All fields are required.";
    }
}
?>
