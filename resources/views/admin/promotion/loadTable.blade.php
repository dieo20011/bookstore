<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th class="sortKey" column="MaKM" byOder="{{$data['byOrder']}}">Mã CTKM </th>
      <th class="sortKey" column="TenCTKM" byOder="{{$data['byOrder']}}">Tên CTKM</th>
      <th class="sortKey" column="NgayBatDau" byOder="{{$data['byOrder']}}">Ngày bắt đầu</th>
      <th class="sortKey" column="NgayKetThuc" byOder="{{$data['byOrder']}}">Ngày kết thúc</th>
      <th class="sortKey" column="TinhTrang" byOder="{{$data['byOrder']}}">Tình trạng</th>
      <th class="sortKey" column="PhanTram" byOder="{{$data['byOrder']}}">Phần trăm</th>
      <th>EDIT </th>
      <th>DELETE </th>
    </tr>
  </thead>
  <tbody>
  <?php
    foreach ($data['promotion'] as $key => $value) {
      ?>
    <tr>
      <td id="ID">  <?php echo $value['MaKM']?> </td>
      <td>  <?php echo $value['TenCTKM']?></td>
      <td>  <?php echo $value['NgayBatDau']?></td>
      <td>  <?php echo $value['NgayKetThuc']?></td>
      <td>  <?php if($value['TinhTrang']==1) {echo 'Đã kích hoạt';} else { echo "Đã hủy";}?></td>
      <td>  <?php echo $value['PhanTram']?></td>
      <td>
          <form action="{{route('promotion.show', ['id'=> $value['MaKM']]) }}" method="POST">
            @csrf
              <input type="hidden" name="id" value="<?php echo $value['MaKM']?>">
              <button  type="submit" name="edit_btn" class="btn btn-success"> EDIT</button>
          </form>
      </td>
      <td>
            <input type="hidden" name="delete_id" value="">
            <button  name="delete_btn" class="btn btn-danger deleteBtn"> DELETE</button>
      </td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>
@include('admin.includes.formDelete')
<script src="{{asset('js/main.js/admin.js')}}"></script>