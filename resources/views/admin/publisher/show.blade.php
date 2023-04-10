@extends('admin.home.master')
@section('content')
<form action="{{ route('publisher.index')}}" method="POST">
    @csrf
    <div class="modal-body">
            <button type="submit" name="registerbtn" class="btn btn-dark">Back To List</button>
            <!-- <a class="btn btn-dark" href="?controller=publisher&action=index" role="button">Back</a> -->
    </div>
</form>

<form action="{{ route('publisher.update') }}" method="POST" enctype="multipart/form-data" id="publisher_form_show">
@csrf
    <div class="modal-body">

        <div class="form-group">
            <label> Tên nhà xuất bản </label>
            <input type="text" name="TenNXB" class="form-control" rules="required" placeholder="Tên nhà xuất bản" value="<?php echo $data['publisher']['TenNXB']?>">
            <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Danh sách nhà xuất bản</label>
            <select name="MaDM"  class="form-control" rules="required" id="exampleFormControlSelect1">
                <?php foreach($data['menu'] as $key => $value) {?>
                <option value="<?php echo $value['MaDM'] ?>"    <?php if($data['publisher']['MaDM'] == $value['MaDM'])
                    echo "selected";
                ?>><?php echo $value['TenDM'] ?></option>
                <?php }?>
            </select>
            <span class="errMassage"></span>
        </div>

        <!-- Group điều hướng  -->
    </div>
    <div class="modal-footer">
        
        <button type="submit"  class="btn btn-primary">Save</button>
    </div>
</form>
@endsection