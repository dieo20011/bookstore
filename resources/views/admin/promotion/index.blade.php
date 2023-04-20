@include('admin.includes.headerContentPage')
  <div class="card-body">
    <div class="table-responsive">
      @include('admin.promotion.loadTable')
    </div>
    @include('admin.includes.paginationNav')
    <script>
      load("Promotion/Pagination")
    </script>
    </div>
  </div>