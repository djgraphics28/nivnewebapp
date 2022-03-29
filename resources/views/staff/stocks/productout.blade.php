@extends('staff.layouts.master')

@section('title','Staff Product In')

@section('css-top')

@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Truck Loading/Return</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('staff.stocks') }}">Stocks</a></li>
            <li class="breadcrumb-item active">Truck Loading/Return</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

@section('js-bot')
  <script>
      //add stock Modal
        window.addEventListener('show-product_tracking-modal', event => {
            $('#productTrackingModal').modal('show');
        })

        window.addEventListener('hide-product_tracking-modal', event => {
            $('#productTrackingModal').modal('hide');
        })



        //add equipment Modal
        window.addEventListener('show-add-equipment-modal', event => {
            $('#addEquipmentModal').modal('show');
        })

        window.addEventListener('hide-add-equipment-modal', event => {
            $('#addEquipmentModal').modal('hide');
        })

        //view stock Modal
        window.addEventListener('show-view-stock-modal', event => {
            $('#viewStockModal').modal('show');
        })

        window.addEventListener('hide-view-stock-modal', event => {
            $('#viewStockModal').modal('hide');
        })

        window.addEventListener('swal:modal', event => {
            swal({
                title: event.detail.message,
                text: event.detail.text,
                icon: event.detail.type,
            });
        });

        window.addEventListener('swal:confirm', event => {
            swal({
                    title: event.detail.message,
                    text: event.detail.text,
                    icon: event.detail.type,
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.livewire.emit('remove');
                    }
            });
        });
  </script>
@endsection

@livewire('staff-stock-productout')

@endsection
