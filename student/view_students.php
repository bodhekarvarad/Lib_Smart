<?php
session_start();
include '../db.php';

// Check admin login
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/admin_login.php");
    exit();
}

// Handle delete student request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM students WHERE id=$id");
    header("Location: view_students.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Registered Students</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <h1>Registered Students</h1>
    <nav>
        <a href="../admin/admin_home.php">🏠 Admin Home</a> |
        <a href="view_students.php">👨‍🎓 View Students</a> |
        <a href="../logout.php">🚪 Logout</a>
    </nav>
    <hr>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Issued Books (Date)</th>
            <th>Action</th>
        </tr>
        <?php
$sql = "SELECT * FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $student_name = $row['name'];

        // Fetch books issued by this student with issue date
        $books_sql = "SELECT books.title, issued_books.issue_date 
                      FROM issued_books 
                      JOIN books ON issued_books.book_id = books.id 
                      WHERE issued_books.student_name='$student_name'";
        $books_result = $conn->query($books_sql);

        $issued_books = [];
        while ($b = $books_result->fetch_assoc()) {
            $issued_books[] = $b['title'] . " (" . $b['issue_date'] . ")";
        }

        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>" . (!empty($issued_books) ? implode(", ", $issued_books) : "None") . "</td>
            <td><a href='view_students.php?delete={$row['id']}' onclick=\"return confirm('Are you sure?')\">❌ Delete</a></td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No students registered yet.</td></tr>";
}
?>
    </table>
</body>

</html>