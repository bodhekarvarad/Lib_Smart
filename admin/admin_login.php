<?php
session_start();

include '../db.php';

if (isset($_POST['login'])) {
    
    $username = $_POST['username'];
    $password = md5($_POST['password']); 

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username;

        header("Location: admin_home.php"); 
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <h2>Admin Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
</body>

</html>