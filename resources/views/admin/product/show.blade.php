@extends('admin.home.master')
@section('content')
<form action="{{ route('product.index') }}" method="POST">
    @csrf
    <div class="modal-body">
            <button type="submit" name="registerbtn" class="btn btn-dark">Back To List</button>
            <!-- <a class="btn btn-dark" href="?controller=publisher&action=index" role="button">Back</a> -->
    </div>
</form>
<form action="{{ route('product.update') }}" method="POST" enctype="multipart/form-data" id="product_form_show">
@csrf
    <div class="modal-body">

        <div class="form-group">
            <label> Tên sách </label>
            <input type="text" name="TenSP" class="form-control" rules="required" placeholder="Tên sách" value="<?php echo $data['product']['TenSP']?>">
            <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label> Ảnh</label>
            <input type="file" name="img" class="form-control" placeholder="Ảnh" value="<?php echo $data['product']['img']?>">
            <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label> Số lượng sách </label>
            <input type="text" name="SoLuong" class="form-control" rules="required" readonly placeholder="Số lượng sách" value="<?php echo $data['product']['SoLuong']?>">
            <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label> Đơn giá sách </label>
            <input type="number" name="DonGia" class="form-control" rules="required" placeholder="Đơn giá" value="<?php echo $data['product']['DonGia']?>">
            <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Mô tả sách</label>
            <textarea class="form-control" rules="required" name="MoTa"  id="exampleFormControlTextarea1" rows="3"><?php echo $data['product']['MoTa']?></textarea>
            <span class="errMassage"></span>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" name="TTKM" value="1" type="checkbox" id="flexSwitchCheckChecked" <?php if($data['product']['TTKM']==1) {
                echo 'checked';
            } ?>>
            <label class="form-check-label" for="flexSwitchCheckChecked">Kích hoạt CTKM</label>
            <span class="errMassage"></span>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" name="TTSach" value="1" type="checkbox" id="flexSwitchCheckChecked" <?php if($data['product']['TTSach']==1) {
                echo 'checked';
            } ?>>
            <label class="form-check-label" for="flexSwitchCheckChecked">Kích hoạt tình trạng sách</label>
            <span class="errMassage"></span>
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
                <option value="<?php echo $value['MaKM'] ?>" <?php if($data['product']['MaKM'] == $value['MaKM'])
                    echo "selected";
                ?> > 
                
                <?php echo $value['TenCTKM'] ?></option>
                <?php }?>
            </select>
            <span class="errMassage"></span>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
@endsection