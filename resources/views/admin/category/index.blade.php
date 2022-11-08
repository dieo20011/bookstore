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
  </div>
</div>
<?php
    // include('./Views/admin/includes/formDelete.php');
 ?>
 {{-- <?php include_once('./Views/admin/includes/scripts.php'); ?>  --}}
<script>
</script>
