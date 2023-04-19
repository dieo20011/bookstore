<div class="body-top">
    <span class="title">Xác nhận đặt hàng</span>
    <div class="body">
        <div class="body-container">
                <div class="cofirm-body">
                    <div class="colum-1">
                        <h5>Sản phẩm</h5>
                        <div class="list-product">
                            <?php 
                            $total = 0;
                            $count = 0;
                            foreach($data['cart'] as $key => $val) {    
                                $total += $data['cart'][$key]['SoLuong'] * $data['cart'][$key]['khuyenmai'];
                                if($data['cart'][$key]['SoLuong'] == 0) continue;
                                $count +=$data['cart'][$key]['SoLuong'];
                                ?>
                            <div class="product-item">
                                @php
                                $img = "img/product/".$val['img'];
                                @endphp
                                <img src={{asset($img)}} width="50px" height="50px" alt="">
                                <span>  <?php echo $data['cart'][$key]['TenSP']?></span>
                                <span><?php echo $data['cart'][$key]['SoLuong']?> x <?php echo currency_format($data['cart'][$key]['khuyenmai'])?> đ</span>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                    <div class="colum-1">
                        <h5>Địa chỉ giao hàng</h5>
                        <div class="address-infor">
                            <span><?php echo $data['userInfo']['TenKH']?></span>
                            <span><?php echo $data['address-infor'][0].", Phường "; echo $data['address-infor'][1].", Quận "; echo $data['address-infor'][2]?></span>
                            <span><?php echo "Thành phố ".$data['address-infor'][3].", Nước"; echo $data['address-infor'][4].",";?></span>
                            <span><?php echo "SĐT"."".$data['address-infor'][5].",";?></span>
                            <span>giao hàng tận nơi(<?php echo $data['address-infor'][3]?>)</span>

                        </div>
                        
                    </div>
                    <div class="colum-1">
                        <h5>Tóm tắt hóa đơn</h5>
                        <div class="bill-temp">
                            <div class="bill-item">
                                <span>Tổng tiền</span>
                                <span><?php echo currency_format($total)?> <span class="undertext">đ</span></span>
                            </div>
                            <div class="bill-item">
                                <span>Mã giảm giá</span>
                                <span>0đ</span>
                            </div>
                            <div class="bill-item">
                                <span>Tạm tính</span>
                                <span><?php echo currency_format($total)?> <span class="undertext">đ</span></span>
                            </div>
                            <hr>
                            <div class="bill-item">
                                <span>Tổng cộng</span>
                                <span><?php echo currency_format($total)?><span class="undertext">đ</span></span>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
