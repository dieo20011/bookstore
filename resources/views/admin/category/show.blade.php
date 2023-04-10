@extends('admin.home.master')
@section('content')
<form action="{{ route('category.index') }}" method="POST">
    @csrf
    <div class="modal-body">
            <input type="text" hidden name="controller" value="category">
            <input type="text" hidden name="action" value="index">
            <button type="submit" name="registerbtn" class="btn btn-dark">Back To List</button>
    </div>
</form>
<form action="{{ route('category.update') }}" method="POST" enctype="multipart/form-data" id="category_form_show">
    @csrf
    <div class="modal-body">

        <div class="form-group">
            <label> Tên thể loại </label>
            <input type="text" name="TenTheLoai" class="form-control" rules="required" placeholder="Tên thể loại" value="<?php echo $data['category']['TenTheLoai']?>">
            <span class="errMassage"></span>

        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Danh sách danh mục</label>
            <select name="MaDM"  class="form-control" rules="required" id="exampleFormControlSelect1">
                <?php foreach($data['menu'] as $key => $value) {?>
                <option value="<?php echo $value['MaDM'] ?>" <?php if($data['category']['MaDM'] == $value['MaDM'])
                    echo "selected";
                ?>><?php echo $value['TenDM'] ?></option>
                <?php }?>
            </select>
            <span class="errMassage"></span>

    </div>
    </div>
    <div class="modal-footer">
        <button type="submit"  class="btn btn-primary">Save</button>
    </div>
</form>
@endsection
