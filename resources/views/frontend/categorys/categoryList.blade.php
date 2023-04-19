<div class="app-containt-top-category">
    <ul class="category-list">
        <?php
        if(isset($data['menus'])) {
        foreach($data['menus'] as $key => $val) {
            ?>
            <li class="category-item">
            <a href="" class="link-level-0">
            <?php
                echo $val['TenDM'];
            ?>
            </a>
            <i class="fas fa-chevron-right"></i>
            @php
                $img = "img/menu/".$val['img'];
            @endphp
            <div class="sub-menu-content" style="background: url({{asset($img)}}) white no-repeat bottom right;">
                <div class="sub-menu-wrap">
                    <div class="sub-category">
                        <h3>Danh mục sách</h3>
                        <ul class="sub-category-list">
                            <?php
                            foreach($data['categorys'][$key] as $k => $value) {
                            ?>
                            <li class="sub-categor-item">
                            <a href="/searchByMenu?MaTL={{$value['MaTL']}}"><?php echo $value['TenTheLoai'] ?></a>
                            </li>
                            <?php
                            }
                            ?>
                        </ul>
                        <?php
                        ?>
                    </div>
                    <div class="sub-author">
                        <h3>Tác Giả</h3>
                        <ul class="sub-author-list">
                        <?php
                            foreach($data['authors'][$key] as $k => $value) {
                            ?>
                            <li class="sub-author-item">
                                <a href="/searchByMenu?MaTG={{$value['MaTG']}}"><?php echo $value['TenTG'] ?></a>
                            </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="sub-publisher">
                        <h3>Nhà phát hành</h3>
                        <ul class="sub-publisher-list">
                        <?php
                            foreach($data['publlisher'][$key] as $k => $value) {
                            ?>
                            <li class="sub-publisher-item">
                                <a href="/searchByMenu?MaNXB={{$value['MaNXB']}}"><?php echo $value['TenNXB'] ?></a>
                            </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </li>
            <?php
        }
        }
        ?>
    </ul>
</div>