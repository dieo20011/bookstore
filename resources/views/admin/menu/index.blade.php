@include('admin.includes.headerContentPage')
  <div class="card-body">
    <div class="table-responsive">
      @include('admin.menu.loadTable')
    </div>
      @include('admin.includes.paginationNav')
    <script>
    load("Menu/Pagination")
    </script>
  </div>
</div>