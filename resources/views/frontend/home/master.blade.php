@extends('frontend.masterLayout')

@section('header')
    @include('frontend.blocks.header2')
@endsection
@section('content')
    @if(isset($data['pageNew'])) 
        @include($data['pageNew'])
    @else
        @include('frontend.categorys.index')
        @include('frontend.products.index')
    @endif
    
    @if(isset($data['login'])) 
        @section('login')
            @include($data['login'])
        @endsection
    @endif 
@endsection