<table class="table table-hover align-middle">
    <thead>
        <tr>
            <th class="ps-4 col-info">Khách hàng</th>
            <th class="text-center">Phòng</th>
            <th>Trạng thái</th>
            <th>Yêu cầu khác</th>
            <th>Ghi chú</th>
            <th class="pe-4 text-end"></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($customers)): ?>
        <?php foreach ($customers as $customer): ?>

        <?php 
            $parts = explode(' ', $customer['FullName']);
            $initial = substr(end($parts), 0, 1);
            
            $isVeg = ($customer['Vegetarian'] ?? 0) == 1;
            $hasMedical = !empty($customer['MedicalCondition']);
            $hasOther = !empty($customer['OtherRequests']);
            $note = $customer['SpecialRequests'] ?? ''; // Lấy ghi chú
        ?>

        <tr>
            <td class="ps-4">
                <div class="d-flex align-items-center">
                    <div class="avatar-circle flex-shrink-0"><?= $initial ?></div>
                    <div>
                        <div class="fw-bold text-dark"><?= htmlspecialchars($customer['FullName']) ?></div>
                        <div class="small text-muted"><?= htmlspecialchars($customer['Phone']) ?></div>
                    </div>
                </div>
            </td>

            <td class="text-center">
                <span class="badge-room"><?= !empty($customer['RoomNumber']) ? $customer['RoomNumber'] : '--' ?></span>
            </td>

            <td>
                <?php if($isVeg): ?>
                <span class="badge-soft-success d-block w-100 text-center mb-1">Chay</span>
                <?php endif; ?>
                <?php if($hasMedical): ?>
                <span class="badge-soft-danger d-block w-100 text-center">Sức khỏe</span>
                <?php endif; ?>
                <?php if(!$isVeg && !$hasMedical): ?>
                <span class="text-muted small opacity-50">-</span>
                <?php endif; ?>
            </td>

            <td style="max-width: 200px;">
                <?php if($hasMedical): ?>
                <div class="text-danger small fw-bold mb-1">
                    <i class="bi bi-exclamation-circle me-1"></i><?= htmlspecialchars($customer['MedicalCondition']) ?>
                </div>
                <?php endif; ?>
                <?php if($hasOther): ?>
                <div class="text-primary small">
                    <i class="bi bi-stars me-1"></i><?= htmlspecialchars($customer['OtherRequests']) ?>
                </div>
                <?php endif; ?>
            </td>

            <td style="max-width: 200px;">
                <?php if(!empty($note)): ?>
                <span class="text-secondary small fst-italic">
                    <?= htmlspecialchars($note) ?>
                </span>
                <?php else: ?>
                <span class="text-muted small opacity-25">-</span>
                <?php endif; ?>
            </td>

            <td class="pe-4 text-end">
                <button class="btn btn-light btn-sm rounded-circle shadow-sm text-primary" data-bs-toggle="modal"
                    data-bs-target="#editModal<?= $customer['CustomerID'] ?>">
                    <i class="bi bi-pencil-fill"></i>
                </button>
            </td>
        </tr>

        <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="6" class="text-center py-5">Trống</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>