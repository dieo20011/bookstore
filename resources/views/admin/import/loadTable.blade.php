<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th class="sortKey" column="MaPN" byOder="{{$data['byOrder']}}">Mã Phiếu nhập </th>
      <th class="sortKey" column="NgayNhap" byOder="{{$data['byOrder']}}" >Ngày Nhập</th>
      <th class="sortKey" column="TinhTrang" byOder="{{$data['byOrder']}}" >Tình trạng</th>
      <th class="sortKey" column="TongTien" byOder="{{$data['byOrder']}}" >Tổng tiền</th>
      <th>Xem chi tiết phiếu nhập</th>
      <th>EDIT </th>
      <th>DELETE </th>
    </tr>
  </thead>
  <tbody>
  <?php
    foreach ($data['import'] as $key => $value) {
      ?>
    <tr>
      <td id="ID">  <?php echo $value['MaPN']?> </td>
      <td>  <?php echo $value['NgayNhap']?></td>
      <td>  <?php if($value['TinhTrang']==1) {echo 'Đã nhập';} else { echo "Chưa nhập";}?></td>
      <td>  <?php echo $value['TongTien']?></td>
      <td> <div name="importDetail" id="importDetail" class="btn btn-link"> Xem chi tiết</div></td>
      <td>
      <?php if($value['TinhTrang']!=1) {?>
          <form action="{{route('import.show', ['id'=> $value['MaPN']]) }}" method="POST">
            @csrf
              <input type="hidden" name="page"  value="<?php echo $data['pageCurrent']?>">
              <button  type="submit" name="edit_btn" class="btn btn-success"> EDIT</button>
          </form>
        <?php }?>
      </td>
      <td>
      <!-- <?php if($value['TinhTrang']!=1) {?>
            <input type="hidden" name="page" id="page" value="<?php echo $data['pageCurrent']?>">
            <input type="hidden" name="delete_id" value="">
            <button  name="delete_btn" class="btn btn-danger deleteBtn"> DELETE</button>
      <?php }?> -->
      </td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>
@include('admin.includes.formDelete')
<script src="{{asset('js/main.js/admin.js')}}"></script>