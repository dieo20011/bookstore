@include('admin.includes.headerContentPage')
  <div class="card-body">
    <div class="table-responsive">
      @include('admin.category.loadTable')
    </div>
    @include('admin.includes.paginationNav');
    <script>
      load("Category/Pagination")
    </script>
    </div>
  </div>
