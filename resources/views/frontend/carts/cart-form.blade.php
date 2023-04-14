<div class="cart-body-left">
    <form action="" id="cart">
        <div class="form-header">
            <span>Sản phẩm</span>
        </div> 
        <div class="product-list">
            <?php
                $total = 0;
                $count = 0;
                foreach( $data['cart'] as $key => $val) {    
                    $total +=  $data['cart'][$key]['SoLuong'] *  $data['cart'][$key]['khuyenmai'];
                    $count += $data['cart'][$key]['SoLuong'];
                    ?>
                    <div class="group-item">
                        <div class="product-left">
                            <div class="prodcut-img">
                                @php
                                $img = "img/product/".$data['cart'][$key]['img']
                                @endphp
                                <img src="{{asset($img)}}" alt="">    
                            </div>
                            <div class="product-decritption">
                                <div class="produc-name">
                                @php echo  $data['cart'][$key]['TenSP']@endphp
                                </div>
                                <div class="product-edit">
                                    <input type="text" hidden name="idsach" value="@php echo  $data['cart'][$key]['MaSP']@endphp">
                                    <div class="des btn-id">
                                        -
                                    </div>
                                    <div class="input-num ">
                                        <input type="text"  readonly class="btn-id" value="@php echo  $data['cart'][$key]['SoLuong']@endphp">
                                    </div>
                                    <div class="inc btn-id">
                                        +
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-right">
                            <input type="text" hidden name="idsach" value="@php echo  $data['cart'][$key]['MaSP']@endphp">
                            <span> @php echo  $data['cart'][$key]['SoLuong']@endphp x @php echo  currency_format($data['cart'][$key]['khuyenmai'])@endphp<span class="undertext">đ</span> </span>
                            <i class="fas fa-trash-alt"></i>
                        </div>
                    </div>
            <?php } ?>
        </div>
    </form>
</div>
@include('frontend.carts.cart-info-bill')