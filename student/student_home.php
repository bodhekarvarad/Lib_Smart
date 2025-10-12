<?php
session_start();
// 1. INCLUDE DB.PHP: Go up one level (from 'student' folder to project root) to find 'db.php'
include '../db.php'; 

if (!isset($_SESSION['student'])) {
    // 2. CORRECT REDIRECT PATH: student_login.php is in the SAME folder (student/)
    header("Location: student_login.php");
    exit();
}
// Ensure student_name is safe for display
$student_name = isset($_SESSION['student_name']) ? htmlspecialchars($_SESSION['student_name']) : 'Student';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <h1>Welcome, <?php echo $student_name; ?>!</h1>
    <nav>
        <a href="../books/view_books.php">&#128218; View Available Books</a>

        <a href="../books/view_my_issued.php">&#128214; My Issued Books</a>

        <a href="student_issue_book.php">&#128214; Request Book</a>

        <a href="../logout.php">&#128282; Logout</a>
    </nav>

</body>

</html>
<?php
// Close the database connection
$conn->close();
?>