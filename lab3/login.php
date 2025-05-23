<?php
session_start();
require 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
        exit;
    } else {
        $error = "اسم المستخدم أو كلمة المرور خاطئة!";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>تسجيل الدخول</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label>اسم المستخدم:</label>
        <input type="text" name="username" required>
        <label>كلمة المرور:</label>
        <input type="password" name="password" required>
        <input type="submit" value="دخول">
    </form>
    <p>ما عندكش حساب؟ <a href="register.php">سجل هنا</a></p>
</div>
</body>
</html>