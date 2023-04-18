<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> 
   
    <link rel="stylesheet" href="{{ asset('css/main/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main/index.css') }}">
    <link rel="stylesheet" href="{{asset('css/main/service.css')}}">
    <link rel="stylesheet" href="{{asset('css/main/detail.css')}}">
    <link rel="stylesheet" href="{{asset('css/main/cart.css')}}">
    <link rel="stylesheet" href="{{asset('css/main/bill.css')}}">
    <link rel="stylesheet" href="{{asset('css/main/reponsive.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{asset('/js/vendor/jquery/jquery.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
