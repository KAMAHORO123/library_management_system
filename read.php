<?php
session_start();
require_once 'connection.php';

// Fetch all books from the database
$query = "SELECT * FROM books";
$result = $conn->query($query);

// Handle search query
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // Modify query to search by title or author_id (example)
    $query = "SELECT * FROM books WHERE title LIKE '%$search%' OR author_id LIKE '%$search%'";
    $result = $conn->query($query);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Books</title>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            background-color: #fff;
            padding: 1rem 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
            color: #333;
        }

        nav {
            background-color: #eee;
            padding: 1rem 0;
            text-align: center;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        nav li {
            display: inline-block;
            margin: 0 1rem;
        }

        nav a {
            text-decoration: none;
            color: #333;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #ddd;
        }

        .container {
            max-width: 960px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #333;
            text-align: center;
        }

        form {
            margin-bottom: 2rem;
            text-align: center;
        }

        label {
            display: block;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        input[type="text"] {
            width: 300px;
            padding: 0.5rem;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 1rem;
        }

        button {
            padding: 0.5rem 1rem;
            font-size: 1rem;
            background-color: #23BDEE;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0e6782;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
            overflow-x: auto;
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        td a {
            text-decoration: none;
            color: #007bff;
            margin-right: 1rem;
            transition: color 0.3s ease;
        }

        td a:hover {
            color: #0056b3;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            input[type="text"] {
                width: 100%;
                margin-bottom: 1rem;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>Online Library Management System</h1>
    </header>
    <nav>
        <ul>
            <li><a href="dashboard.html">Dashboard</a></li>
            <li><a href="#">Categories</a></li>
            <li><a href="#">Authors</a></li>
            <li><a href="read.php">Books</a></li>
            <li><a href="#">Issue Books</a></li>
            <li><a href="#">Reg Students</a></li>
            <li><a class="logout-button" href="create.html">Add a Book</a></li>
            <li><a href="./login.html" class="logout-button">Log me out</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Admin Dashboard - Books</h2>

        <!-- Search form -->
        <form action="read.php" method="GET">
            <label for="search">Search by Title or Author ID:</label>
            <input type="text" id="search" name="search" placeholder="Enter keywords">
            <button type="submit">Search</button>
        </form>

        <!-- Display books -->
        <table border="1">
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Title</th>
                    <th>Author ID</th>
                    <th>ISBN</th>
                    <th>Genre</th>
                    <th>Publication Year</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['book_id'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['author_id'] . "</td>";
                    echo "<td>" . $row['ISBN'] . "</td>";
                    echo "<td>" . $row['genre'] . "</td>";
                    echo "<td>" . $row['publication_year'] . "</td>";
                    echo "<td>
                            <a href='edit.php ?book_id=" . $row['book_id'] . "'>Edit</a> | 
                            <a href='delete.php ?book_id=" . $row['book_id'] . "'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
$result->free_result();
$conn->close();
?>