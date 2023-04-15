<div class="app-containt-body">
    <div class="wrap">
        <div class="app-containt-body-left">
            <div class="advertisement-item background-color-banner">
                <h3>Sách mới hay</h3>
                <div class="advertisement-containt">
                    
                    <div class="advertisement-img">
                        <img src="{{asset('img/news.jpg')}}" alt="">
                    </div>
                    <div class="advertisement-body">
                        <div class="advertisement-top">
                            <h4 class="advertisement-body-header">
                                <a href="">Tin Tức Kiến Tạo - Constructive News</a>
                            </h4>
                            <span>
                                Ulrik Haagerup
                            </span>
                        </div>
                        <div class="advertisement-bottom">
                            <div class="prices">
                                <span class="promotion-percentage">
                                    -14%
                                </span>
                                <span class="cost">
                                    90.000 <span class="undertext">đ</span>
                                </span>
                                <span class="promotion-price">
                                    77.000 <span class="undertext">đ</span>
                                </span>
                            </div>
                            <div class="btn-price">
                                <a class="order-btn" href="">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            foreach($data['categoryMain'] as $key => $value) {
                // if(count($data['products'][$key]) == 0) 
                //         continue;
            ?>
            <div class="product-containt">
                <h3><?php echo $value['TenTheLoai']?></h3>
                <div class="product-list">
                <?php
                foreach($data['products'][$key] as $k => $val) {
                    ?>
                    <div class="product-item">
                        <div class="product-item-top">
                            <div class="product-item-img">
                                <?php
                                    $id = $val['MaSP']
                                    ?>
                                <a  href="{{ route('detailbook', ['id'=>$id]) }}">
                                    @php
                                        $img = "img/product/".$val['img'];
                                    @endphp
                                <img src="{{asset($img)}}" alt="">
                             </a>
                            </div>
                            <div class="product-item-decription">
                                <div class="product-item-header">
                                    <a  class="product-item-name">
                                    <?php echo $val['TenSP']?>
                                    </a>
                                    <span class="product-item-author">
                                    <?php echo $val['TenTG']?>
                                    </span>
                                </div>
                                <div class="product-item-des-detail">
                                <?php echo $val['MoTa']?>
                                </div>
                            </div>
                        </div>
                        <div class="product-item-bottom">
                            <div class="product-bottom-wrap">
                                <div class="pricres">
                                    {{-- <?php
                                        if($val['discount'] != 0) {
                                    ?> --}}
                                    <div class="btn-price"> 
                                    <?php echo "-".$val['KhuyenMai']."%"?>
                                    </div>
                                    {{-- <?php
                }
                                    ?> --}}
                                    <div class="prices-detail">
                                        <span class="prices-cost <?php if($val['discount'] != 0) echo  
                                        'line-through'?> "> <?php echo currency_format($val['DonGia'])?><span class="undertext">đ</span></span>
                                        <span class="promotion-price">
                                        
                                        <?php if($val['discount'] != 0) echo $val['discount']."<span class='undertext'>đ</span>"?>
                                         
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                    ?>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
        <div class="app-containt-body-right">
            <?php
            foreach($data['categorysForProductsSellig'] as $key => $value) {
            ?>
            <div class="product-list-mainbox">
                <h3 class="product-list-title">
                    <?php echo $value['TenTheLoai']?>
                </h3>
                <div class="list-product-vertical">
                    <?php
                    foreach($data['productsSelling'][$key] as $k => $val) {
                        // if(count($data['productsSelling'][$key]) == 0) {
                        //     continue;
                        // }
                    ?>
                    <div class="product-item-v">
                        <div class="product-item-content">
                            <div class="product-item-v-img">
                                @php
                                $img = "img/product/".$val['img']
                                @endphp
                                <img src="{{asset($img)}}"  alt="">
                            </div>
                            <div class="product-item-v-body">
                                <a style="text-decoration: none" href="{{ route('detailbook', ['id'=>$id]) }}">
                                    <div class="product-name">
                                         <?php echo $val['TenSP']?>
                                    </div>
                                </a>
                                <div class="product-author">
                                     <?php echo $val['TenTG']?>
                                </div>
                                <div class="product-item-prices">
                                    {{-- <div class="price-cost">
                                        <span><?php echo $val['DonGia']?><span class="undertext">đ</span></span>
                                    </div> --}}
                                    <span class="prices-cost <?php if($val['discount'] != 0) echo  
                                        'line-through'?> "> <?php echo currency_format($val['DonGia'])?><span class="undertext">đ</span></span>
                                    <div class="prices-promotion">
                                        <span> <?php if($val['discount'] != 0) echo $val['discount']."<span class='undertext'>đ</span>"?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>