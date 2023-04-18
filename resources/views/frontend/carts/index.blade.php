<div class="cart">
    <div class="wrap">
        <div class="cart-header">
            <div class="cart-logo">
                <span>vina<span>book</span>.com
                </span>
            </div>
        </div>
        <div class="cart-body">
            <div class="cart-body-header">
                <span>Giỏ hàng</span>
            </div>
            @if(isset($data['cart']))
            <div class="cart-body-contain">
                @include("frontend.carts.cart-form")
            </div>
           @endif
        </div>
        <div class="cart-btn">
            <div class="cart-btn-body">
                <button class="btn btn-back disiable"><a style="text-decoration: none; color: #fff"href="/">Quay lại</a></button>
                <a href="/Order/confirmAddrress" class="btn btn-continue normal" id="next-address">Thanh toán</a>
            </div>
        </div>
    </div>
    <div class="br">
    </div>
</div>
