<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-end">
      <li class="page-item Previous {{$data['pageCurrent'] - 1 == 0 ? "disabled" : ""}}">
        <a class="page-link "  page="{{$data['pageCurrent'] - 1}}">Previous</a>
      </li>
      <?php 
          for($i = 1; $i <= $data['totalPage']; $i++) {
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
