
@extends('admin.home.master')
@section('content')
<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" id="product_form">
@csrf
<div class="modal-body">

<div class="form-group">
            <label> Tên sách </label>
            <input type="text" name="TenSP" class="form-control" rules="required" placeholder="Tên sách" value="">
            <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label> Ảnh</label>
            <input type="file" name="img" class="form-control" rules="required" placeholder="Ảnh" value="">
            <span class="errMassage"></span>
        </div>

        <div class="form-group">
            <label> Số lượng sách </label>
            <input type="text" name="SoLuong" class="form-control" rules="required" placeholder="Số lượng sách" value="0" readonly>
        </div>
        <div class="form-group">
            <label> Đơn giá sách </label>
            <input type="number" name="DonGia" class="form-control" rules="required" placeholder="Đơn giá" value="">
            <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Mô tả sách</label>
            <textarea class="form-control" rules="required" name="MoTa"  id="exampleFormControlTextarea1" rows="3"></textarea>
            <span class="errMassage"></span>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" name="TTKM" value="1" type="checkbox" id="flexSwitchCheckChecked" >
            <label class="form-check-label" for="flexSwitchCheckChecked">Kích hoạt CTKM</label>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" name="TTSach" value="1" type="checkbox" id="flexSwitchCheckChecked">
            <label class="form-check-label" for="flexSwitchCheckChecked">Kích hoạt tình trạng sách</label>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Danh sách danh mục</label>
            <select name="MaDM"  class="form-control" rules="required" id="selectMenu">
                <?php foreach($data['menu'] as $key => $value) {?>
                <option value="<?php echo $value['MaDM'] ?>" > 
                
                <?php echo $value['TenDM'] ?></option>
                <?php }?>
            </select>
            <span class="errMassage"></span>

        </div>
        <div id="selectGroup">
            @include('admin.product.select')
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Danh sách chương trình khuyến mãi</label>
            <select name="MaKM"  class="form-control" rules="required" id="exampleFormControlSelect1">
                <?php foreach($data['promotion'] as $key => $value) {?>
                <option value="<?php echo $value['MaKM'] ?>"> 
                
                <?php echo $value['TenCTKM'] ?></option>
                <?php }?>
            </select>
            <span class="errMassage"></span>

        </div>
</div>
<div class="modal-footer">
    <a class="btn btn-dark" href="{{ route('product.index') }}" role="button">Back</a>
    <button type="submit"  class="btn btn-primary add-btn">Add</button>
</div>
</form>
@endsection
