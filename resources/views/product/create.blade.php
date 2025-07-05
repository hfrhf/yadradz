

@extends('dashboard.dashboard')
@section('title','اضافة')



@include('dashboard.sidebar')
@section('content')

<x-form method='post' METHOD='POST' :product='$product' :update='$update' :categories='$categories' :allAttributes='$allAttributes' />



@endsection


