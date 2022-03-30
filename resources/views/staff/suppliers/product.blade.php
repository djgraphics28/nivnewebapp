@extends('staff.layouts.master')

@section('title','Staff Suppliers Products')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Suppliers/Products</h1>
          <h3>{{ $supplier }}</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('staff.suppliers') }}">Suppliers</a></li>
            <li class="breadcrumb-item active">Suppliers/Products</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  @section('js-bot')
  <script>
      //add stock Modal
        window.addEventListener('show-add-supplier-product-modal', event => {
            $('#addSupplierProductModal').modal('show');
        })

        window.addEventListener('hide-add-supplier-product-modal', event => {
            $('#addSupplierProductModal').modal('hide');
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

@livewire('staff-supplier-product', ['supplier_id' => $supplier_id])

@endsection
