<?php
    $total = 0;
    $count = 0;
    foreach($data['productTemp'] as $key => $val) {    
        $total += $data['productTemp'][$key]['SoLuong'] * $data['productTemp'][$key]['DonGia'];
        $count +=$data['productTemp'][$key]['SoLuong'];
        ?>
    <div class="group-item">
        <div class="product-left">
            <div class="prodcut-img">
                @php
                $img = "img/product/".$data['productTemp'][$key]['img']
                @endphp
                <img style="width:100px; height:100px; margin: 0 0 0 20px" src="{{asset($img)}}" alt="">
            </div>
            <div class="product-decritption">
                <div class="produc-name">
                <?php echo $data['productTemp'][$key]['TenSp'];
                 ?>
                </div>
                <div class="product-edit">
                    <input type="text" hidden name="idsach" value="<?php echo $data['productTemp'][$key]['MaSP']?>">
                    <input type="text" hidden class="MaHD" name="MaHD" value="<?php echo $data['productTemp'][$key]['MaHD']?>">
                    <input type="text" hidden class="mount" name="mount" value="<?php echo $data['productTemp'][$key]['SoLuong']?>">

                    <?php if($data['productTemp'][$key]['TinhTrang'] == 0) {?> 
                    <div class="des btn-id">
                        -
                    </div>
                    <?php }?>
                    <div class="input-num ">
                        <input type="text"  readonly class="btn-id mount" value="<?php echo $data['productTemp'][$key]['SoLuong']?>">
                    </div>
                    <?php if($data['productTemp'][$key]['TinhTrang'] == 0) {?> 
                    <div class="inc btn-id">
                        +
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="product-right">
             <input type="text" hidden name="idsach" value="<?php echo $data['productTemp'][$key]['MaSP']?>">
             <input type="text" hidden class="MaHD" name="MaHD" value="<?php echo $data['productTemp'][$key]['MaHD']?>">
            <input type="text" hidden class="mount" name="mount" value="<?php echo $data['productTemp'][$key]['SoLuong']?>">
            <span> <?php echo $data['productTemp'][$key]['SoLuong']?> x <?php echo currency_format($data['productTemp'][$key]['DonGia'])?><span class="undertext">đ</span> </span>
            <?php if($data['productTemp'][$key]['TinhTrang'] == 0) {?>  <i class="fas fa-trash-alt" style="cursor: pointer"></i> <?php }?>
        </div>
    </div>
<?php }?>
<script>    
    $(".inc.btn-id").on("click", function () {
        $parent = $(this).closest(".product-edit");
        $id = $parent
            .children("input")
            .map(function () {
                return $(this).val();
            })
            .get();
        $idhd = $parent
            .children("input.MaHD")
            .map(function () {
                return $(this).val();
            })
            .get();
        $.ajax({
            url: "/Bill/updateDetailBillForUser",
            method: "POST",
            data: {
                MaSP: $id[0],
                option: "inc",
                MaHD: $idhd[0],
            },
            success: function (data) {
                $(".bill-container").html(data);
            },
        });
    });

    $(".des.btn-id").on("click", function () {
        $parent = $(this).closest(".product-edit");
        $id = $parent
            .children("input")
            .map(function () {
                return $(this).val();
            })
            .get();

        $idhd = $parent
            .children("input.MaHD")
            .map(function () {
                return $(this).val();
            })
            .get();
        $.ajax({
            url: "/Bill/updateDetailBillForUser",
            method: "POST",
            data: {
                MaSP: $id[0],
                option: "des",
                MaHD: $idhd[0],
            },
            success: function (data) {
                $(".bill-container").html(data);
            },
        });
    });
    $("i.fas.fa-trash-alt").on("click", function () {
        $parent = $(this).closest(".product-right");
        $id = $parent
            .children("input")
            .map(function () {
                return $(this).val();
            })
            .get();
        $idhd = $parent
            .children("input.MaHD")
            .map(function () {
                return $(this).val();
            })
            .get();
        $mount = $parent
            .children("input.mount")
            .map(function () {
                return $(this).val();
            })
            .get();
        $.ajax({
            url: "/Bill/deleteDetailBillForUser",
            method: "POST",
            data: {
                MaSP: $id[0],
                option: "delete",
                mount: $mount[0],
                MaHD: $idhd[0],
            },
            success: function (data) {
                $(".bill-container").html(data);
            },
        });
    });
</script>