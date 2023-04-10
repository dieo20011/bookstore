<form method="POST" action="{{route('import.updateDetailImport')}}"  enctype="multipart/form-data" id="detail_import_form">
@csrf
<div class="modal-body">

        <div class="form-group">
            <label> Mã sách </label>
            <input id="name" type="text" disabled name="MaSP" rules="required" class="form-control" placeholder="Số lượng sách" value="<?php echo $data['productTemp']['MaSP'] ?>" >
            <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label> Số lượng sách </label>
            <input id="mount" type="number" name="SoLuong" rules="required|numberCheck" class="form-control" placeholder="Số lượng sách" value="<?php echo $data['productTemp']['SoLuong'] ?>" >
            <span class="errMassage"></span>
        </div>
        <div class="form-group">
            <label> Đơn giá sách</label>
            <input type="number" id="price" name="DonGia" rules="required|numberCheck" class="form-control" placeholder="Đơn giá sách" value="<?php echo $data['productTemp']['DonGia'] ?>" >
            <span class="errMassage"></span>
        </div>
    <input type="text" hidden name="MaPN" value="<?php echo $data['import']['MaPN']?>">
    <input type="text" hidden name="MaSP" value="<?php echo $data['productTemp']['MaSP']?>">

</div>
<div class="modal-footer d-flex justify-content-between">
    <div>
        <button type="submit" name="add-btn " class="btn btn-success add-btn edit-btn-import">Save</button>
    </div>
</div>
</form>