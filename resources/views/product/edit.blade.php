@extends('dashboard.dashboard')
@section('title','تعديل')



@include('dashboard.sidebar')
@section('content')

<x-form method='post' :product='$product'   METHOD='PUT'  :update='$update' :categories='$categories' :allAttributes='$allAttributes' />



@endsection

