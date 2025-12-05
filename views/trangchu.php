<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>TourTravel</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AOS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0A7AFF;
            --primary-dark: #005ad4;
            --accent: #ffb23f;
            --text: #1b2534;
            --muted: #6b7a90;
            --bg: #f4f9ff;
            --radius: 18px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            scroll-behavior: smooth;
            margin: 0;
        }

        /* Navbar */
        .navbar {
            background: #ffffff;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
            padding: 12px 0;
            position: relative;
            z-index: 10;
        }

        .navbar-brand {
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--primary);
        }

        .navbar-nav {
            align-items: center;
        }

        .nav-link {
            font-weight: 600;
            color: var(--text) !important;
            padding: 8px 16px;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .nav-link:hover {
            background: rgba(10, 122, 255, 0.1);
            color: var(--primary) !important;
        }

        /* Hero */
        .hero {
            position: relative;
            height: 550px;
            background: url('https://ik.imagekit.io/tvlk/image/imageResource/2023/06/08/1686193661791-d09fe628fd8f9b6c377a91b30628d0b2.png?tr=dpr-2,q-75') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            color: #fff;
            overflow: hidden;
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.25));
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 900;
            line-height: 1.2;
            opacity: 0;
            animation: fadeInDown 1s ease forwards;
        }

        .hero-sub {
            font-size: 20px;
            margin-top: 12px;
            opacity: 0;
            animation: fadeInUp 1s 0.5s ease forwards;
        }

        .search-box {
            background: #fff;
            padding: 25px;
            margin-top: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            opacity: 1;
            transform: translateY(0);
            animation: fadeInUp 1s 1s ease forwards;
        }

        .search-box .form-control,
        .search-box .form-select {
            height: 50px;
            border-radius: 12px;
            border: 1px solid #dce6f9;
            transition: all 0.3s;
        }

        .search-box .form-control:focus,
        .search-box .form-select:focus {
            box-shadow: 0 0 10px rgba(10, 122, 255, 0.2);
            border-color: var(--primary);
        }

        .search-box .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .search-box .btn-primary:hover {
            background: var(--primary-dark);
        }

        /* Section */
        section {
            padding: 70px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .section-head h3 {
            font-weight: 800;
            margin-bottom: 8px;
        }

        .section-head small {
            color: var(--muted);
        }

        /* Card hover */
        .card-tour,
        .blog-card {
            border-radius: var(--radius);
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.08);
            background: #fff;
        }

        .card-tour img,
        .blog-card img {
            height: 240px;
            object-fit: cover;
        }

        .card-tour:hover,
        .blog-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .price {
            font-size: 1.3rem;
            font-weight: 800;
            color: #e63946;
        }

        /* Destinations auto-slide */
        .favorite-destinations {
            width: 100%;
            overflow: hidden;
            margin-top: 25px;
        }

        .dest-marquee {
            display: flex;
            gap: 22px;
            animation: marquee 20s linear infinite;
        }

        .favorite-destinations:hover .dest-marquee {
            animation-play-state: paused;
        }

        .dest-marquee .card {
            width: 250px;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.15);
            transition: .35s;
        }

        .dest-marquee .card img {
            height: 170px;
            object-fit: cover;
            transition: .35s;
        }

        .dest-marquee .card:hover {
            transform: scale(1.08);
        }

        .dest-marquee .card:hover img {
            transform: scale(1.15);
        }

        @keyframes marquee {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        /* Countdown */
        .countdown {
            font-size: 36px;
            font-weight: 800;
            color: #e63946;
            animation: pulse 1.2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
                color: #ff4d4d;
            }

            100% {
                transform: scale(1);
            }
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #0A7AFF 0%, #005ad4 100%);
            padding: 65px 0 40px;
            color: #fff;
            border-radius: 40px 40px 0 0;
        }

        footer h5,
        footer h6 {
            font-weight: 700;
        }

        footer p,
        footer a {
            color: #e8f1ff;
            opacity: 0.9;
        }

        footer a:hover {
            opacity: 1;
            padding-left: 4px;
        }

        .footer-icons .btn {
            background: #fff;
            color: #0A7AFF;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .payment-logos img {
            height: 32px;
            margin-right: 10px;
            filter: brightness(0) invert(1);
            opacity: .85;
            transition: .3s;
        }

        .payment-logos img:hover {
            opacity: 1;
            transform: translateY(-3px);
        }

        /* Keyframes fade */
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 36px;
            }

            .hero-sub {
                font-size: 16px;
            }
        }
    </style>

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary fs-3" href="#">TourTravel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav gap-4">
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#">Tour</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#">Khuyến mãi</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#">Liên hệ</a></li>
                    <!-- Nút đăng nhập-->
                    <li class="nav-item"><a class="btn btn-primary btn-login" href="?act=admin">Đăng nhập</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <header class="hero">
        <div class="hero-content" data-aos="fade-up">
            <h1 class="hero-title">Ưu đãi cực lớn — Khám phá thế giới cùng TourTravel</h1>
            <p class="hero-sub">Tour nội địa và quốc tế - Combo siêu tiết kiệm - Hỗ trợ 24/12h</p>

            <div class="search-box" data-aos="fade-up" data-aos-delay="120">
                <form class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <input class="form-control" placeholder="Bạn muốn đi đâu?">
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option value="domestic">Tour trong nước</option>
                            <option value="international">Tour quốc tế</option>
                            <option value="combo">Combo tour</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-primary">Tìm tour <i class="bi bi-search ms-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </header>

    <!-- Tour trong nước -->
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h3>Tour trong nước</h3>
                <small class="muted">Các điểm đến hot và khởi hành hàng tuần</small>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="card card-tour">
                        <img src="https://bcp.cdnchinhphu.vn/thumb_w/777/334894974524682240/2025/6/23/phu-quoc-17506756503251936667562.jpg" class="card-img-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title">Phú Quốc - Resort (4N3Đ)</h5>
                            <p class="muted mb-2">Khởi hành từ Hồ Chí Minh</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="price">5.200.000 VNĐ</div>
                                <a class="btn btn-outline-primary btn-sm" href="#">Xem ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card card-tour">
                        <img src="https://hanoitourist.vn/sites/default/files/inline-images/cham-sa-pa-cham-nhung-tang-may-kham-pha-thien-duong-mua-dong-voi-hang-loat-uu-dai-khung-1-0910.jpg" class="card-img-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title">Sapa - Trekking (3N2Đ)</h5>
                            <p class="muted mb-2">Khởi hành từ Hà Nội</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="price">4.100.000 VNĐ</div>
                                <a class="btn btn-outline-primary btn-sm" href="#">Xem ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card card-tour">
                        <img src="https://media.vneconomy.vn/images/upload//2025/06/255409f6e2-4fe8-41f1-8a1b-c2c8d579b1c6.jpg?w=900" class="card-img-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title">Đà Nẵng - Hội An (3N2Đ)</h5>
                            <p class="muted mb-2">Khởi hành từ Hà Nội/Hồ Chí Minh</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="price">3.900.000 VNĐ</div>
                                <a class="btn btn-outline-primary btn-sm" href="#">Xem ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tour quốc tế -->
    <section class="section bg-light">
        <div class="container">
            <div class="section-head">
                <h3>Tour quốc tế</h3>
                <small class="muted">Hành trình nước ngoài chất lượng</small>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="card card-tour">
                        <img src="https://vietlandtravel.vn/upload/images/4-hoa-anh-dao-nhat-ban_1.jpg" class="card-img-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title">Nhật Bản - Tokyo và Kyoto (5N4Đ)</h5>
                            <p class="muted mb-2">Trải nghiệm văn hóa và ẩm thực</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="price">25.000.000 VNĐ</div>
                                <a class="btn btn-outline-primary btn-sm" href="#">Xem ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card card-tour">
                        <img src="https://vj-prod-website-cms.s3.ap-southeast-1.amazonaws.com/shutterstock1020921643huge-1661704936584.jpg" class="card-img-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title">Hàn Quốc - Seoul và Nami (4N3Đ)</h5>
                            <p class="muted mb-2">Mua sắm và trải nghiệm</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="price">18.000.000 VNĐ</div>
                                <a class="btn btn-outline-primary btn-sm" href="#">Xem ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card card-tour">
                        <img src="https://www.vietnambooking.com/wp-content/uploads/2022/11/di-du-lich-thai-lan-can-giay-to-gi-1.jpg" class="card-img-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title">Thái Lan - Bangkok và Pattaya (4N3Đ)</h5>
                            <p class="muted mb-2">Ẩm thực và giải trí</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="price">9.800.000 VNĐ</div>
                                <a class="btn btn-outline-primary btn-sm" href="#">Xem ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Flash Deal/Countdown -->
    <section class="section text-center">
        <div class="container">
            <div class="section-head justify-content-center">
                <h3>Ưu đãi giờ chót</h3>
            </div>
            <p class="muted">Nhanh tay đặt trước khi ưu đãi kết thúc</p>
            <div class="mt-3">
                <div id="countdownA" class="countdown" data-aos="zoom-in">--:--:--</div>
            </div>
            <div class="mt-4">
                <a class="btn btn-lg btn-danger" href="#">Đặt ngay và nhận ưu đãi</a>
            </div>
        </div>
    </section>

    <!-- Destinations -->
    <section class="section bg-white">
        <div class="container">
            <div class="section-head">
                <h3>Điểm đến yêu thích</h3>
                <small class="muted">Chọn điểm đến theo vùng miền</small>
            </div>

            <div class="row g-4">
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="80">
                    <div class="card blog-card text-center">
                        <img src="https://vnsharing.edu.vn/wp-content/uploads/2025/11/cot-co-lung-cu-HG.jpg" class="card-img-top" alt="">
                        <div class="card-body py-2"><strong>Hà Giang</strong></div>
                    </div>
                </div>

                <div class="col-md-3" data-aos="fade-up">
                    <div class="card blog-card text-center">
                        <img src="https://phuongnamticket.vn/wp-content/uploads/2023/01/SIN-Singapore-MelionPark1-8138x5000-1.jpg" class="card-img-top" alt="">
                        <div class="card-body py-2"><strong>Singapore</strong></div>
                    </div>
                </div>

                <div class="col-md-3" data-aos="fade-up" data-aos-delay="160">
                    <div class="card blog-card text-center">
                        <img src="https://hanoitourist.vn/sites/default/files/2025/02/cam-nang-du-lich-da-lat-1.jpg" class="card-img-top" alt="">
                        <div class="card-body py-2"><strong>Đà Lạt</strong></div>
                    </div>
                </div>

                <div class="col-md-3" data-aos="fade-up" data-aos-delay="240">
                    <div class="card blog-card text-center">
                        <img src="https://www.hoasen.edu.vn/demontfort/wp-content/uploads/sites/59/2024/06/du-lich-anh-quoc-1-scaled.jpeg" class="card-img-top" alt="">
                        <div class="card-body py-2"><strong>Vương quốc Anh</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Combo table -->
    <section class="section">
        <div class="container">
            <div class="section-head">
                <h3>Combo giá tốt</h3>
                <small class="muted">Gói tour + Khách sạn + Vé tiện lợi</small>
            </div>

            <div class="table-responsive" data-aos="fade-up">
                <table class="table table-bordered combo-table">
                    <thead class="table-light">
                        <tr>
                            <th>Combo</th>
                            <th>Điểm đến</th>
                            <th>Thời gian</th>
                            <th>Giá</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Combo Eco</td>
                            <td>Hà Nội - Hạ Long</td>
                            <td>3N2Đ</td>
                            <td>3.200.000 VNĐ</td>
                            <td><button class="btn btn-sm btn-success">Đặt</button></td>
                        </tr>
                        <tr>
                            <td>Combo Relax</td>
                            <td>Côn Đảo</td>
                            <td>4N3Đ</td>
                            <td>5.600.000 VNĐ</td>
                            <td><button class="btn btn-sm btn-success">Đặt</button></td>
                        </tr>
                        <tr>
                            <td>Combo Family</td>
                            <td>Trung Quốc</td>
                            <td>5N4Đ</td>
                            <td>10.300.000 VNĐ</td>
                            <td><button class="btn btn-sm btn-success">Đặt</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Blog -->
    <section class="section bg-white">
        <div class="container">
            <div class="section-head">
                <h3>Blog và tin tức</h3>
                <small class="muted">Cẩm nang và kinh nghiệm du lịch</small>
            </div>

            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="card blog-card">
                        <img src="https://media.vietravel.com/images/Content/7-1630640575-khau-pha.jpg" class="card-img-top" alt="">
                        <div class="card-body">
                            <h5>Top điểm sống ảo vùng Tây Bắc</h5>
                            <p class="muted">Gợi ý góc chụp và thời điểm</p>
                            <a class="btn btn-sm btn-outline-primary" href="#">Xem</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="80">
                    <div class="card blog-card">
                        <img src="https://cdn.vietnambiz.vn/2019/10/22/1505979632outgoing20tourism20mersoft-1571733923062897282595.jpg" class="card-img-top" alt="">
                        <div class="card-body">
                            <h5>Mẹo săn khuyến mãi tour quốc tế</h5>
                            <p class="muted">Cách săn vé và combo rẻ</p>
                            <a class="btn btn-sm btn-outline-primary" href="#">Xem</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="160">
                    <div class="card blog-card">
                        <img src="https://pavilionhotel.vn/uploads/article/full-h2fsz2fvc5ieih4-888-top-5-bai-bien-dep-nhat-da-nang.jpg" class="card-img-top" alt="">
                        <div class="card-body">
                            <h5>Checklist đi biển</h5>
                            <p class="muted">Những thứ không thể quên</p>
                            <a class="btn btn-sm btn-outline-primary" href="#">Xem</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-custom">
        <div class="container">
            <div class="row g-4">

                <div class="col-md-4">
                    <h5 class="fw-bold">TourTravel</h5>
                    <p class="footer-muted">Luôn đồng hành trên mọi chuyến đi của bạn</p>
                </div>

                <div class="col-md-4">
                    <h6 class="fw-bold">Liên hệ</h6>
                    <p class="footer-muted mb-1"><i class="bi bi-envelope"></i> support@tourtravel.vn</p>
                    <p class="footer-muted mb-1"><i class="bi bi-telephone"></i> 0123 456 789</p>

                    <h6 class="fw-bold mt-3">Kết nối</h6>
                    <div class="d-flex gap-2 mt-1">
                        <a href="#" class="btn btn-light btn-sm rounded-circle"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-light btn-sm rounded-circle"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-light btn-sm rounded-circle"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <h6 class="fw-bold">Phương thức thanh toán</h6>
                    <div class="payment-logos mt-2">
                        <img src="https://travel.com.vn/_next/static/media/visa.299c65a0.png">
                        <img src="https://travel.com.vn/_next/static/media/vnpay.2a25e56f.png">
                        <img src="https://travel.com.vn/_next/static/media/momo.11f49354.png">
                    </div>
                </div>

            </div>

            <hr class="my-4" style="border-color: rgba(255,255,255,0.25)">
            <p class="text-center footer-muted mb-0">&copy; 2025 TourTravel — All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 900,
            once: true
        });

        // Countdown 24h
        (function() {
            const el = document.getElementById('countdownA');
            if (!el) return;
            const target = new Date().getTime() + 24 * 60 * 60 * 1000;
            const iv = setInterval(() => {
                const now = Date.now();
                const d = target - now;
                if (d <= 0) {
                    el.textContent = 'Hết giờ!';
                    clearInterval(iv);
                    return;
                }
                const h = Math.floor((d % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((d % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((d % (1000 * 60)) / 1000);
                el.textContent = `${String(h).padStart(2,'0')} : ${String(m).padStart(2,'0')} : ${String(s).padStart(2,'0')}`;
            }, 1000);
        })();
    </script>
</body>

</html>