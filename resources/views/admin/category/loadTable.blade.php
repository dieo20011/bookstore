<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th class="sortKey" column="MaTL" byOder="{{$data['byOrder']}}">Mã thể loại </th>
      <th class="sortKey" column="TenTheLoai" byOder="{{$data['byOrder']}}">Tên thể loại</th>
      <th>EDIT </th>
      <th>DELETE </th>
    </tr>
  </thead>
  <tbody>
  <?php
    
    foreach ($data['category'] as $key => $value) {
      ?>
    <tr>
      <td id="ID">  <?php echo $value['MaTL']?> </td>
      <td>  <?php echo $value['TenTheLoai']?></td>
      <td>
          <form action="{{route('category.show', ['id'=> $value['MaTL']]) }}" method="POST">
            @csrf
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