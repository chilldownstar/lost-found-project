<?php
session_start();
// حماية الصفحة: إذا لم يسجل الدخول، ارجعه لصفحة الدخول
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

include '../config.php';
include '../includes/header.php';

// جلب الإحصائيات الحقيقية من قاعدة البيانات
$total_items = $conn->query("SELECT COUNT(*) FROM items")->fetch_row()[0];
$lost_items = $conn->query("SELECT COUNT(*) FROM items WHERE type='lost'")->fetch_row()[0];
$found_items = $conn->query("SELECT COUNT(*) FROM items WHERE type='found'")->fetch_row()[0];
$claimed_items = $conn->query("SELECT COUNT(*) FROM items WHERE status='claimed'")->fetch_row()[0];
?>

<div class="container mt-4">
    
    <div class="text-white p-5 rounded-3 mb-4 text-center shadow" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <h1 class="fw-bold"><i class="fas fa-cog fa-spin me-2"></i> لوحة تحكم المسؤول</h1>
        <p class="mb-4 opacity-75">إدارة جميع العناصر المفقودة والموجودة</p>
        
        <div class="d-flex justify-content-center gap-2">
            <a href="logout.php" class="btn btn-outline-light rounded-pill px-4">
                <i class="fas fa-sign-out-alt ms-2"></i> تسجيل الخروج
            </a>
            <a href="../index.php" class="btn btn-outline-light rounded-pill px-4">
                <i class="fas fa-home ms-2"></i> الموقع
            </a>
        </div>
    </div>

    <div class="card card-custom p-4 mb-4 bg-white">
        <h5 class="mb-4 fw-bold text-end text-secondary">
            <i class="fas fa-chart-bar text-purple ms-2"></i> نظرة عامة على الإحصائيات
        </h5>
        <div class="row g-3 text-center text-white">
            <div class="col-md-3">
                <div class="p-4 rounded-3 shadow-sm bg-secondary h-100 d-flex flex-column justify-content-center">
                    <h1 class="fw-bold mb-0 display-4"><?php echo $claimed_items; ?></h1>
                    <span class="fs-6 opacity-75">عناصر تم استلامها</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 rounded-3 shadow-sm bg-success h-100 d-flex flex-column justify-content-center">
                    <h1 class="fw-bold mb-0 display-4"><?php echo $found_items; ?></h1>
                    <span class="fs-6 opacity-75">عناصر تم العثور عليها</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 rounded-3 shadow-sm bg-warning h-100 d-flex flex-column justify-content-center">
                    <h1 class="fw-bold mb-0 display-4"><?php echo $lost_items; ?></h1>
                    <span class="fs-6 opacity-75">عناصر مفقودة</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 rounded-3 shadow-sm bg-purple-gradient h-100 d-flex flex-column justify-content-center">
                    <h1 class="fw-bold mb-0 display-4"><?php echo $total_items; ?></h1>
                    <span class="fs-6 opacity-75">إجمالي العناصر</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom p-4 mb-4 bg-white">
        <h5 class="mb-4 fw-bold text-end text-secondary">
            <i class="fas fa-wrench text-secondary ms-2"></i> إجراءات سريعة
        </h5>
        <div class="row g-3">
            <div class="col-md-4">
                <a href="logout.php" class="btn btn-danger w-100 py-3 shadow-sm">
                    <i class="fas fa-sign-out-alt ms-2"></i> تسجيل الخروج
                </a>
            </div>
            <div class="col-md-4">
                <a href="../index.php" class="btn btn-secondary w-100 py-3 shadow-sm">
                    <i class="fas fa-file-alt ms-2"></i> عرض الموقع العام
                </a>
            </div>
            <div class="col-md-4">
                <a href="add_item.php" class="btn btn-purple w-100 py-3 shadow-sm">
                    <i class="fas fa-plus-circle ms-2"></i> إضافة عنصر جديد
                </a>
            </div>
            <div class="col-md-3">
    <a href="manage_items.php" class="btn btn-primary w-100 py-3 shadow-sm">
        <i class="fas fa-list ms-2"></i> إدارة العناصر
    </a>
</div>
        </div>
    </div>

    <div class="card card-custom p-4 mb-4 bg-white">
        <h5 class="mb-4 fw-bold text-end text-secondary">
            <i class="fas fa-server text-secondary ms-2"></i> معلومات النظام
        </h5>
        <div class="row text-center bg-light p-3 rounded-3 g-3">
            <div class="col-md-3 border-start">
                <small class="text-muted d-block mb-1"><i class="fas fa-user ms-1"></i> مسجل الدخول كـ</small>
                <div class="fw-bold text-purple">admin</div>
            </div>
            <div class="col-md-3 border-start">
                <small class="text-muted d-block mb-1"><i class="fas fa-calendar-alt ms-1"></i> آخر تسجيل دخول</small>
                <div class="fw-bold text-dark" dir="ltr"><?php echo date("M d, Y h:i A"); ?></div>
            </div>
            <div class="col-md-3 border-start">
                <small class="text-muted d-block mb-1"><i class="fas fa-database ms-1"></i> قاعدة البيانات</small>
                <div class="fw-bold text-dark">MySQL متصل</div>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block mb-1"><i class="fas fa-folder ms-1"></i> المرفوعات</small>
                <div class="fw-bold text-dark">جاهز</div>
            </div>
        </div>
    </div>

</div>

<?php include '../includes/footer.php'; ?>