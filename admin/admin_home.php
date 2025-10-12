<?php
session_start();

include '../db.php'; 

if (!isset($_SESSION['admin'])) {
   header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <h1>Welcome, Admin!</h1>
    <nav>
        <a href="../books/add_book.php">&#10133; Add Book</a>

        <a href="../books/view_books.php">&#128214; View Books</a>

        <a href="../student/view_students.php">&#61461; View Students</a>

        <a href="../logout.php">&#128282; Logout</a>
    </nav>

</body>

</html>
<?php

$conn->close();
?>