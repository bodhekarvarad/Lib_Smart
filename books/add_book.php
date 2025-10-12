<?php
session_start();

include '../db.php'; 


if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Book</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <h2>Add New Book</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Book Title" required>
        <input type="text" name="author" placeholder="Author" required>
        <input type="number" name="quantity" placeholder="Quantity" required>
        <button type="submit" name="submit">Add Book</button>
    </form>
    <?php
if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $quantity = $_POST['quantity'];


    $sql = "INSERT INTO books (title, author, quantity) VALUES ('$title','$author','$quantity')";
    if($conn->query($sql)){
        echo "<p>Book Added Successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>
</body>

</html>
<?php

$conn->close();
?>