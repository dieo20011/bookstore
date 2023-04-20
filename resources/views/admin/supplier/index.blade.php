@include('admin.includes.headerContentPage')
  <div class="card-body">
    <div class="table-responsive">
      @include('admin.supplier.loadTable')
    </div>
    @include('admin.includes.paginationNav')
    <script>
      load("Supplier/Pagination")
    </script>
    </div>
  </div>