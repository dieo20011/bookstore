<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between">Danh sách danh mục 
            <form action="{{ route('menu.add') }}" method="POST">
              @csrf
               <input type="hidden" name="controller" value="menu">
                <input type="hidden" name="action" value="add">
              <button  type="submit" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
                Thêm danh mục
              </button>
            </form>
    </h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      @include('admin.menu.loadTable')
    </div>
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-end">
        <li class="page-item Previous {{$data['pageCurrent'] - 1 == 0 ? "disabled" : ""}}">
          <a class="page-link "  page="{{$data['pageCurrent'] - 1}}">Previous</a>
        </li>
        <?php 
            for($i = 1; $i < $data['totalPage']; $i++) {
        ?>
        <li class="page-item <?php if(isset($data['pageCurrent']) && ($i==$data['pageCurrent'])) { echo 'active';}?>">
          <a class="page-link"  page=<?php echo $i?> ><?php echo $i?></a>
        </li>
        <?php
        }
        ?>
        <li class="page-item Next">
          <a class="page-link " page="{{$data['pageCurrent'] + 1}}" >Next</a>
        </li>
      </ul>
    </nav>

    <script>
    load("Menu/Pagination")
    </script>
  </div>
</div>