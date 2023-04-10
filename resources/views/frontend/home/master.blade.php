@extends('frontend.masterLayout')
@section('header')
@include('frontend.blocks.header2')
@endsection
@section('content')
<?php 
    if(isset($data['pageNew'])) {
        ?>
        @include("frontend.".$data['pageNew'])
        <?php
    } else {
?>
@include('frontend.categorys.index')
@include('frontend.products.index')
<?php } ?>
<?php
if(isset($data['login'])) {
?>
@section('login')
@include("frontend.".$data['login'])
@endsection
<?php
}
?>

@endsection