<?php
session_start();
// CORRECT PATH: Go up one level (from 'student' folder to project root) to find 'db.php'
include '../db.php';

if (isset($_POST['login'])) {
    
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Original, unsecure query (only folder path is requested to be fixed)
    $sql = "SELECT * FROM students WHERE email='$email'"; 
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['student'] = $row['id'];
            $_SESSION['student_name'] = $row['name'];
            
            // CORRECT REDIRECT PATH: student_home.php is in the SAME folder (student/)
            header("Location: student_home.php");
            exit();
        } else {
            $error = "Invalid Password!";
        }
    } else {
        $error = "No account found with this email!";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Student Login</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <h2>Student Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
</body>

</html>
<?php
// Close the database connection
if (isset($conn)) $conn->close();
?>