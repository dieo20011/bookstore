@extends('admin.home.master')
@section('content')
<form action="{{ route('menu.index') }}" method="POST">
    @csrf
    <div class="modal-body">
            <input type="text" hidden name="controller" value="menu">
            <input type="text" hidden name="action" value="index">
            <button type="submit" name="registerbtn" class="btn btn-dark">Back To List</button>
    </div>
</form>
<form action="{{ route('menu.update') }}" method="POST" enctype="multipart/form-data" id="menu_form_show">
    @csrf
    <div class="modal-body">

        <div class="form-group">
            <label> Tên danh mục </label>
            <input type="text" name="TenDM" class="form-control" rules="required" placeholder="Tên danh mục" value="{{old('name')  ?? $data['menu']['TenDM'] }}">
            <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label> Ảnh bìa danh mục </label>
            <input type="file" name="img" class="form-control" placeholder="Ảnh bìa danh mục" value="<?php echo $data['menu']['img']?>">
            <span class="errMassage"></span>
        </div>
        {{-- <input type="text" hidden name="controller" value="menu">
        <input type="text" hidden name="action" value="update"> --}}
    </div>
    <div class="modal-footer">
        <button type="submit"  class="btn btn-primary">Save</button>
    </div>
</form>
@endsection
