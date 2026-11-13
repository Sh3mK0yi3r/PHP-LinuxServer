<?php
require 'db.php';
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, course, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $course, $password);
    if ($stmt->execute()) {
        $msg = "User '$username' registered successfully! <a href='login.php'>Login here</a>";
    } else {
        $msg = "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>CAT2 Signup</title></head>
<body style="font-family: Arial; max-width: 400px; margin: 40px auto;">
    <h2>Student Registration</h2>
    <p style="color: green;"><?= $msg ?></p>
    <form method="POST">
        <input type="text" name="username" placeholder="Username (e.g. studentCNSA)" required style="width:100%; margin-bottom:10px; padding:8px;"><br>
        <input type="email" name="email" placeholder="Email Address" required style="width:100%; margin-bottom:10px; padding:8px;"><br>
        <input type="text" name="course" placeholder="Course (e.g. BBIT / CNS)" required style="width:100%; margin-bottom:10px; padding:8px;"><br>
        <input type="password" name="password" placeholder="Password" required style="width:100%; margin-bottom:10px; padding:8px;"><br>
        <button type="submit" style="padding:10px 20px;">Sign Up</button>
    </form>
</body>
</html>