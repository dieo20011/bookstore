@extends('admin.home.master')
@section('content')
<form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data" id="import_form">
    @csrf
<div class="modal-body">
        <div  class="form-group">
         <label for="myDate2">Từ </label>
         <input type="date" id="myDate2" class="form-control col-md-6"
             min="2018-05-01" max="2050-12-31" value="" rules="required" name="NgayNhap">
        <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Danh sách sách</label>
            <select name="MaSP" id="MaSP"  class="form-control" id="exampleFormControlSelect1">
                <?php foreach($data['product'] as $key => $value) {?>
                <option value="<?php echo $value['MaSP'] ?>"> 
                <?php echo $value['TenSP'] ?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Danh sách nhà cung cấp</label>
            <select name="MaNCC" id="MaNCC"  class="form-control" id="exampleFormControlSelect1">
                <?php foreach($data['supplisher'] as $key => $value) {?>
                <option value="<?php echo $value['MaNCC'] ?>"> 
                <?php echo $value['TenNCC'] ?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label> Số lượng sách </label>
            <input id="mount" type="number" name="SoLuong" rules="required|numberCheck" class="form-control" placeholder="Số lượng sách" value="1" >
            <span class="errMassage"></span>
            
        </div>
        <div class="form-group">
            <label> Đơn giá sách</label>
            <input type="number" id="price" name="DonGia" rules="required|numberCheck" class="form-control" placeholder="Đơn giá sách" value="0" >
            <span class="errMassage"></span>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" value="1" name="status" type="checkbox" id="flexSwitchCheckChecked">
            <label class="form-check-label" for="flexSwitchCheckChecked">Đã nhập</label>
        </div>
</div>
<div class="modal-footer d-flex justify-content-between">
    <div>
        <div  name="add_temp" id="add_temp" class="btn btn-success">Import</div>
    </div>
    <div>
        <a class="btn btn-dark" href="{{ route('import.index') }}" role="button">Back</a>
        <button type="submit" name="add-btn" class="btn btn-primary add-btn">Add</button>
    </div>
</div>
</form>

<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th>Mã sách </th>
      <th>Tên sách</th>
      <th>Đơn giá</th>
      <th>Số lượng</th>
    </tr>
  </thead>
  <tbody id="loadImportDetail">
    </tbody>
</table>
@endsection
