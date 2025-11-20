<?php require_once __DIR__ . '/main.php'; ?>

<div class="container-fluid p-4">

    <!-- Hero Banner -->
    <div class="bg-dark text-white rounded-4 mb-5 text-center position-relative overflow-hidden"
        style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://vr360.com.vn/uploads/images/5-cach-quang-ba-du-lich.jpg'); background-size: cover; background-position: center; height: 350px;">
        <div class="d-flex flex-column justify-content-center align-items-center h-100">
            <h1 class="fw-bold">Chào mừng đến với website quản lý tour du lịch</h1>
            <p class="lead">Nền tảng hỗ trợ quản lý tour du lịch một cách hiệu quả</p>
            <a href="#" class="btn btn-primary btn-lg mt-3">Bắt đầu ngay</a>
        </div>
    </div>

    <!-- Sales Chart -->
    <div class="row g-4 my-5 justify-content-center">
        <div class="col-12 col-md-11">
            <div class="card shadow-sm p-4 h-100 rounded-4 overflow-hidden">
                <h5 class="card-title fw-bold mb-3">Số lượng tour theo tháng</h5>
                <canvas id="salesChart" height="200"></canvas>
            </div>
        </div>
    </div>

</div>

<!-- Features Section -->
<div class="container py-4"> <!--  thêm container + padding -->
    <div class="text-center mb-4">
        <h2 class="fw-bold">Các chức năng</h2>
        <p class="text-muted">Khám phá các chức năng chính</p>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm text-center p-4 h-100 rounded-4">
                <i class="bi bi-laptop fs-1 text-primary"></i>
                <h5 class="mt-3 fw-bold">Quản lý tour</h5>
                <p>Danh mục và thông tin chi tiết tour</p>
                <a href="#" class="btn btn-outline-primary">Xem thêm</a>
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm text-center p-4 h-100 rounded-4">
                <i class="bi bi-people fs-1 text-primary"></i>
                <h5 class="mt-3 fw-bold">Quản lý nhân sự</h5>
                <p>Theo dõi lịch làm việc và thông tin khách hàng</p>
                <a href="#" class="btn btn-outline-primary">Xem thêm</a>
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm text-center p-4 h-100 rounded-4">
                <i class="bi bi-gear fs-1 text-primary"></i>
                <h5 class="mt-3 fw-bold">Báo cáo vận hành tour</h5>
                <p>Doanh thu, chi phí và lợi nhuận theo tour</p>
                <a href="#" class="btn btn-outline-primary">Xem thêm</a>
            </div>
        </div>
    </div>
</div>


<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Số tour',
                data: [30, 45, 35, 20, 80, 40, 90],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>