<?php
$tourID = isset($_GET['tourID']) ? intval($_GET['tourID']) : 0;
?>
<div class="container">
    <h3>Thêm nhật ký </h3>
    <form method="post" action="index.php?act=tourlog-store">
        <input type="hidden" name="TourID" value="<?php echo $tourID; ?>">
        <div class="mb-3">
            <label class="form-label">Người ghi</label>
            <select name="EmployeeID" class="form-select">
                <option value="">-- Chọn --</option>
                <?php foreach ($employees as $e): ?>
                    <option value="<?php echo $e['EmployeeID']; ?>"><?php echo htmlspecialchars($e['FullName']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Ngày giờ</label>
            <input type="datetime-local" name="LogDate" class="form-control" value="<?php echo date('Y-m-d\TH:i'); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Nội dung</label>
            <textarea name="Note" class="form-control" rows="6"></textarea>
        </div>
        <button class="btn btn-primary">Lưu</button>
        <a class="btn btn-secondary" href="index.php?act=tourlog-list&tourID=<?php echo $tourID; ?>">Quay lại</a>
    </form>
</div>
<?php
$content = ob_get_clean();
require 'layout.php';
?>