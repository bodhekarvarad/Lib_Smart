<?php
session_start();

// 1. CORRECT INCLUDE PATH: Go up one level (from 'books' to project root) to find 'db.php'
include '../db.php'; 

// Check if the student session is NOT set.
if (!isset($_SESSION['student'])) {
    // 2. CORRECT REDIRECT PATH: Go up one level (to root), then into 'student', then find 'student_login.php'
    header("Location: ../student/student_login.php");
    exit();
}

$student_name = $conn->real_escape_string($_SESSION['student_name']);
?>
<!DOCTYPE html>
<html>

<head>
    <title>My Issued Books</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <h2>Books Issued to <?php echo htmlspecialchars($_SESSION['student_name']); ?></h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Book Title</th>
            <th>Issue Date</th>
        </tr>
        <?php
// Query to fetch books issued to the current student
$sql = "SELECT issued_books.id, books.title, issued_books.issue_date
        FROM issued_books
        JOIN books ON issued_books.book_id = books.id
        WHERE issued_books.student_name = '$student_name'"; // Use the escaped variable
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['title']}</td>
            <td>{$row['issue_date']}</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='3'>You have no books currently issued.</td></tr>";
}
?>
    </table>
    <p><a href="../student/student_home.php">Back to Student Dashboard</a></p>
</body>

</html>
<?php
// Close the database connection
$conn->close();
?>