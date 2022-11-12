<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th class="sortKey" column="MaTG" byOder="{{$data['byOrder']}}" >Mã tác giả </th>
      <th class="sortKey" column="MaTG" byOder="{{$data['byOrder']}}" >Tên tác giả</th>
      <th>Ảnh tác giả</th>
      <th>EDIT </th>
      <th>DELETE </th>
    </tr>
  </thead>
  <tbody>
  <?php
    foreach ($data['author'] as $key => $value) {
      ?>
    <tr>
      <td id="ID">  <?php echo $value['MaTG']?> </td>
      <td>  <?php echo $value['TenTG']?></td>
      <td>  <img style="width:100px; height: 100px"  src="{{ asset('img/author/'.$value['img']) }}" alt=""> </td>
      <td>
          <form action="{{route('author.show', ['id'=> $value['MaTG']]) }}" method="POST">
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