<?php
include 'config.php';
include 'includes/header.php';

// جلب العناصر المقبولة فقط
$sql = "SELECT * FROM items WHERE status = 'approved' ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-purple-gradient mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">مفقودات الجامعة</a>
    <a href="admin/login.php" class="btn btn-outline-light btn-sm rounded-pill">دخول المسؤول</a>
  </div>
</nav>

<div class="container">
    <h3 class="mb-4 text-purple fw-bold border-bottom pb-2">آخر العناصر المضافة</h3>
    
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card card-custom h-100">
                        <?php if($row['image']): ?>
                            <img src="uploads/<?php echo $row['image']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-light text-center py-5 text-muted"><i class="fas fa-image fa-3x"></i></div>
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <span class="badge <?php echo ($row['type'] == 'lost') ? 'bg-warning' : 'bg-success'; ?> mb-2">
                                <?php echo ($row['type'] == 'lost') ? 'مفقود' : 'معثور عليه'; ?>
                            </span>
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text text-muted small"><?php echo htmlspecialchars($row['description']); ?></p>
                            <hr>
                            <p class="mb-0 small fw-bold text-purple"><i class="fas fa-phone me-1"></i> <?php echo htmlspecialchars($row['contact_info']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-search fa-4x text-muted mb-3"></i>
                <p class="text-muted">لا توجد عناصر مضافة حالياً.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>