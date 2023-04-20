
  <?php
    if(isset($data['productTemp'])) {
    foreach ($data['productTemp'] as $key => $value) {
      ?>
    <tr>
      <td id="ID">  <?php echo $value['MaSP']?> </td>
      <td>  <?php echo $value['TenSp']?></td>
      <td><?php echo $value['DonGia']?></td>
      <td><?php echo $value['SoLuong']?></td>
      <td>
          <form action="./index.php" method="POST">
              <input type="hidden" name="id" id="IDHD" value="<?php echo $value['MaHD']?>">
              {{-- <div  name="edit_btn" id="edit_btn_bill" class="btn btn-success"> EDIT</div> --}}
          </form>
      </td>
    </tr>
    <?php
    }
}
    ?>
<div id="formEditDetailBill">

</div>