@extends('admin.home.master')
@section('content')
<form action="{{ route('supplier.store') }}" method="POST" enctype="multipart/form-data" id="supplisher_form">
@csrf
<div class="modal-body">

    <div class="form-group">
        <label> Tên nhà cung cấp</label>
        <input type="text" name="TenNCC" class="form-control" rules="required" placeholder="Tên nhà cung cấp" value="">
        <span class="errMassage"></span>
    </div>
    
</div>
<div class="modal-footer">
    <a class="btn btn-dark" href="{{ route('supplier.index') }}" role="button">Back</a>
    <button type="submit" class="btn btn-primary add-btn">Add</button>
</div>
</form>
@endsection