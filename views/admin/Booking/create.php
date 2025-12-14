<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once __DIR__ . '/../navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once __DIR__ . '/../sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Tạo Booking mới</h2>
                <p class="text-muted mb-0">Đặt Tour cho khách lẻ hoặc khách đoàn</p>
            </div>
            <a href="?act=booking-list" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Lỗi:</strong> <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= BASE_URL ?>?act=booking-create" id="bookingForm" class="needs-validation"
            novalidate>
            <div class="row g-4">

                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h5 class="card-title fw-bold text-primary">
                                <i class="bi bi-person-circle me-2"></i> Thông tin người đặt (Trưởng đoàn)
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Họ và tên <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="fullname" class="form-control" required
                                        placeholder="Ví dụ: Nguyễn Văn A">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required
                                        placeholder="name@example.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Số điện thoại <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control" required
                                        placeholder="09xxxxxxx">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Địa chỉ</label>
                                    <input type="text" name="address" class="form-control"
                                        placeholder="Số nhà, đường, quận/huyện...">
                                </div>
                            </div>

                            <div id="group-section" class="mt-4 d-none">
                                <hr class="border-secondary opacity-25">
                                <h6 class="fw-bold text-secondary mb-3">
                                    <i class="bi bi-people-fill me-2"></i>Danh sách thành viên đi cùng (<span
                                        id="member-count-label">0</span>)
                                </h6>
                                <div id="members-container">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm h-100 bg-light-subtle">
                        <div class="card-header bg-transparent border-0 pt-4 px-4">
                            <h5 class="card-title fw-bold text-success">
                                <i class="bi bi-airplane-engines me-2"></i> Chi tiết chuyến đi
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Chọn Tour</label>
                                <select name="tour_id" id="tourSelect"
                                    class="form-select form-select-lg shadow-sm border-0" required>
                                    <option value="" data-price="0" data-slots="0" selected disabled>-- Chọn Tour du
                                        lịch --</option>
                                    <?php foreach ($tours as $t): ?>
                                        <option value="<?= $t['TourID'] ?>" data-price="<?= $t['Price'] ?>"
                                            data-slots="<?= $t['MaxSlots'] ?? 20 ?>"
                                            <?= ($t['TourID'] == ($selectedTour ?? '') ? 'selected' : '') ?>>
                                            <?= htmlspecialchars($t['TourName']) ?> (Còn trống:
                                            <?= $t['MaxSlots'] ?? 'N/A' ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Số lượng
                                    khách</label>
                                <div class="input-group input-group-lg">
                                    <button class="btn btn-outline-secondary bg-white border-end-0" type="button"
                                        onclick="adjustPeople(-1)"><i class="bi bi-dash"></i></button>
                                    <input type="number" name="num_people" id="numPeople"
                                        class="form-control text-center border-start-0 border-end-0 shadow-sm" value="1"
                                        min="1" required>
                                    <button class="btn btn-outline-secondary bg-white border-start-0" type="button"
                                        onclick="adjustPeople(1)"><i class="bi bi-plus"></i></button>
                                </div>
                                <div class="form-text mt-1 text-end" id="slots-alert"></div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Yêu cầu đặc
                                    biệt</label>
                                <textarea name="note" class="form-control border-0 shadow-sm" rows="3"
                                    placeholder="Ăn chay, phòng view biển, xe lăn..."></textarea>
                            </div>

                            <div class="alert alert-light border border-secondary-subtle">
                                <div class="d-flex justify-content-between">
                                    <span>Đơn giá:</span>
                                    <span class="fw-bold" id="unit-price">0 đ</span>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">TỔNG CỘNG:</span>
                                    <span class="fs-4 fw-bold text-primary" id="total-price">0 đ</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent border-0 p-4 pt-0">
                            <input type="hidden" name="group_members_json" id="group_members_json">

                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow text-uppercase"
                                id="btnSubmit">
                                <i class="bi bi-check2-circle me-2"></i> Xác nhận đặt Tour
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    const numPeopleInput = document.getElementById('numPeople');
    const groupSection = document.getElementById('group-section');
    const membersContainer = document.getElementById('members-container');
    const memberCountLabel = document.getElementById('member-count-label');
    const jsonInput = document.getElementById('group_members_json');
    const tourSelect = document.getElementById('tourSelect');
    const unitPriceEl = document.getElementById('unit-price');
    const totalPriceEl = document.getElementById('total-price');
    const form = document.getElementById('bookingForm');

    // 1. Hàm tăng giảm số lượng
    function adjustPeople(amount) {
        let current = parseInt(numPeopleInput.value) || 1;
        let newValue = current + amount;
        if (newValue < 1) newValue = 1;

        // Check max slots
        const selectedOption = tourSelect.options[tourSelect.selectedIndex];
        const maxSlots = parseInt(selectedOption.getAttribute('data-slots')) || 999;

        if (newValue > maxSlots) {
            alert(`Tour này chỉ tối đa ${maxSlots} người!`);
            newValue = maxSlots;
        }

        numPeopleInput.value = newValue;
        renderGroupInputs();
        updatePrice();
    }

    // 2. Render các ô nhập liệu cho thành viên đi cùng
    function renderGroupInputs() {
        const totalPeople = parseInt(numPeopleInput.value) || 1;
        const membersNeeded = totalPeople - 1; // Trừ 1 vì người đặt là trưởng đoàn

        if (membersNeeded > 0) {
            groupSection.classList.remove('d-none');
            memberCountLabel.innerText = membersNeeded;
        } else {
            groupSection.classList.add('d-none');
            membersContainer.innerHTML = ''; // Clear nếu chỉ có 1 người
            return;
        }

        // Logic thông minh: Giữ lại data đã nhập nếu số lượng tăng lên
        const currentInputs = membersContainer.querySelectorAll('.member-row');
        let html = '';

        for (let i = 0; i < membersNeeded; i++) {
            // Nếu ô input đó đã tồn tại, giữ nguyên giá trị (để ko bị mất khi user tăng số lượng)
            // Ở đây để đơn giản mình render lại nhưng trong thực tế nên appendChild
            // Phiên bản đơn giản:
            html += `
                <div class="member-row row g-2 mb-2 align-items-center bg-light p-2 rounded border">
                    <div class="col-auto">
                        <span class="badge bg-secondary rounded-circle">${i + 2}</span>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control form-control-sm member-name" placeholder="Tên thành viên ${i + 1}" required>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm member-phone" placeholder="Số điện thoại (Tùy chọn)">
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control form-control-sm member-note" placeholder="Ghi chú">
                    </div>
                </div>
            `;
        }
        membersContainer.innerHTML = html;
    }

    // 3. Cập nhật giá tiền
    function updatePrice() {
        const selectedOption = tourSelect.options[tourSelect.selectedIndex];
        if (!selectedOption) return;

        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const qty = parseInt(numPeopleInput.value) || 1;

        const total = price * qty;

        unitPriceEl.innerText = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(price);
        totalPriceEl.innerText = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(total);
    }

    // 4. Sự kiện lắng nghe
    numPeopleInput.addEventListener('change', () => {
        renderGroupInputs();
        updatePrice();
    });
    tourSelect.addEventListener('change', updatePrice);

    // 5. Trước khi submit form: Gom dữ liệu thành viên vào JSON
    form.addEventListener('submit', function(e) {
        const rows = document.querySelectorAll('.member-row');
        const membersData = [];

        rows.forEach(row => {
            const name = row.querySelector('.member-name').value;
            const phone = row.querySelector('.member-phone').value;
            const note = row.querySelector('.member-note').value;
            if (name) {
                membersData.push({
                    name,
                    phone,
                    note
                });
            }
        });

        jsonInput.value = JSON.stringify(membersData);
    });

    // Init
    updatePrice();
</script>