<?php
include 'connection.php';

// Check if 'book_id' is set in $_POST, otherwise fallback or handle gracefully
$id = isset($_POST['book_id']) ? $_POST['book_id'] : null;

if ($id === null) {
    echo "Error: Book ID not provided.";
    exit;
}

// Use prepared statement to avoid SQL injection
$sql = "SELECT * FROM books WHERE book_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $title = $row['title'];
    $author_id = $row['author_id'];
    $ISBN = $row['ISBN'];
    $genre = $row['genre'];
    $publication_year = $row['publication_year'];
} else {
    echo "Error: No book found with ID $id.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author_id = $_POST['author_id'];
    $ISBN = $_POST['ISBN'];
    $genre = $_POST['genre'];
    $publication_year = $_POST['publication_year'];

    // Update query using prepared statement
    $sql = "UPDATE books SET title=?, author_id=?, ISBN=?, genre=?, publication_year=? WHERE book_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $title, $author_id, $ISBN, $genre, $publication_year, $id);

    if ($stmt->execute()) {
        echo "Book updated successfully.";
        header("Location: Read.php");
        exit;
    } else {
        echo "Error updating book: " . $conn->error;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <style>
        /* Your styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 1rem;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
        }
        input[type="text"] {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Book</h2>
        <form action="edit.php" method="post">
            <input type="hidden" name="book_id" value="<?php echo isset($id) ? $id : ''; ?>">
            
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo isset($title) ? $title : ''; ?>" required>
            
            <label for="author_id">Author ID:</label>
            <input type="text" id="author_id" name="author_id" value="<?php echo isset($author_id) ? $author_id : ''; ?>" required>
            
            <label for="ISBN">ISBN:</label>
            <input type="text" id="ISBN" name="ISBN" value="<?php echo isset($ISBN) ? $ISBN : ''; ?>">
            
            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre" value="<?php echo isset($genre) ? $genre : ''; ?>">
            
            <label for="publication_year">Publication Year:</label>
            <input type="text" id="publication_year" name="publication_year" value="<?php echo isset($publication_year) ? $publication_year : ''; ?>">
            
            <input type="submit" value="Update Book">
        </form>
    </div>
</body>
</html>
