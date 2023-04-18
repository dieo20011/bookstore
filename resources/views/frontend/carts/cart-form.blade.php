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

<!-- Script for cart -->
<script>
    $(document).ready(function () {
    $("#close").on("click", function () {
        $(".modal").css("display", "none");
    });
    $(".des.btn-id").on("click", function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $parent = $(this).closest(".product-edit");
        $id = $parent
            .children("input")
            .map(function () {
                return $(this).val();
            })
            .get();

        $.ajax({
            url: "/Cart/update",
            method: "POST",
            data: { MaSP: $id[0], option: "des" },
            success: function (data) {
                $(".cart-body-contain").html(data);
            },
        });
    });
    $(".inc.btn-id").on("click", function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $parent = $(this).closest(".product-edit");
        $id = $parent
            .children("input")
            .map(function () {
                return $(this).val();
            })
            .get();

        $.ajax({
            url: "/Cart/update",
            method: "POST",
            data: { MaSP: $id[0], option: "inc" },
            success: function (data) {
                $(".cart-body-contain").html(data);
            },
        });
    });

    $("i.fas.fa-trash-alt").on("click", function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $parent = $(this).closest(".product-right");
        $id = $parent
            .children("input")
            .map(function () {
                return $(this).val();
            })
            .get();
        $.ajax({
            url: "/Cart/delete",
            method: "POST",
            data: { MaSP: $id[0], option: "car-form" },
            success: function (data) {
                $(".cart-body-contain").html(data);
            },
        });
    });
});
</script>