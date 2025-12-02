<div class="container">
    <h3>Sửa nhật ký #<?php echo $log['LogID']; ?></h3>
    <form method="post" action="index.php?act=tourlog-update&id=<?php echo $log['LogID']; ?>">
        <input type="hidden" name="TourID" value="<?php echo htmlspecialchars($log['TourID']); ?>">
        <div class="mb-3">
            <label class="form-label">Người ghi</label>
            <select name="EmployeeID" class="form-select">
                <option value="">-- Chọn --</option>
                <?php foreach ($employees as $e): ?>
                    <option value="<?php echo $e['EmployeeID']; ?>" <?php echo ($e['EmployeeID'] == $log['EmployeeID']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($e['FullName']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Ngày giờ</label>
            <input type="datetime-local" name="LogDate" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($log['LogDate'])); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Nội dung</label>
            <textarea name="Note" class="form-control" rows="6"><?php echo htmlspecialchars($log['Note']); ?></textarea>
        </div>
        <button class="btn btn-primary">Cập nhật</button>
        <a class="btn btn-secondary" href="index.php?act=tourlog-list&tourID=<?php echo $log['TourID']; ?>">Quay lại</a>
    </form>
</div>
<?php
$content = ob_get_clean();
require 'layout.php';
?>