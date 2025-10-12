<?php
session_start();
// 1. CORRECT REDIRECT PATH: Go up one level (to root), then into 'admin', then find 'admin_login.php'
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/admin_login.php");
    exit();
}
// 2. CORRECT INCLUDE PATH: Go up one level (from 'books' to project root) to find 'db.php'
include '../db.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Issued Books</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <h2>Issued Books</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Book</th>
            <th>Student</th>
            <th>Date</th>
        </tr>
        <?php
$sql = "SELECT issued_books.id, books.title, issued_books.student_name, issued_books.issue_date 
        FROM issued_books 
        JOIN books ON issued_books.book_id = books.id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['title']}</td>
            <td>{$row['student_name']}</td>
            <td>{$row['issue_date']}</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No books currently issued.</td></tr>";
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