@extends('staff.layouts.master')

@section('title','Staff Product In')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Product In</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('staff.stocks') }}">Stocks</a></li>
            <li class="breadcrumb-item active">Product In</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

@livewire('staff-stock-productin')

@endsection
