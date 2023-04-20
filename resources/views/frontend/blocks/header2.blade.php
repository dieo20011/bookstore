<body>
    <?php
        if(isset($data['result'])) { ?>
            <div class="Notification <?php echo $data['typeMessage']?>" >
                    <span><?php echo $data['result'] ; unset($data['result'])?></span>
            </div>
    <?php
        }
    ?> 
    <div class="wrap-app">
    <div class="app">
        <header>
            <div class="recommend">
                    <div class="reconmend-wrap">
                        <div class="recommend-contend">
                            <i class="fas fa-shuttle-van recommend-contend-icon"></i>
                            <span class="recommend-contend-span">
                                Miễn phí giao hàng
                            </span>
                            <div class="recommend-decription">
                            </div>
                        </div>
                        <div class="recommend-contend">
                            <i class="fas fa-book recommend-contend-icon"></i>
                            <span class="recommend-contend-span">
                                80.000 tựa sách
                            </span>
                            <div class="recommend-decription">
                            </div>
                        </div>
                        <div class="recommend-contend">
                            <i class="fas fa-mobile-alt recommend-contend-icon"></i>
                            <span class="recommend-contend-span">
                                Vinabook Reader
                            </span>
                            <div class="recommend-decription">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="app-header">
                <div class="app-header-wrap">
                    <div class="header-logo">
                        <a href="{{ route('index') }}">Vina<span>book</span>.com</a>
                    </div>
                    <div class="header-search">
                        <form action="{{ route('search') }}"" class="header-form" method="GET">
                        @csrf
                            <div class="group-input">
                                {{-- <input type="text" name="values" placeholder="Tìm kiếm tựa sách, tác giả">
                                <i class="fas fa-search header-form-icon"></i>
                                <button class="header-form-btn">Tìm sách</button> --}}

                                <input type="text" name="search" placeholder="Tìm kiếm tựa sách, tác giả"
                                value="{{ request('search') }}">
                                <i class="fas fa-search header-form-icon"></i>
                                <button type="submit" class="header-form-btn">Tìm sách</button>
                            </div>
                        </form>
                    </div>
                <div class="header-cart-icon">
                       <!-- <span class="number"><?php if(isset($data['cart']))echo count($data['cart']); else echo "0";?></span>
                        <label for="cart_list">
                            <i class="fas fa-cart-plus">
                                </i>
                            </label>
                            <input type="checkbox" hidden id="cart_list">
                            <div class="cart-list" id="cart"> -->
                                @include("frontend.blocks.cart-block")
                           <!--</div> -->
                        </div> 
                    <?php
                        if(!isset($data['userInfo'])) {
                            ?>
                    <div class="header-link">
                        <a href="/User/login" class="btn-login">Đăng nhập</a>
                        <a href="/User/register">Đăng ký</a>
                    </div>
                    <?php
                    } else {
                        $info = $data['userInfo'];
                        ?>
                    <div class="header-link">
                        <a  id="info-user" class="btn-login"> <?php echo $info['TenKH']?> </a>
                        <ul id="submenu-info">
                            <li><a class="submenu" href="/User/showInfo">Thông tin cá nhân</a></li>
                            <li><a class="submenu" href="/User/showBill">Đơn hàng</a></li>
                        </ul>
                        <a href="/User/logout">Logout</a>
                    </div>
                    <?php 
                    }
                    ?>
                </div>
            </div>
        </header>
        <div class="app-title">
                <div class="wrap">
                    <div class="app-title-list">
                        <i class="fas fa-bars"></i>
                        <span>Danh Mục Sách</span>
                        <label for="menu-to-search">
                            <i class="fas fa-chevron-down"></i>
                        </label>
                    </div>
                    <div class="app-title-list">
                        <div class="app-tile-contact">
                            <i class="fas fa-phone"></i>
                            <span><span class="text-1">Hotline</span>: 1900 6401</span>
                        </div>
                        <div class="app-tile-contact">
                            <i class="far fa-comments"></i>
                            <span>Hỗ trỡ trực tuyến</span>
                        </div>
                    </div>
                </div>
            </div>
    
                     