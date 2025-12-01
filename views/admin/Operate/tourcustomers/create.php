<?php
// $tourID = ID tour
// $allCustomers = danh sách tất cả khách (để chọn thêm)
?>

<div class="container mt-4">
    <h3>Thêm khách vào Tour #<?= $tourID ?></h3>

    <form action="?act=tourcustomer-add" method="post" class="row g-3">
        <input type="hidden" name="tourID" value="<?= $tourID ?>">

        <div class="col-md-6">
            <label>Chọn khách:</label>
            <select name="customerID" class="form-select" required>
                <option value="">-- Chọn khách --</option>
                <?php foreach($allCustomers as $c): ?>
                <option value="<?= $c['CustomerID'] ?>"><?= $c['FullName'] ?> (<?= $c['Phone'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label>Ghi chú:</label>
            <input type="text" name="note" class="form-control" placeholder="Ăn chay, dị ứng,...">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Thêm khách</button>
            <a href="?act=tourcustomer-list&tourID=<?= $tourID ?>" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
</div>