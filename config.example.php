<?php
// انسخ هذا الملف باسم config.php وعدّل القيم حسب بيئتك
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lost_found_project";

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// دعم اللغة العربية
$conn->set_charset("utf8mb4");
?>
