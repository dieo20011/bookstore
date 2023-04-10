@extends('admin.home.master')
@section('content')
<form action="{{ route('author.index') }}" method="POST">
    @csrf
    <div class="modal-body">
            <button type="submit" name="registerbtn" class="btn btn-dark">Back To List</button>
    </div>
</form>
<form action="{{ route('author.update') }}" method="POST" enctype="multipart/form-data" id="author_form_show">
@csrf
    <div class="modal-body">
        <div class="form-group">
            <label> Tên tác giả </label>
            <input type="text" name="TenTG" class="form-control" rules="required" placeholder="Tên tác giả" value="<?php echo $data['author']['TenTG']?>">
            <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label> Ảnh bìa tác giả </label>
            <input type="file" name="img" class="form-control"   placeholder="Ảnh bìa tác giả" value="<?php echo $data['author']['img']?>">
            <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Danh sách danh mục</label>
            <select name="MaDM"  class="form-control" rules="required" id="exampleFormControlSelect1">
                <?php foreach($data['menu'] as $key => $value) {?>
                    <option value="<?php echo $value['MaDM'] ?>" <?php if($data['author']['MaDM'] == $value['MaDM'])
                    echo "selected";
                    ?> > 
                
                <?php echo $value['TenDM'] ?></option>
                <?php }?>
            </select>
            <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Mô tả tác giả</label>
            <textarea class="form-control" name="MoTa" rules="required"  id="exampleFormControlTextarea1" rows="3"><?php echo $data['author']['MoTa']?></textarea>
            <span class="errMassage"></span>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit"  class="btn btn-primary">Save</button>
    </div>
</form>
@endsection
