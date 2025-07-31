<?php include("inc/top.php"); ?>

<br><br>
<div class="container">
    <div class="row">
        <h3>Trang thông tin khách hàng</h3>
        <form>
            <?php if ($khachhang && is_array($khachhang)) : ?>
                <input type="text" name="name" value="<?= $khachhang['hoten'] ?? '' ?>">
                <input type="email" name="email" value="<?= $khachhang['email'] ?? '' ?>">
                <input type="text" name="phone" value="<?= $khachhang['sodienthoai'] ?? '' ?>">
                <button type="submit">Lưu</button>
            <?php else: ?>
                <p style="color: red;">Không tìm thấy thông tin khách hàng.</p>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php include("inc/bottom.php"); ?>
