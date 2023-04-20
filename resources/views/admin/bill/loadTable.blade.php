<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th>Mã hóa đơn </th>
      <th>Ngày tạo</th>
      <th>Tổng tiền</th>
      <th>Tình trạng</th>
      <th>Xem chi tiết hóa đơn</th>
      <th>EDIT </th>
      <th>DELETE </th>
    </tr>
  </thead>
  <tbody>
  <?php
    foreach ($data['bill'] as $key => $value) {
      ?>
    <tr>
      <td id="ID">  <?php echo $value['MaHD']?> </td>
      <td>  <?php echo $value['NgayTao']?></td>
      <td>  <?php echo $value['TongTien']?></td>
      <td>  
        <?php
        if($value['TinhTrang'] == 0 ) {
            echo "Đang chờ xử lý";
        } else if($value['TinhTrang'] == 1) {
            echo "Đã xử lý";
        } else if ($value['TinhTrang'] == 2) {
            echo "Đang giao";
        } else  {
            echo "Đã giao";
        }
         ?>
    </td>
      <td> <div name="billDetail" id="billDetail" class="btn btn-link"> Xem chi tiết</div></td>
      <td>
          <form action="{{route('bill.show', ['id'=> $value['MaHD']]) }}" method="POST">
            @csrf
              <input type="hidden" name="page"  value="<?php echo $data['pageCurrent']?>">
              <button  type="submit" name="edit_btn" class="btn btn-success"> EDIT</button>
          </form>
      </td>
      <!-- <td>
            <input type="hidden" name="page" id="page" value="<?php echo $data['pageCurrent']?>">
            <input type="hidden" name="delete_id" value="">
            <button  name="delete_btn" class="btn btn-danger deleteBtn"> DELETE</button>
      </td> -->
      <td>

      </td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>
@include('admin.includes.formDelete')
<script src="{{asset('js/main.js/admin.js')}}"></script>