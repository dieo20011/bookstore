<div class="cart-body-right">
    <div class="receipt-contain">
        <div class="receipt-header">
            Tóm tắt đơn hàng
        </div>
        <div class="receipt-detail">
            <div class="product-num group-re">
                <span>Sản phẩm</span>
                <span><?php echo $count?></span>
            </div>
            <div class="product-tran group-re">
                <span>Phí vận chuyển</span>
                <span>Miễn phí</span>
            </div>
            <div class="product-tt group-re">
                <span>Tạm tính</span>
                <span><?php echo currency_format($total)?> <span class="undertext">đ</span></span>
            </div>
        </div>
        <div class="re-total">
            <span>Tổng cộng</span>
            <span><?php echo  currency_format($total)?> <span class="undertext">đ</span></span>
        </div>
    </div>
</div>