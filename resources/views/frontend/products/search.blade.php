<input type="checkbox" hidden id="menu-to-search">
<div class="app-containt-top search">
    <div class="wrap search">
        @include('frontend.categorys.CategoryList')
    </div>
</div>
<div class="header-search-title" >
    <div style="display: flex; justify-content: space-between; width: 100%; padding-bottom: 20px">
        <h1>Kết quả tìm kiếm cho "{{ request('search') }} ":</h1>
        <select name="priceSort" id="priceSort" style="outline: none; padding: 5px 10px">
            <option value="desc">Cao đến thấp</option>
            <option value="asc">Thấp đến cao</option>
        </select>
    </div>
    @if(count($data['books']) <= 0)
    <p style="display:flex; justify-content:center; width:100%; align-items: center; height: 60px;">Không tìm thấy kết quả nào nhưng bạn hãy tham khảo sách dưới đây nhé!
    </p>
    @endif
</div>
<div class="product-container product-container-search ">
  @include('frontend.products.listProductForSearch')
</div>


<script>
     $("#priceSort").change(function () {
        let price = $(this).val();
        console.log(price);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: "/searchByPrice",
            method: "POST",
            data: { price: price },
            success: function (data) {
                $(".product-container.product-container-search").html(data);
            },
        });
    });
</script>