<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $weight = (float)$_POST['weight'];
    $height = (float)$_POST['height'];

    $bmi = $weight / ($height * $height);
    $status = '';

    if ($bmi < 18.5) $status = 'نحافة';
    elseif ($bmi < 25) $status = 'طبيعي';
    elseif ($bmi < 30) $status = 'زيادة وزن';
    else $status = 'سمنة';

    $stmt = $db->prepare("INSERT INTO bmi_records (user_id, name, weight, height, bmi, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $name, $weight, $height, $bmi, $status]);

    $resultText = "مؤشر كتلة الجسم: " . number_format($bmi, 2) . " - الحالة: $status";
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>حاسبة BMI</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>حاسبة BMI</h1>
    <form method="POST">
        <label>الاسم:</label>
        <input type="text" name="name" required>
        <label>الوزن (كغ):</label>
        <input type="number" name="weight" step="0.1" required>
        <label>الطول (م):</label>
        <input type="number" name="height" step="0.01" required>
        <input type="submit" value="احسب">
    </form>
    <?php if (!empty($resultText)) echo "<p><strong>$resultText</strong></p>"; ?>
    <p><a href="logout.php">تسجيل الخروج</a></p>
</div>
</body>
</html>