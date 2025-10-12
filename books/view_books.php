<?php
session_start();

// 1. ADD SECURITY CHECK: Redirect if admin session is not set
if (!isset($_SESSION['admin'])) {
    // CORRECT REDIRECT PATH: Go up one level (to root), then into 'admin', then find 'admin_login.php'
    header("Location: ../admin/admin_login.php");
    exit();
}

// 2. CORRECT INCLUDE PATH: Go up one level (from 'books' to project root) to find 'db.php'
include '../db.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>View Books</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <h2>Available Books</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Quantity</th>
        </tr>
        <?php
// Retrieve all books from the database
$result = $conn->query("SELECT id, title, author, quantity FROM books");

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['title']}</td>
            <td>{$row['author']}</td>
            <td>{$row['quantity']}</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No books found.</td></tr>";
}
?>
    </table>
    <p><a href="../admin/admin_home.php">Back to Dashboard</a></p>
</body>

</html>
<?php
// Close the database connection
$conn->close();
?>