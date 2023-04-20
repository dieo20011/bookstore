<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th>Mã Khách hàng </th>
      <th>Tên khách hàng</th>
      <th>Email khách hàng</th>
      
      <th>EDIT </th>
      <th>DELETE </th>
    </tr>
  </thead>
  <tbody>
  <?php
    foreach ($data['user'] as $key => $value) {
      ?>
    <tr>
      <td id="ID">  <?php echo $value['MaKH']?> </td>
      <td>  <?php echo $value['TenKH']?></td>
      <td>  <?php echo $value['Email']?></td>
      <td>
          <form action="./index.php" method="POST">
              <input type="hidden" name="controller" value="user">
              <input type="hidden" name="action" value="show">
              <input type="hidden" name="id" value="<?php echo $value['MaKH']?>">
              <input type="hidden" name="page"  value="<?php echo $data['pageCurrent']?>">
              <button  type="submit" name="edit_btn"  disabled class="btn btn-success"> EDIT</button>
          </form>
      </td>
      <td>
            <input type="hidden" name="page" id="page" value="<?php echo $data['pageCurrent']?>">
            <input type="hidden" name="delete_id" value="">
            <button  name="delete_btn" class="btn btn-danger deleteBtn" disabled> DELETE</button>
      </td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>
@include('admin.includes.formDelete')
<script src="{{asset('js/main.js/admin.js')}}"></script>