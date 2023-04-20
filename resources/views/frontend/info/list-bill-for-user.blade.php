<div class="billheader">
    <span>Đơn hàng của tôi</span>
</div>
<div class="form-search-bill">
    <div class="group-input-bill">
        <span>Thời gian</span>
        <select name="since" id="since">
            <option value="7">Tuần này</option>
            <option value="30">Tháng này</option>
            <option value="366">Năm qua</option>
        </select>
    </div>
    <div class="group-input-bill">
        <span>Chọn ngày</span>
        <input type="date" name="FromDate" id="FromDate">
        <input type="date" name="ToDate" id="ToDate">
    </div>
    {{-- <div class="group-input-bill">
        <span>Mã đơn hàng</span>
        <input type="text" name="" id="">
        
    </div> --}}

    <div class="group-btn">
        <button id="search-bill">Tìm kiếm</button>
    </div>
</div>
<div class="bill-body">
    <table>
        <th style="width: 7%">ID</th>
        <th style="width: 20%">Ngày</th>
        <th style="width: 20%">Khách hàng</th>
        <th style="width: 15%">Tổng cộng</th>
        <th style="width: 15%">Đã thanh toán</th>
        <th style="width: 15%">Trạng thái</th>
        <th style="width: 30%"> Thao tác</th>
        <?php foreach($data['bill'] as $key => $value) {?>
        <tr>
            <td id="ID"><?php echo $value['MaHD']?></td>
            <td><?php echo $value['NgayTao']?></td>
            <td><?php echo $data['userInfo']['TenKH']?></td>
            <td><?php echo currency_format($value['TongTien'])?> VNĐ</td>
            <td><?php  if($value['TinhTrang'] == 3) {
                echo "Đã thanh toán";
            } else { echo "Chưa thanh toán";}?></td>
            <td> <?php
            if($value['TinhTrang'] == 0 ) {
                echo "Đang chờ xử lý";
            } else if($value['TinhTrang'] == 1) {
                echo "Đã xử lý";
            } else if ($value['TinhTrang'] == 2) {
                echo "Đang giao";
            } else  {
                echo "Đã giao";
            }
            ?></td>
            <td class="btn-detail">Xem chi tiết</td>
        </tr>
        <?php }?>
    </table>
</div>

<div id="bill-detail">

</div>
<script>
    $(document).ready(function () {

        
    // show detail bill
    $(".btn-detail").on("click", function () {
        $tr = $(this).closest("tr");

        var id = $tr
            .children("td#ID")
            .map(function () {
                return $(this).text();
            })
            .get();
        $.ajax({
            url: "/Bill/showDetail",
            method: "POST",
            data: {
                id: id,
                option: "user",
            },
            success: function (data) {
                $(".bill-container").html(data);
            },
        });
    });
        //search for times
        $("#search-bill").on("click", function () {
            let ToDate = $("#ToDate").val();
            let FromDate = $("#FromDate").val();
            if(!ToDate|| !FromDate) {
                alert("Vui lòng chọn ngày cần tìm kiếm")
                return
            }
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                url: "/User/searchForTime",
                method: "POST",
                data: { ToDate: ToDate, FromDate: FromDate},
                success: function (data) {
                    $(".bill-container").html(data);
                    $("#ToDate").val(ToDate)
                    $("#FromDate").val(FromDate)
                },
            });
        });

        $("#since").change(function () {
            let since = $(this).val();
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                url: "/User/searchForTime",
                method: "POST",
                data: { since: since },
                success: function (data) {
                    $(".bill-container").html(data);
                $("#since").find('option[value="'+since+'"]').prop('selected', true);
                },
            });
         });
    });
    </script>