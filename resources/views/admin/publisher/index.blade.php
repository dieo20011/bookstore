@include('admin.includes.headerContentPage')
  <div class="card-body">
    <div class="table-responsive">
      @include('admin.publisher.loadTable')
    </div>
    @include('admin.includes.paginationNav')
    <script>
      load("Publisher/Pagination")
    </script>
    </div>
  </div>