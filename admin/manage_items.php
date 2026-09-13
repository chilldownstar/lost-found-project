<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }
include '../config.php';
include '../includes/header.php';

// --- كود الحذف ---
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // حذف الصورة القديمة إذا وجدت
    $img_query = $conn->query("SELECT image FROM items WHERE id=$id");
    if ($row = $img_query->fetch_assoc()) {
        if ($row['image'] && file_exists("../uploads/".$row['image'])) {
            unlink("../uploads/".$row['image']);
        }
    }
    
    // حذف السجل من القاعدة
    $conn->query("DELETE FROM items WHERE id=$id");
    echo "<script>alert('تم الحذف بنجاح'); window.location.href='manage_items.php';</script>";
}

// جلب جميع العناصر
$result = $conn->query("SELECT * FROM items ORDER BY id DESC");
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
        <h3 class="fw-bold text-purple mb-0"><i class="fas fa-list"></i> إدارة العناصر</h3>
        <a href="dashboard.php" class="btn btn-secondary btn-sm rounded-pill">عودة للوحة التحكم</a>
    </div>

    <div class="card card-custom p-4 bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>الصورة</th>
                        <th>العنوان</th>
                        <th>النوع</th>
                        <th>الحالة</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td>
                                <?php if($row['image']): ?>
                                    <img src="../uploads/<?php echo $row['image']; ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                <?php else: ?>
                                    <span class="text-muted small">بدون</span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-bold"><?php echo htmlspecialchars($row['title']); ?></td>
                            <td>
                                <span class="badge <?php echo ($row['type']=='lost')?'bg-warning':'bg-success'; ?>">
                                    <?php echo ($row['type']=='lost')?'مفقود':'معثور عليه'; ?>
                                </span>
                            </td>
                            <td>
                                <?php 
                                    $status_color = 'secondary';
                                    if($row['status'] == 'approved') $status_color = 'primary';
                                    if($row['status'] == 'claimed') $status_color = 'dark';
                                ?>
                                <span class="badge bg-<?php echo $status_color; ?>">
                                    <?php 
                                    if($row['status']=='pending') echo 'قيد المراجعة';
                                    if($row['status']=='approved') echo 'مقبول';
                                    if($row['status']=='claimed') echo 'تم الاستلام';
                                    ?>
                                </span>
                            </td>
                            <td>
                                <a href="edit_item.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i> تعديل</a>
                                <a href="manage_items.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من الحذف؟');"><i class="fas fa-trash"></i> حذف</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted">لا توجد عناصر مضافة</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>