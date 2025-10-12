<?php
session_start();
// 1. CORRECT INCLUDE PATH: Go up one level (from 'student' folder to project root) to find 'db.php'
include '../db.php'; 

if (!isset($_SESSION['student'])) {
    // 2. CORRECT REDIRECT PATH: student_login.php is in the SAME folder
    header("Location: student_login.php");
    exit();
}

// Ensure session variables are set and escape the student name for SQL
$student_name = isset($_SESSION['student_name']) ? $conn->real_escape_string($_SESSION['student_name']) : '';
$msg = '';

if (isset($_POST['issue'])) {
    // Sanitize input
    $book_id = intval($_POST['book_id']); // Ensure it's an integer

    // --- TRANSACTION START ---
    $conn->begin_transaction();
    $success = false;

    try {
        // 3. Check if book exists and is available (Using prepared statement for book_id)
        $stmt_check = $conn->prepare("SELECT quantity FROM books WHERE id = ? AND quantity > 0 FOR UPDATE");
        $stmt_check->bind_param("i", $book_id);
        $stmt_check->execute();
        $check_result = $stmt_check->get_result();

        if ($check_result->num_rows > 0) {
            // 4. Issue book (Using prepared statement for security)
            $stmt_insert = $conn->prepare("INSERT INTO issued_books (book_id, student_name, issue_date) VALUES (?, ?, NOW())");
            $stmt_insert->bind_param("is", $book_id, $student_name);
            
            if ($stmt_insert->execute()) {
                // 5. Reduce quantity (Using prepared statement)
                $stmt_update = $conn->prepare("UPDATE books SET quantity = quantity - 1 WHERE id = ?");
                $stmt_update->bind_param("i", $book_id);
                
                if ($stmt_update->execute()) {
                    $conn->commit();
                    $msg = "✅ Book issued successfully!";
                    $success = true;
                } else {
                    throw new Exception("Error reducing quantity: " . $conn->error);
                }
            } else {
                throw new Exception("Error issuing book: " . $conn->error);
            }
        } else {
            $msg = "❌ Book not available or invalid ID!";
        }
    } catch (Exception $e) {
        $conn->rollback();
        // Log the detailed error, but show a generic message to the user
        // error_log($e->getMessage()); 
        $msg = "❌ An error occurred during the transaction. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Issue Book</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <h2>Issue a Book</h2>
    <nav>
        <a href="student_home.php">&#127968; Student Home</a> |
        <a href="../books/view_books.php">&#128218; View Books</a> |
        <a href="../books/view_my_issued.php">&#128214; My Issued Books</a> |
        <a href="student_issue_book.php">&#128214; Issue Book</a> |
        <a href="../logout.php">&#128282; Logout</a>
    </nav>
    <hr>

    <form method="POST">
        <label for="book_id">Select Book:</label>
        <select name="book_id" required>
            <option value="">Select Book</option>
            <?php
        // Fetch books *again* (after potential update)
        // If $success is true, you might want to redirect to clear the form
        $books = $conn->query("SELECT id, title, author, quantity FROM books WHERE quantity > 0");
        while ($row = $books->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['title']} by {$row['author']} (Available: {$row['quantity']})</option>";
        }
        ?>
        </select>
        <button type="submit" name="issue">Issue Book</button>
    </form>

    <?php if (!empty($msg)) echo "<p>{$msg}</p>"; ?>
</body>

</html>
<?php
// Close the database connection
$conn->close();
?>