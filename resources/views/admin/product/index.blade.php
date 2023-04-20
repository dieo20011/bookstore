@include('admin.includes.headerContentPage')
  <div class="card-body">
    <div class="table-responsive">
      @include('admin.product.loadTable')
    </div>
      @include('admin.includes.paginationNav')
    <script>
    load("Product/Pagination")
    </script>
  </div>
</div>