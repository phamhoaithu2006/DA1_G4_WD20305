<h2>Danh sách khách hàng tour: <?= $tour['TourName'] ?></h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Họ và tên</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Room</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($customers as $index => $customer): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= $customer['FullName'] ?></td>
            <td><?= $customer['Email'] ?></td>
            <td><?= $customer['Phone'] ?></td>
            <td><?= $customer['RoomNumber'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>