<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }
include '../config.php';
include '../includes/header.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$item = $conn->query("SELECT * FROM items WHERE id=$id")->fetch_assoc();

if (!$item) {
    echo "<div class='container mt-5 alert alert-danger'>عنصر غير موجود!</div>";
    exit;
}

if (isset($_POST['update'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $desc = $conn->real_escape_string($_POST['description']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $status = $_POST['status'];
    
    $conn->query("UPDATE items SET title='$title', description='$desc', contact_info='$contact', status='$status' WHERE id=$id");
    echo "<script>alert('تم التحديث بنجاح'); window.location.href='manage_items.php';</script>";
}
?>

<div class="container mt-4">
    <div class="card card-custom p-4 mx-auto" style="max-width: 600px;">
        <h4 class="mb-4 text-purple fw-bold border-bottom pb-2">تعديل العنصر: <?php echo htmlspecialchars($item['title']); ?></h4>
        
        <form method="POST">
            <div class="mb-3">
                <label class="fw-bold">العنوان</label>
                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($item['title']); ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="fw-bold">الحالة (Status)</label>
                <select name="status" class="form-select">
                    <option value="pending" <?php if($item['status']=='pending') echo 'selected'; ?>>قيد المراجعة (مخفي)</option>
                    <option value="approved" <?php if($item['status']=='approved') echo 'selected'; ?>>مقبول (ظاهر بالموقع)</option>
                    <option value="claimed" <?php if($item['status']=='claimed') echo 'selected'; ?>>تم التسليم/الاستلام (أرشيف)</option>
                </select>
                <div class="form-text text-muted">اختر "مقبول" ليظهر في الصفحة الرئيسية، أو "تم التسليم" لإخفائه كأرشيف.</div>
            </div>

            <div class="mb-3">
                <label class="fw-bold">معلومات التواصل</label>
                <input type="text" name="contact" class="form-control" value="<?php echo htmlspecialchars($item['contact_info']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="fw-bold">الوصف</label>
                <textarea name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($item['description']); ?></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" name="update" class="btn btn-purple w-100 fw-bold">حفظ التعديلات</button>
                <a href="manage_items.php" class="btn btn-secondary w-100">إلغاء</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>