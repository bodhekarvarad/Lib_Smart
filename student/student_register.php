<?php
session_start();
// CORRECT PATH: Go up one level (from 'student' folder to project root) to find 'db.php'
include '../db.php';

$error_message = '';

if (isset($_POST['register'])) {
    // Sanitize and validate input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // --- SECURITY: Use Prepared Statements to prevent SQL Injection ---
    $sql = "INSERT INTO students (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sss", $name, $email, $hashed_password);
        
        if ($stmt->execute()) {
            // CORRECT PATH: student_login.php is in the SAME folder (student/)
            echo '<p>Registration successful! <a href="student_login.php" style="color: #fff; text-decoration: underline;">Login here</a></p>';
        } else {
            // Check for duplicate entry error (e.g., duplicate email)
            if ($conn->errno == 1062) {
                $error_message = "Error: An account with this email already exists.";
            } else {
                $error_message = "Error: " . $conn->error;
            }
        }
        $stmt->close();
    } else {
        $error_message = "Database statement preparation failed.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Student Registration</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <h2>Student Registration</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="register">Register</button>
    </form>
    <?php 
// Display error message if registration failed
if ($error_message) {
    echo "<p style='color:red'>{$error_message}</p>"; 
} 
?>
</body>

</html>
<?php
// Close the database connection
if (isset($conn)) $conn->close();
?>