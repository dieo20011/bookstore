@extends('frontend.masterLayout')
@section('header')
@include('frontend.blocks.header2')
@endsection

@section('content')


@if(count($books) > 0)
<div style="margin-top:40px; padding-left:30px">
    <h1>Kết quả tìm kiếm cho "{{ request('search') }}":</h1>
</div>
<div class="product-container">
    @foreach($books as $book)

    <div class="product-item">
        <div class="product-item-top">
            <div class="product-item-img">
                <?php
                    $id = $book['MaSP']
                ?>
                <a href="{{ route('detailbook', ['id'=>$id]) }}">
                    @php
                    $img = "img/product/".$book['img'];
                    @endphp
                    <img src="{{asset($img)}}" alt="">
                </a>
            </div>
            <div class="product-item-decription">
                <div class="product-item-header">
                    <a class="product-item-name">
                        <?php echo $book['TenSP']?>
                    </a>
                    <span class="product-item-author">
                        <?php echo $book['TenTG']?>
                    </span>
                </div>
                <div class="product-item-des-detail">
                    <?php echo $book['MoTa']?>
                </div>
            </div>
        </div>
        <div class="product-item-bottom">
            <div class="product-bottom-wrap">
                <div class="pricres">
                    {{-- <?php
                                        if($book['discount'] != 0) {
                                    ?> --}}
                    <div class="btn-price">
                        <?php echo "-".$book['KhuyenMai']."%"?>
                    </div>
                    {{-- <?php
                }
                                    ?> --}}
                    <div class="prices-detail">
                        <span class="prices-cost <?php if($book['discount'] != 0) echo  
                                        'line-through'?> "> <?php echo $book['DonGia']?><span
                                class="undertext">đ</span></span>
                        <span class="promotion-price">

                            <?php if($book['discount'] != 0) echo $book['discount']."<span class='undertext'>đ</span>"?>

                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<p style="display:flex; justify-content:center; width:100%; align-items: center; height: 200px;">Không tìm thấy kết quả
    nào.
</p>
@endif
@endsection