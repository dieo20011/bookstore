@extends('admin.home.master')
@section('content')
<form action="{{ route('import.update') }}" method="POST" enctype="multipart/form-data" id="import_form_show">
    @csrf
<div class="modal-body">
        <div  class="form-group">
         <label for="myDate2">Từ </label>
         <input type="date" id="myDate2" class="form-control col-md-6"
             min="2018-05-01" max="2050-12-31" value="<?php echo $data['import']['NgayNhap']?>" rules="required" name="NgayNhap">
        <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Danh sách nhà cung cấp</label>
            <select name="MaNCC" id="MaNCC"  class="form-control" id="exampleFormControlSelect1">
                <?php foreach($data['supplisher'] as $key => $value) {?>
                <option value="<?php echo $value['MaNCC'] ?>" <?php if($value['MaNCC'] == $data['import']['MaNCC'] ) echo "selected";?>> 
                <?php echo $value['TenNCC'] ?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label>Tổng tiền</label>
            <input type="number" id="price" disabled name="TongTien" class="form-control"  placeholder="Đơn giá sách" value="<?php echo $data['import']['TongTien']?>" >
            <input type="number" id="price" hidden name="TongTien" class="form-control"  placeholder="Đơn giá sách" value="<?php echo $data['import']['TongTien']?>" >
            
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" value="1" name="TinhTrang" type="checkbox" id="flexSwitchCheckChecked"<?php if($data['import']['TinhTrang']==1) {
                echo 'checked';
            } ?>>
            <label class="form-check-label" for="flexSwitchCheckChecked">Đã nhập</label>
        </div>

</div>
<div class="modal-footer d-flex justify-content-between">
    <div>
        <a class="btn btn-dark" href="{{ route('import.index') }}" role="button">Back To list</a>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
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
      <th>EDIT </th>
      {{-- <th>DELETE </th> --}}
    </tr>
  </thead>
  <tbody id="loadImportDetail">
    @include('admin.import.formDetailImport')
    </tbody>
</table>
@endsection