<form >
    <div class="form-address">
        <div class="group-input input-grroup">
            <label for=""> <span>Họ và tên</span> </label>
            <input type="text" name="name" rules="required" placeholder="Họ và tên" value="<?php if(isset($data['userInfo'])){echo trim($data['userInfo']['TenKH'], " ");}?>">
            <span class="errMassage"></span>
        </div>
        <div class="group-input input-grroup" id="address-form">
            <label for=""> <span>điện thoại</span></label>
            <input rules="required" type="number" placeholder="" name="phone" value="<?php if(isset($data['arr-info'])){echo trim($data['arr-info'][7], " ");}?>">
            <span class="errMassage"></span>
        </div>
        <div class="group-input input-grroup">
            <label for=""> <span>Quốc gia</span> </label>
            <input rules="required" type="text" placeholder="" name="nation" value="<?php if(isset($data['arr-info'])){echo $data['arr-info'][6];}?>">
            <span class="errMassage"></span>
        </div>
        <div class="group-input input-grroup">
            <label for=""> <span>Tỉnh thành</span> </label>
            <input rules="required" type="text" placeholder="" name="province" value="<?php if(isset($data['arr-info'])){echo $data['arr-info'][5];}?>">
            <span class="errMassage"></span>
        </div>
        <div class="group-input input-grroup">
            <label for=""> <span>Quận huyện</span> </label>
            <input rules="required" type="text" placeholder="" name="district"value="<?php if(isset($data['arr-info'])){echo $data['arr-info'][4];}?>">
            <span class="errMassage"></span>
        </div>
        <div class="group-input input-grroup">
            <label for=""> <span>Phường xã</span> </label>
            <input rules="required" type="text" placeholder="" name="Wards"value="<?php if(isset($data['arr-info'])){echo $data['arr-info'][3];}?>">
            <span class="errMassage"></span>
        </div>
        <div class="group-input input-grroup">
            <label for=""> <span>Tên tòa Nhà</span> </label>
            <input rules="required" type="text" placeholder="" name="houseName"value="<?php if(isset($data['arr-info'])){echo $data['arr-info'][1];}?>">
            <span class="errMassage"></span>
        </div>
        <div class="group-input input-grroup">
            <label for=""> <span>Số nhà</span> </label>
            <input rules="required" type="text" placeholder="" name="hosueNumber"value="<?php if(isset($data['arr-info'])){echo $data['arr-info'][0];}?>">
            <span class="errMassage"></span>
        </div>
        <div class="group-input input-grroup">
            <label for=""> <span>Đường</span> </label>
            <input rules="required" type="text" placeholder="" name="way"value="<?php if(isset($data['arr-info'])){echo $data['arr-info'][2];}?>">
            <span class="errMassage"></span>
        </div>
        <div class="group-btn" >
            <div class="btn-address" id="btn-address" >Lưu</div>
            <button class=" btn-address-disiabled" >Hủy bỏ</button>
        </div>
    </div>
    <input type="text" hidden name="id" value="<?php echo $data['userInfo']['MaKH']?>">

</form>
<script>
      //update address
      $("#btn-address").on("click", function () {
        $phone = $("input[name='phone']").val();
        $nation = $("input[name='nation']").val();
        $province = $("input[name='province']").val();
        $district = $("input[name='district']").val();
        $Wards = $("input[name='Wards']").val();
        $houseName = $("input[name='houseName']").val();
        $houseNumber = $("input[name='hosueNumber']").val();
        $way = $("input[name='way']").val();
        $id = $("input[name='id']").val();
        $.ajax({
            url: "/User/update",
            method: "POST",
            data: {
                phone: $phone,
                nation: $nation,
                province: $province,
                district: $district,
                Wards: $Wards,
                houseName: $houseName,
                hosueNumber: $houseNumber,
                way: $way,
                id: $id,
            },
            success: function (data) {
                $('#voucher').attr("disabled", false);
                $(".address").html(data);
            },
        });
    });
</script>