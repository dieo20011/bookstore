

@extends('admin.home.master')
@section('content')
<form action="{{ route('promotion.store') }}" method="POST" enctype="multipart/form-data" id="promotion_form">
@csrf
<div class="modal-body">

        <div class="form-group">
            <label> Tên CTKM </label>
            <input type="text" name="TenCTKM" class="form-control" rules="required"  placeholder="Tên CTKM" value="">
            <span class="errMassage"></span>
        </div>
      
        <div  class="form-group">
         <label for="myDate2">Từ </label>
         <input type="date" id="myDate2" class="form-control col-md-6"
             min="2018-05-01" max="2050-12-31" value="" rules="required"  name="NgayBatDau">
             <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label for="myDate2">Đến </label>
            <input type="date" id="myDate3" class="form-control col-md-6"
            min="2018-05-01" max="2050-12-31" value="" rules="required"  name="NgayKetThuc">
            <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label> Phần trăm khuyến mãi </label>
            <input type="text" name="PhanTram" class="form-control" rules="required" placeholder="Phần trăm CTKM" value="">
            <span class="errMassage"></span>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" value="1" name="TinhTrang" type="checkbox" id="flexSwitchCheckChecked">
            <label class="form-check-label" for="flexSwitchCheckChecked">Kích hoạt CTKM</label>
        </div>
</div>
<div class="modal-footer">
    <a class="btn btn-dark" href="{{ route('promotion.index') }}" role="button">Back</a>
    <button type="submit" name="add-btn" class="btn btn-primary add-btn">Add</button>
</div>
</form>
@endsection