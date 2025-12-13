<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<?php require_once PATH_ROOT . 'views/admin/navbar.php'; ?>

<div class="d-flex admin-layout">
    <div class="sidebar-wrapper bg-white shadow-sm border-end">
        <?php require_once PATH_ROOT . 'views/admin/sidebar.php'; ?>
    </div>

    <div class="admin-content flex-grow-1 p-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">So sánh hiệu quả Tour</h2>
                <p class="text-muted mb-0">Phân tích đối sánh doanh thu & lợi nhuận theo giai đoạn</p>
            </div>

            <form action="" method="GET" class="d-flex gap-2 bg-white p-2 rounded-4 shadow-sm border">
                <input type="hidden" name="act" value="finance-compare">

                <select name="type" class="form-select form-select-sm border-0 bg-light fw-bold" style="width: 140px;" onchange="this.form.submit()">
                    <option value="quarter" <?= ($type == 'quarter') ? 'selected' : '' ?>>Theo Quý</option>
                    <option value="month" <?= ($type == 'month') ? 'selected' : '' ?>>Theo Tháng</option>
                    <option value="year" <?= ($type == 'year') ? 'selected' : '' ?>>Theo Năm</option>
                </select>

                <select name="year" class="form-select form-select-sm border-0 bg-light fw-bold" style="width: 110px;" onchange="this.form.submit()">
                    <?php
                    for ($i = date('Y'); $i >= date('Y') - 2; $i--) {
                        $selected = ($year == $i) ? 'selected' : '';
                        echo "<option value='$i' $selected>Năm $i</option>";
                    }
                    ?>
                </select>

                <a href="<?= BASE_URL ?>?act=finance-report" class="btn btn-sm btn-light border rounded-3 ms-2" title="Thoát">
                    <i class="bi bi-x-lg"></i>
                </a>
            </form>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                            <i class="bi bi-bar-chart-fill"></i>
                        </div>
                        <h6 class="text-secondary text-uppercase small fw-bold mb-0">Biểu đồ trực quan</h6>
                    </div>
                    <div style="height: 350px;">
                        <canvas id="comparisonChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-bottom-0">
                <h6 class="text-secondary text-uppercase small fw-bold mb-0">Chi tiết số liệu</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold">Tên Tour</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Giai đoạn</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold text-end">Doanh thu</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold text-end">Lợi nhuận</th>
                                <th class="pe-4 py-3 text-secondary text-uppercase small fw-bold text-center">Tỷ suất lãi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($comparison_data)): ?>
                                <?php foreach ($comparison_data as $row): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark"><?= $row['TourName'] ?></td>
                                        <td>
                                            <span class="badge bg-light text-secondary border">
                                                <?= $row['TimeLabel'] ?>
                                            </span>
                                        </td>
                                        <td class="text-end text-primary font-monospace">
                                            <?= number_format($row['TotalRevenue']) ?> ₫
                                        </td>
                                        <td class="text-end fw-bold text-success font-monospace">
                                            <?= number_format($row['TotalProfit']) ?> ₫
                                        </td>
                                        <td class="text-center pe-4">
                                            <?php
                                            $eff = $row['ProfitMargin'];
                                            $badgeClass = $eff > 30 ? 'bg-success-subtle text-success-emphasis' : ($eff > 15 ? 'bg-warning-subtle text-warning-emphasis' : 'bg-danger-subtle text-danger-emphasis');
                                            ?>
                                            <span class="badge rounded-pill <?= $badgeClass ?> px-3">
                                                <?= number_format($eff, 1) ?>%
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        Chưa có dữ liệu so sánh cho giai đoạn này
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = <?= json_encode($chartLabels ?? []) ?>;
    const dataRevenue = <?= json_encode($chartRevenue ?? []) ?>;
    const dataProfit = <?= json_encode($chartProfit ?? []) ?>;

    const ctx = document.getElementById('comparisonChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                    label: 'Doanh thu',
                    data: dataRevenue,
                    backgroundColor: 'rgba(13, 110, 253, 0.7)',
                    borderRadius: 4
                },
                {
                    label: 'Lợi nhuận',
                    data: dataProfit,
                    backgroundColor: 'rgba(25, 135, 84, 0.8)',
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(context.raw);
                        }
                    }
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