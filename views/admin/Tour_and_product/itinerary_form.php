<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm Lịch Trình</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow border-0" style="max-width: 600px; margin: 0 auto;">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary">Thêm lịch trình: <?= htmlspecialchars($tour['TourName']) ?></h5>
            </div>
            <div class="card-body">
                <form action="?act=tour-itinerary-store" method="POST">
                    <input type="hidden" name="tour_id" value="<?= $tour['TourID'] ?>">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ngày thứ</label>
                        <input type="number" name="day_number" class="form-control" placeholder="Ví dụ: 1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tiêu đề ngắn</label>
                        <input type="text" name="title" class="form-control" placeholder="VD: TP.HCM - Đà Lạt" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Chi tiết hoạt động</label>
                        <textarea name="description" class="form-control" rows="4"
                            placeholder="Sáng: Đi đâu... Trưa: Ăn gì..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Khách sạn/Lưu trú</label>
                        <input type="text" name="accommodation" class="form-control"
                            placeholder="VD: Khách sạn Mường Thanh">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold d-block">Bữa ăn bao gồm</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="meals[]" value="Sáng">
                            <label class="form-check-label">Sáng</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="meals[]" value="Trưa">
                            <label class="form-check-label">Trưa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="meals[]" value="Tối">
                            <label class="form-check-label">Tối</label>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Lưu lịch trình</button>
                        <a href="?act=detail&id=<?= $tour['TourID'] ?>" class="btn btn-secondary">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>