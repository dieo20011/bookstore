<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th class="sortKey" column="MaSP" byOder="{{$data['byOrder']}}" >Mã sách </th>
      <th class="sortKey" column="TenSP" byOder="{{$data['byOrder']}}" >Tên sách</th>
      <th class="sortKey" column="img" byOder="{{$data['byOrder']}}" >Hình ảnh</th>
      <th class="sortKey" column="DonGia" byOder="{{$data['byOrder']}}" >Đơn giá</th>
      <th class="sortKey" column="SoLuong" byOder="{{$data['byOrder']}}" >Số lượng</th>
      <th class="sortKey" column="TTKM" byOder="{{$data['byOrder']}}" >Tình trạng KM</th>
      <th class="sortKey" column="TTSach" byOder="{{$data['byOrder']}}" >Tình trạng hiển thị</th>
      <th class="sortKey" column="MoTa" byOder="{{$data['byOrder']}}" >Mô tả</th>

      <th>EDIT </th>
      <th>DELETE </th>
    </tr>
  </thead>
  <tbody>
  <?php
    foreach ($data['product'] as $key => $value) {
      ?>
    <tr>
      <td id="ID">  <?php echo $value['MaSP']?> </td>
      <td>  <?php echo $value['TenSP']?></td>
      <td><img style="width:100px; height: 100px" src="{{ asset('img/product/'.$value['img']) }}" alt=""></td>
      <td><?php echo $value['DonGia']?></td>
      <td><?php echo $value['SoLuong']?></td>
      <td><?php echo $value['TTKM']?></td>
      <td><?php echo $value['TTSach']?></td>
      <td><?php echo $value['MoTa']?></td>

      <td>
          <form action="{{route('product.show', ['id'=> $value['MaSP']]) }}" method="POST">
            @csrf
              <input type="hidden" name="id" value="<?php echo $value['MaSP']?>">
              <input type="hidden" name="page" value="<?php echo $data['pageCurrent']?>">
              <button  type="submit" name="edit_btn" class="btn btn-success"> EDIT</button>
          </form>
      </td>
      <td>
            <input type="hidden" name="page" id="page" value="<?php echo $data['pageCurrent']?>"> 
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