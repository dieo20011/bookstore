@include('admin.includes.headerContentPage')
  <div class="card-body">
    <div class="table-responsive">
      @include('admin.author.loadTable')
    </div>
    @include('admin.includes.paginationNav');
    <script>
      load("Author/Pagination")
    </script>
    </div>
  </div>

