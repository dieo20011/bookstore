@extends('admin.home.master')
@section('content')
<div class="alert alert-primary" role="alert">
    A simple primary alert—check it out!
</div>
<form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data" id="category_form">
@csrf
<div class="modal-body">

    <div class="form-group">
        <label> Tên thể loại</label>
        <input type="text" name="TenTheLoai" class="form-control" rules="required" placeholder="Tên thể loại" value="">
        <span class="errMassage"></span>
    </div>
    <div class="form-group">
            <label for="exampleFormControlSelect1">Danh sách danh mục</label>
            <select name="MaDM"  rules="required" class="form-control" id="exampleFormControlSelect1">
                <?php foreach($data['menu'] as $key => $value) {?>
                <option value="<?php echo $value['MaDM'] ?>"> <?php echo $value['TenDM'] ?></option>
                <?php }?>
            </select>
            <span class="errMassage"></span>
    </div>
</div>
<div class="modal-footer">
    <a class="btn btn-dark" href="{{ route('category.index') }}" role="button">Back</a>
    <button type="submit"  class="btn btn-primary add-btn">Add</button>
</div>
</form>
@endsection
