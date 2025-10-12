<?php
include 'db.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Library Management</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <h1>Welcome to Library Management System</h1>

    <nav>
        <h3>📚</h3>
        <a href="admin/admin_login.php"><i class="fas fa-user-shield"></i> Admin Login</a>
        <a href="student/student_login.php"><i class="fas fa-user-graduate"></i> Student Login</a>
        <a href="student/student_register.php"><i class="fas fa-user-plus"></i> Registration</a>
    </nav>

    <section class="dashboard">
        <div class="card">
            <i class="fas fa-user-graduate"></i>
            <h3>Total Students</h3>
            <p><?php
            
            // 2. Correct the SQL query to count students (assuming the table is named 'students')
            $sql = "SELECT COUNT(id) AS total_students FROM students";
            $result = $conn->query($sql);

            // Fetch and display the result
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo $row['total_students'];
            } else {
                echo "0";
            }
            ?></p>
        </div>
        <div class="card">
            <i class="fas fa-book"></i>
            <h3>Total Books</h3>
            <p>2500</p>
        </div>
        <div class="card">
            <i class="fas fa-book-reader"></i>
            <h3>Books Issued</h3>
            <p>560</p>
        </div>
        <div class="card">
            <i class="fas fa-check-circle"></i>
            <h3>Books Available</h3>
            <p>1940</p>
        </div>
        <div class="card">
            <i class="fas fa-users"></i>
            <h3>Staff Members</h3>
            <p>15</p>
        </div>
        <div class="card">
            <i class="fas fa-calendar-alt"></i>
            <h3>Active Transactions</h3>
            <p>40</p>
        </div>
    </section>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Library Management</h3>
                <p>Making knowledge accessible for everyone 📚</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="admin/admin_login.php">Admin Login</a></li>
                    <li><a href="student/student_login.php">Student Login</a></li>
                    <li><a href="student/student_register.php">Registration</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact</h4>
                <p><i class="fas fa-map-marker-alt"></i> Pune, India</p>
                <p><i class="fas fa-envelope"></i> support@library.com</p>
                <p><i class="fas fa-phone"></i> +91 98765 43210</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Library Management | All Rights Reserved</p>
        </div>
    </footer>
</body>

</html>
<?php
// Close the connection at the end of the script
$conn->close();
?>