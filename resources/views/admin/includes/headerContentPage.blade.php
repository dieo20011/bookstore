<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between">Danh sách {{$data['titlePage']}} 
            <form action="{{ route($data['title'].'.add') }}" method="POST">
              @csrf
                <input type="hidden" name="controller" value="menu">
                <input type="hidden" name="action" value="add">
              <button  type="submit" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
                Thêm {{$data['titlePage']}}
              </button>
            </form>
    </h6>
  </div>