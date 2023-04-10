@extends('admin.home.master')
@section('content')
<form action="{{ route('promotion.index')}}" method="POST">
    @csrf
    <div class="modal-body">
            <button type="submit" name="registerbtn" class="btn btn-dark">Back To List</button>
            <!-- <a class="btn btn-dark" href="?controller=publisher&action=index" role="button">Back</a> -->
    </div>
</form>

<form action="{{ route('promotion.update')}}" method="POST" enctype="multipart/form-data" id="promotion_form_show">
@csrf
    <div class="modal-body">

        <div class="form-group">
            <label> Tên CTKM </label>
            <input type="text" name="TenCTKM" class="form-control" rules="required" placeholder="Tên CTKM" value="<?php echo $data['promotion']['TenCTKM']?>">
            <span class="errMassage"></span>
        </div>

        <div  class="form-group">
         <label for="myDate2">Từ </label>
         <input type="date" id="myDate2" class="form-control col-md-6"
             min="2018-05-01" max="2050-12-31" value="<?php echo $data['promotion']['NgayBatDau']?>"  rules="required" name="NgayBatDau">
             <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label for="myDate2">Đến </label>
            <input type="date" id="myDate3" class="form-control col-md-6"
            min="2018-05-01" max="2050-12-31" value="<?php echo $data['promotion']['NgayKetThuc']?>" rules="required" name="NgayKetThuc">
            <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label> Phần trăm khuyến mãi </label>
            <input type="text" name="PhanTram" class="form-control" rules="required" placeholder="Tên CTKM" value="<?php echo $data['promotion']['PhanTram']?>">
            <span class="errMassage"></span>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" name="TinhTrang" value="1" type="checkbox" id="flexSwitchCheckChecked" <?php if($data['promotion']['TinhTrang']==1) {
                echo 'checked';
            } ?>>
            <label class="form-check-label" for="flexSwitchCheckChecked">Kích hoạt CTKM</label>
        </div>
        <!-- Group điều hướng  -->
    </div>
    <div class="modal-footer">
        
        <button type="submit"  class="btn btn-primary">Save</button>
    </div>
</form>
@endsection