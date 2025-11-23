<?php require_once __DIR__ . '/main.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<div class="container-fluid p-4">

    <!-- Hero Banner -->
    <div class="hero-banner mb-5">
        <div class="text-center text-white">
            <h1>Chào mừng đến với hệ thống quản lý tour</h1>
            <p class="lead">Nền tảng giúp quản lý tour du lịch dễ dàng, nhanh chóng và hiệu quả</p>
            <a href="#" class="btn btn-primary btn-lg mt-3">Bắt đầu ngay</a>
        </div>
    </div>

    <!-- Sales Chart -->
    <div class="row justify-content-center my-5">
        <div class="col-12 col-md-10">
            <div class="card card-chart p-4 shadow-sm rounded-4">
                <h5 class="fw-bold mb-4">Số lượng tour theo tháng</h5>
                <canvas id="salesChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="section-title">Các chức năng chính</h2>
            <p class="section-subtitle text-muted">Khám phá các tính năng hỗ trợ quản lý tour</p>
        </div>

        <div class="row g-4 justify-content-center">

            <!-- Feature 1: Quản lý tour -->
            <div class="col-md-4 col-sm-6">
                <div class="card card-feature shadow-sm text-center p-4 h-100 rounded-4">
                    <div class="icon-circle bg-primary mb-3">
                        <i class="bi bi-globe-americas fs-2 text-white"></i>
                    </div>
                    <h5 class="fw-bold mt-2">Quản lý tour</h5>
                    <p class="text-muted">Danh mục và thông tin chi tiết</p>
                    <a href="#" class="btn btn-outline-primary mt-3">Xem thêm</a>
                </div>
            </div>

            <!-- Feature 2: Quản lý nhân sự -->
            <div class="col-md-4 col-sm-6">
                <div class="card card-feature shadow-sm text-center p-4 h-100 rounded-4">
                    <div class="icon-circle bg-success mb-3">
                        <i class="bi bi-people fs-2 text-white"></i>
                    </div>
                    <h5 class="fw-bold mt-2">Quản lý nhân sự</h5>
                    <p class="text-muted">Lịch làm việc và thông tin khách hàng</p>
                    <a href="#" class="btn btn-outline-success mt-3">Xem thêm</a>
                </div>
            </div>

            <!-- Feature 3: Báo cáo vận hành -->
            <div class="col-md-4 col-sm-6">
                <div class="card card-feature shadow-sm text-center p-4 h-100 rounded-4">
                    <div class="icon-circle bg-warning mb-3">
                        <i class="bi bi-bar-chart fs-2 text-white"></i>
                    </div>
                    <h5 class="fw-bold mt-2">Báo cáo vận hành</h5>
                    <p class="text-muted">Doanh thu, chi phí và lợi nhuận</p>
                    <a href="#" class="btn btn-outline-warning mt-3">Xem thêm</a>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Footer -->
<footer class="footer mt-5 py-3 bg-dark text-white text-center shadow-sm">
    <div class="container">
        <span><i class="bi bi-heart-fill text-danger"></i> Dự án 1 - Nhóm 4 - WD20305 <i class="bi bi-heart-fill text-danger"></i></span>
    </div>
</footer>

<!-- CSS -->
<style>
    /* Hero Banner */
    .hero-banner {
        position: relative;
        height: 350px;
        border-radius: 1rem;
        overflow: hidden;
        background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)),
            url('https://vr360.com.vn/uploads/images/5-cach-quang-ba-du-lich.jpg');
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .hero-banner h1 {
        font-size: 2.5rem;
        font-weight: 900;
        text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.6);
    }

    .hero-banner p {
        font-size: 1.2rem;
        text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
    }

    /* Chart Card */
    .card-chart {
        border-radius: 1rem;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        padding: 2rem;
    }

    /* Features Cards */
    .card-feature {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-feature:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }

    /* Icon Circles */
    .icon-circle {
        width: 70px;
        height: 70px;
        margin: 0 auto 15px auto;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-feature:hover .icon-circle {
        transform: scale(1.15);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    /* Section Titles */
    .section-title {
        font-weight: 800;
        font-size: 28px;
    }

    .section-subtitle {
        font-size: 16px;
    }

    /* Colors */
    .bg-primary {
        background-color: #0d6efd !important;
    }

    .bg-success {
        background-color: #198754 !important;
    }

    .bg-warning {
        background-color: #ffc107 !important;
    }

    .footer {
        font-size: 0.9rem;
    }

    .footer i {
        margin: 0 5px;
    }
</style>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Số tour',
                data: [30, 45, 35, 20, 80, 40, 90],
                backgroundColor: 'rgba(54,162,235,0.2)',
                borderColor: 'rgba(54,162,235,1)',
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