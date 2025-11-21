<?php require_once __DIR__ . '/../../sidebar.php'; ?>

<div class="container mt-4">
    <h2 class="text-primary mb-3">Thêm khách vào tour</h2>

    <form method="post">

        <div class="mb-3">
            <label class="form-label">Chọn khách</label>
            <select name="customerID" class="form-select" required>
                <?php foreach($allCustomers as $cust): ?>
                <option value="<?= $cust['CustomerID'] ?>">
                    <?= htmlspecialchars($cust['FullName'] ?? '') ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Phòng khách sạn</label>
            <input type="text" name="roomNumber" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Ghi chú đặc biệt</label>
            <textarea name="note" class="form-control" placeholder="Ăn chay, bệnh lý, yêu cầu riêng..."></textarea>
        </div>

        <button type="submit" class="btn btn-success">Thêm khách</button>

        <a href="<?= BASE_URL ?>?act=tourcustomers&tourID=<?= $tourID ?>" class="btn btn-secondary">Quay lại</a>

    </form>
</div>