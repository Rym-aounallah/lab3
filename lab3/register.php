<?php
require 'config/database.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل جديد</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>تسجيل جديد</h1>
    <form method="POST">
        <label>اسم المستخدم:</label>
        <input type="text" name="username" required>
        <label>كلمة المرور:</label>
        <input type="password" name="password" required>
        <input type="submit" value="تسجيل">
    </form>
    <p>عندك حساب؟ <a href="index.php">تسجيل الدخول</a></p>
</div>
</body>
</html>