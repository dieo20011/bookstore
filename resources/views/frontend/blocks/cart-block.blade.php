<span class="number"><?php if (isset($data['cart'])) echo count($data['cart']);
                        else echo "0"; ?></span>
<label for="cart_list">
    <i class="fas fa-cart-plus">
    </i>
</label>
<input type="checkbox" hidden id="cart_list">
<div class="cart-list" id="cart">
    @if(isset($data['cart']))
    <div class="cart-body">
        <?php
        $total = 0;
        foreach ($data['cart'] as $key => $val) {
            $total += $data['cart'][$key]['SoLuong'] * $data['cart'][$key]['khuyenmai'];
        ?>
            <div class="cart-product-item">
                <div class="cart-product-img">
                    @php
                    $img = "img/product/".$data['cart'][$key]['img']
                    @endphp
                    <img src="{{asset($img)}}" alt="">
                </div>
                <div class="cart-product-detail">
                    <span class="product-name"><?php echo $data['cart'][$key]['TenSP'] ?></span>
                    <div class="cart-product-prices">
                        <span class="span-1"><?php echo $data['cart'][$key]['SoLuong'] ?> x</span>
                        <span><?php echo currency_format($data['cart'][$key]['khuyenmai'])  ?> <span class="undertext">đ</span> </span>
                        <span class="span-3" id="span-3">x</span>
                        <input type="text" hidden id="MaSP" value="<?php echo  $data['cart'][$key]['MaSP'] ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="cart-total">
        <div class="price-total">
            <span>Tổng cộng:</span>
            <span><?php echo currency_format($total) ?> <span class="undertext">đ</span></span>
        </div>
        <a class="cart-link" href="/Cart">Xem giỏ hàng</a>
    </div>
    @endif
</div>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $("span#span-3").on("click", function() {
            $parent = $(this).closest(".cart-product-prices");
            $id = $parent
                .children("input")
                .map(function() {
                    return $(this).val();
                })
                .get();

            $.ajax({
                url: "/Cart/delete",
                method: "POST",
                data: {
                    MaSP: $id[0]
                },
                success: function(data) {
                    $(".header-cart-icon").html(data);
                },
            });
        });
    });
</script>