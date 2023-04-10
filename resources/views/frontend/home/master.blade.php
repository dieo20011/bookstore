@extends('frontend.masterLayout')
@section('header')
@include('frontend.blocks.header2')
@endsection
@section('content')
@include('frontend.categorys.index')
@include('frontend.products.index')
@endsection

