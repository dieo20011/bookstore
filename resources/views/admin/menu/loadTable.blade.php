<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th class="sortKey" column="MaDM" byOder="{{$data['byOrder']}}" ><span>Mã danh mục</span></th>
      <th class="sortKey" column="TenDM" byOder="{{$data['byOrder']}}"><span>Tên danh mục </span> </th>
      <th ><span>Ảnh bìa</span></i></th>
      <th>EDIT </th>
      <th>DELETE </th>
    </tr>
  </thead>
  <tbody>
  <?php
    foreach ($data['menu'] as $key => $value) {
      ?>
    <tr>
      <td id="ID">  <?php echo $value['MaDM']?> </td>
      <td>  <?php echo $value['TenDM']?></td>
      <td><?php echo $value['img']?></td>
      <td>
          <form action="{{route('menu.show', ['id'=> $value['MaDM']]) }}" method="POST">
            @csrf
              <input type="hidden" name="page" value="<?php echo $data['pageCurrent']?>">
              <button  type="submit" name="edit_btn" class="btn btn-success"> EDIT</button>
          </form>
      </td>
      <td>
            <input type="hidden" name="page" id="pageCurent" value="<?php echo $data['pageCurrent']?>"> 
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
@include('admin.includes.notification')
<script src="{{asset('js/main.js/admin.js')}}"></script>