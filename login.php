<?php
session_start();
require 'db.php';
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, course FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['course'] = $row['course'];
            header("Location: feedback.php");
            exit();
        }
    }
    $error = "Invalid username or password.";
}
?>
<!DOCTYPE html>
<html>
<head><title>CAT2 Login</title></head>
<body style="font-family: Arial; max-width: 400px; margin: 40px auto;">
    <h2>Student Login</h2>
    <p style="color: red;"><?= $error ?></p>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required style="width:100%; margin-bottom:10px; padding:8px;"><br>
        <input type="password" name="password" placeholder="Password" required style="width:100%; margin-bottom:10px; padding:8px;"><br>
        <button type="submit" style="padding:10px 20px;">Login</button>
    </form>
    <p>Need an account? <a href="signup.php">Sign up</a></p>
</body>
</html>