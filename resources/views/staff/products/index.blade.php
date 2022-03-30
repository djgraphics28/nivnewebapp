@extends('staff.layouts.master')

@section('title','Staff Products')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Products</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  @section('js-bot')
  <script>
      //add stock Modal
        window.addEventListener('show-add-new_stock-modal', event => {
            $('#addNewStockmodal').modal('show');
        })

        window.addEventListener('hide-add-new_stock-modal', event => {
            $('#addNewStockmodal').modal('hide');
        })

        window.addEventListener('show-set-price-modal', event => {
            $('#setPriceModal').modal('show');
        })

        window.addEventListener('hide-set-price-modal', event => {
            $('#setPriceModal').modal('hide');
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

@livewire('staff-product')

@endsection
