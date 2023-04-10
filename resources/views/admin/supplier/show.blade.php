@extends('admin.home.master')
@section('content')
<form action="{{ route('supplier.index')}}" method="POST">
    @csrf
    <div class="modal-body">
            <button type="submit" name="registerbtn" class="btn btn-dark">Back To List</button>
    </div>
</form>

<form action="{{ route('supplier.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">

        <div class="form-group">
            <label> Tên nhà xuất bản </label>
            <input type="text" name="TenNCC" class="form-control" placeholder="Tên nhà xuất bản" value="<?php echo $data['supplier']['TenNCC']?>">
        </div>

        <!-- Group điều hướng  -->
    </div>
    <div class="modal-footer">
        
        <button type="submit"  class="btn btn-primary">Save</button>
    </div>
</form>
@endsection