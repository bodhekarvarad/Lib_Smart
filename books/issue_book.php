<?php
session_start();
// 1. CORRECT PATH for include db.php: Go up one level (from 'books' to project root)
include '../db.php';

// Check if the admin session is NOT set.
if (!isset($_SESSION['admin'])) {
    // 2. CORRECT REDIRECT PATH: Go up one level (to root), then into 'admin', then find 'admin_login.php'
    header("Location: ../admin/admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Issue Book</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <h2>Issue Book</h2>
    <form method="POST">
        <input type="text" name="student_name" placeholder="Student Name" required>
        <select name="book_id" required>
            <option value="">Select Book</option>
            <?php
        // Query to get available books
        $books = $conn->query("SELECT id, title, quantity FROM books WHERE quantity > 0");
        if ($books) {
            while($b = $books->fetch_assoc()){
                echo "<option value='{$b['id']}'>{$b['title']} ({$b['quantity']} left)</option>";
            }
        }
        ?>
        </select>
        <button type="submit" name="issue">Issue Book</button>
    </form>
    <?php
if(isset($_POST['issue'])){
    // It's highly recommended to use prepared statements here for security.
    $student = $conn->real_escape_string($_POST['student_name']);
    $book_id = $conn->real_escape_string($_POST['book_id']);
    $date = date("Y-m-d");

    // Start a transaction for data integrity
    $conn->begin_transaction();
    $success = true;

    // 1. Insert into issued_books table
    $sql_insert = "INSERT INTO issued_books (book_id, student_name, issue_date) 
                   VALUES ('$book_id', '$student', '$date')";
    if (!$conn->query($sql_insert)) {
        $success = false;
    }

    // 2. Decrement quantity in books table
    $sql_update = "UPDATE books SET quantity = quantity - 1 WHERE id='$book_id' AND quantity > 0";
    if (!$conn->query($sql_update) || $conn->affected_rows === 0) {
        $success = false;
    }

    if ($success) {
        $conn->commit();
        echo "<p>Book Issued Successfully! (Quantity updated)</p>";
    } else {
        $conn->rollback();
        echo "<p style='color:red'>Error issuing book. Please check if the book is available. Error: " . $conn->error . "</p>";
    }
}
?>
</body>

</html>
<?php
// Close the database connection at the end of the script
$conn->close();
?>