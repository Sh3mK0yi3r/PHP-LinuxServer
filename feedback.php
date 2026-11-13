<?php
session_start();
require 'db.php';
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student = $_SESSION['username'];
    $topic = trim($_POST['topic']);
    $message = trim($_POST['message']);
    $stmt = $conn->prepare("INSERT INTO lab_feedback (student_username, topic, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $student, $topic, $message);
    $stmt->execute();
}
$records = $conn->query("SELECT * FROM lab_feedback ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head><title>Lab Feedback Portal</title></head>
<body style="font-family: Arial; max-width: 650px; margin: 40px auto;">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <h3>Submit Server Lab Feedback (POST to CAT2)</h3>
    <form method="POST">
        <input type="text" name="topic" placeholder="Lab Topic (e.g. LAMP Stack)" required style="width:100%; margin-bottom:10px; padding:8px;"><br>
        <textarea name="message" placeholder="Enter your feedback..." required style="width:100%; margin-bottom:10px; padding:8px;"></textarea><br>
        <button type="submit" style="padding:10px 20px;">Submit Feedback</button>
    </form>
    <hr>
    <h3>Retrieved Submissions from CAT2 Database</h3>
    <table border="1" cellpadding="8" style="width:100%; border-collapse: collapse;">
        <tr><th>ID</th><th>Student</th><th>Topic</th><th>Message</th><th>Timestamp</th></tr>
        <?php while($row = $records->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['student_username']) ?></td>
            <td><?= htmlspecialchars($row['topic']) ?></td>
            <td><?= htmlspecialchars($row['message']) ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>