<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }

include '../config.php';
include '../includes/header.php';

$message = "";

// عند ضغط زر الحفظ
if (isset($_POST['submit_item'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $type = $conn->real_escape_string($_POST['type']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $desc = $conn->real_escape_string($_POST['description']);
    
    // معالجة رفع الصورة
    $image = "";
    if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        $target_dir = "../uploads/";
        $image = time() . "_" . basename($_FILES["image"]["name"]); // تغيير الاسم لمنع التكرار
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
    }

    $sql = "INSERT INTO items (title, description, type, contact_info, image, status) 
            VALUES ('$title', '$desc', '$type', '$contact', '$image', 'approved')"; // نجعلها approved مباشرة لأن الأدمن هو من يضيفها

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('تمت إضافة العنصر بنجاح!'); window.location.href='dashboard.php';</script>";
    } else {
        $message = "<div class='alert alert-danger'>حدث خطأ: " . $conn->error . "</div>";
    }
}
?>

<div class="container mt-4">
    <?php echo $message; ?>
    
    <div class="text-white p-5 rounded-3 mb-4 text-center shadow" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <h1 class="fw-bold">إضافة عنصر جديد</h1>
    </div>

    <div class="card card-custom p-4 bg-white">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>عنوان العنصر</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>النوع</label>
                    <select name="type" class="form-select">
                        <option value="lost">مفقود</option>
                        <option value="found">معثور عليه</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>معلومات التواصل</label>
                    <input type="text" name="contact" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label>الوصف</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label>الصورة</label>
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit" name="submit_item" class="btn btn-purple w-100 fw-bold">حفظ العنصر</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>