<?php include("../inc/top.php"); ?>

<h4 class="text-info">Chương trình khuyến mãi</h4>

<!-- Danh sách khuyến mãi ảo -->
<div class="table-responsive mt-4">
    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>Tên chương trình</th>
                <th>Thời gian</th>
                <th>Giảm giá</th>
                <th>Áp dụng cho</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Giảm giá mùa hè</td>
                <td>01/07/2025 - 31/07/2025</td>
                <td>Giảm 20%</td>
                <td>Tất cả sản phẩm</td>
                <td><span class="badge bg-success">Đang diễn ra</span></td>
            </tr>
            <tr>
                <td>Flash Sale cuối tuần</td>
                <td>26/07/2025 - 28/07/2025</td>
                <td>Giảm 30% sản phẩm điện tử</td>
                <td>Danh mục: Điện tử</td>
                <td><span class="badge bg-warning text-dark">Sắp diễn ra</span></td>
            </tr>
            <tr>
                <td>Khuyến mãi Tết</td>
                <td>01/02/2025 - 10/02/2025</td>
                <td>Giảm 15%</td>
                <td>Tổng đơn hàng trên 1 triệu</td>
                <td><span class="badge bg-secondary">Đã kết thúc</span></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Gợi ý tạo mới chương trình (tùy chọn nếu bạn thêm tính năng thêm/sửa sau) -->
<a href="#" class="btn btn-outline-primary mt-3">
    <i class="bi bi-plus-circle"></i> Tạo chương trình mới
</a>

<?php include("../inc/bottom.php"); ?>
