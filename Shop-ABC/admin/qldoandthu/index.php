<?php include("../inc/top.php"); ?>

<h4 class="text-info">Quản lý doanh thu</h4> 

<!-- Thống kê doanh thu ảo -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Doanh thu tháng này</h5>
                <p class="card-text fs-4">₫5,200,000</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Doanh thu tháng trước</h5>
                <p class="card-text fs-4">₫4,800,000</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Doanh thu năm nay</h5>
                <p class="card-text fs-4">₫60,000,000</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Doanh thu cả năm trước</h5>
                <p class="card-text fs-4">₫70,000,000</p>
            </div>
        </div>
    </div>
</div>

<!-- Biểu đồ doanh thu theo tháng (sử dụng Chart.js để vẽ) -->
<h5 class="mt-4">Biểu đồ doanh thu theo tháng</h5>
<canvas id="doanhThuChart" width="400" height="200"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('doanhThuChart').getContext('2d');
    var doanhThuChart = new Chart(ctx, {
        type: 'line', // Biểu đồ đường
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // Tháng
            datasets: [{
                label: 'Doanh thu (₫)',
                data: [3000000, 4000000, 3500000, 4500000, 3800000, 5000000, 4000000, 4600000, 4900000, 5300000, 5500000, 6000000], // Số liệu doanh thu ảo
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php include("../inc/bottom.php"); ?>
