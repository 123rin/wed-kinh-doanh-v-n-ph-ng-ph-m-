<!DOCTYPE html>
<html>
<head>
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2 class="mb-4">Danh sách đơn hàng</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($dsdonhang as $dh): ?>
                <tr>
                    <td><?= $dh["id"] ?></td>
                    <td><?= $dh["tenkhach"] ?></td>
                    <td><?= $dh["ngaydat"] ?></td>
                    <td><?= $dh["trangthai"] ?></td>
                    <td>
                        <?php if ($dh["trangthai"] == "Chờ xác nhận"): ?>
                            <a href="index.php?action=xacnhan&id=<?= $dh["id"] ?>" class="btn btn-success btn-sm">Xác nhận</a>
                            <a href="index.php?action=huy&id=<?= $dh["id"] ?>" class="btn btn-danger btn-sm">Hủy</a>
                        <?php else: ?>
                            <span class="text-muted">Đã xử lý</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
