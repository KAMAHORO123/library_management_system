<?php

include 'connection.php';

$id = $_GET['book_id'];

$sql = "DELETE FROM books WHERE book_id = $id";

if ($conn->query($sql) === TRUE) {
    echo " Book deleted successfully.";
    header("Location: read.php");
} else {
    echo "Error deleting !: " . $conn->error;
}


$conn->close();