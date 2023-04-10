@extends('admin.home.master')
@section('content')
<form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" id="menu_form">
@csrf
<div class="modal-body">

    <div class="form-group">
        <label> Tên danh mục </label>
        <input type="text" name="TenDM" class="form-control" rules="required" placeholder="Tên danh mục" value="">
        <span class="errMassage"></span>
    </div>
    <div class="form-group">
        <label> Ảnh bìa danh mục </label>
        <input type="file" name="img" class="form-control" rules="required" placeholder="Ảnh bìa danh mục" value="">
        <span class="errMassage"></span>
    </div>
</div>
<div class="modal-footer">
    <a class="btn btn-dark" href="{{ route('menu.index') }}" role="button">Back</a>
    <button type="submit"  class="btn btn-primary add-btn">Add</button>
</div>
</form>
@endsection