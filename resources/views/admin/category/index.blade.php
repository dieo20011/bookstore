<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between">Danh sách thể loại
            <form action="{{ route('category.add') }}" method="POST">
              @csrf
              <input type="hidden" name="controller" value="category">
              <input type="hidden" name="action" value="add">
              <button  type="submit" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
                Thêm thể loại
              </button>
            </form>
    </h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      @include('admin.category.loadTable')
    </div>
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-end">
        <li class="page-item <?php if(isset($data['pageCurrent']) && (1 == $data['pageCurrent'])) { echo 'disabled';}?>">
          <a class="page-link " href="" page="<?php echo ($data['pageCurrent'] - 1)?> ">Previous</a>
        </li>
        <?php 
            for($i = 1; $i <= $data['totalPage']; $i++) {
        ?>
        <li class="page-item <?php if(isset($data['pageCurrent']) && ($i==$data['pageCurrent'])) { echo 'active';}?>">
          <a class="page-link " href="" page=<?php echo $i?> ><?php echo $i?></a>
        </li>
        <?php
        }
        ?>
        <li class="page-item <?php if(isset($data['pageCurrent']) && ($data['totalPage'] <= $data['pageCurrent'])) { echo 'disabled';}?>">
          <a class="page-link" page="<?php echo ($data['pageCurrent'] + 1)?> " href="">Next</a>
        </li>
      </ul>
    </nav>
    <script>
      load("Category/Pagination")
</script>

  </div>
</div>
